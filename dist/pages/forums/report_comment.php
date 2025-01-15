<?php require __DIR__ . '/../parts/init.php';
$title = "檢舉列表(留言)";
$pageName = "demo";

$perPage = 25;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$qs = [];
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$qs['keyword'] = $keyword;

$where = ' WHERE 1 ';

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%");
  $where .= " AND (
    comments.body LIKE $keyword_ OR
    users.user_name LIKE $keyword_ OR
    reporters.user_name LIKE $keyword_ OR
    reports.status LIKE $keyword_ OR
    reports.created_at LIKE $keyword_
  )";
}

$t_sql = "SELECT COUNT(1) FROM reports
          JOIN comments ON reports.target_id = comments.id
          JOIN users ON comments.user_id = users.user_id
          JOIN users AS reporters ON reports.reporter_id = reporters.user_id
          $where";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);

$rows = []; // 初始化 $rows 為空數組

if ($totalRows > 0) {
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }

  $sql = sprintf(
    "SELECT reports.*, comments.user_id AS reports_user_id, comments.body AS reports_body, users.user_name AS reports_user_name, reporters.user_name AS target_name
    FROM reports
    JOIN comments ON reports.target_id = comments.id
    JOIN users ON comments.user_id = users.user_id
    JOIN users AS reporters ON reports.reporter_id = reporters.user_id
    %s
    ORDER BY reports.created_at DESC, reports.id DESC
    LIMIT %s, %s",
    $where,
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}

$pageRange = 2;
$startPage = max($page - $pageRange, 1);
$endPage = min($page + $pageRange, $totalPages);

if ($startPage > 1) {
  $startPage = max($startPage, 2);
}
if ($endPage < $totalPages) {
  $endPage = min($endPage, $totalPages - 1);
}

?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>

<style>
  .custom-pagination-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 2rem;
  }

  .custom-pagination .pagination {
    display: inline-flex;
    flex-wrap: wrap;
    justify-content: center;
    background-color: #f8f9fa;
    padding: 5px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .custom-pagination .page-item {
    margin: 2px;
  }

  .custom-pagination .page-link {
    border: none;
    color: #495057;
    border-radius: 3px;
    padding: 6px 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    min-width: 38px;
    text-align: center;
  }

  .custom-pagination .page-item.active .page-link,
  .custom-pagination .page-link:hover:not(.disabled) {
    background-color: #007bff;
    color: #fff;
  }

  .custom-pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #e9ecef;
  }

  .pagination-info {
    margin-top: 1rem;
    color: #6c757d;
  }

  /* 三角形圖示樣式 */
  .triangle-left,
  .triangle-right {
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    position: relative;
    top: 0px;
    /* 微調三角形位置 */
  }

  .triangle-left {
    border-right: 10px solid #495057;
  }

  .triangle-right {
    border-left: 10px solid #495057;
  }

  .page-item:not(.disabled):hover .triangle-left {
    border-right-color: #fff;
  }

  .page-item:not(.disabled):hover .triangle-right {
    border-left-color: #fff;
  }

  .page-item.disabled .triangle-left {
    border-right-color: #6c757d;
  }

  .page-item.disabled .triangle-right {
    border-left-color: #6c757d;
  }

  .prev-page,
  .next-page {
    padding: 6px 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    /* 確保高度與其他按鈕一致 */
  }

  .sort-icon {
    display: inline-block;
    margin-left: 5px;
    cursor: pointer;
    color: black;
    user-select: none;
  }

  .sort-icon.asc::after {
    content: '▲';
  }

  .sort-icon:not(.asc)::after {
    content: '▼';
  }
</style>
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <?php include ROOT_PATH . 'dist/pages/parts/navbar.php' ?>
    <?php include ROOT_PATH . 'dist/pages/parts/sidebar.php' ?>
    <br>
    <main class="app-main pt-5">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-8">
            <div class="card">
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-md-6 mb-2 mb-md-0">
                    <div class="btn-group w-100" role="group" aria-label="Report type">
                      <a href="/midtern/dist/pages/forums/report.php" class="btn btn-outline-primary">貼文檢舉</a>
                      <a href="/midtern/dist/pages/forums/report_comment.php" class="btn btn-outline-primary active">留言檢舉</a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <form class="d-flex" role="search" id="searchForm">
                      <input class="form-control me-2"
                        id="searchInput"
                        name="keyword"
                        value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>"
                        type="search" placeholder="搜尋留言標題、被檢舉人、檢舉人等" aria-label="Search">
                      <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                      <tr>
                        <th>#<span class="sort-icon" data-column="id"></span></th>
                        <th>被檢舉留言<span class="sort-icon" data-column="reports_body"></span></th>
                        <th>被檢舉人id<span class="sort-icon" data-column="reports_user_id"></span></th>
                        <th>被檢舉人暱稱<span class="sort-icon" data-column="reports_user_name"></span></th>
                        <th>檢舉人id<span class="sort-icon" data-column="reporter_id"></span></th>
                        <th>檢舉人暱稱<span class="sort-icon" data-column="target_name"></span></th>
                        <th>檢舉時間<span class="sort-icon" data-column="created_at"></span></th>
                        <th>狀態<span class="sort-icon" data-column="status"></span></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($rows as $r): ?>
                        <tr>
                          <td><?= $r['id'] ?></td>
                          <td><?= htmlentities($r['reports_body']) ?></td>
                          <td><?= htmlentities($r['reports_user_id']) ?></td>
                          <td><?= htmlentities($r['reports_user_name']) ?></td>
                          <td><?= htmlentities($r['reporter_id']) ?></td>
                          <td><?= htmlentities($r['target_name']) ?></td>
                          <td><?= htmlentities($r['created_at']) ?></td>
                          <td><?= htmlentities($r['status']) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                  <nav aria-label="Page navigation" class="custom-pagination">
                    <ul class="pagination">
                      <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = 1;
                                                    echo http_build_query($qs); ?>" aria-label="First">第一頁</a>
                      </li>
                      <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link prev-page" href="?<?php $qs['page'] = max(1, $page - 1);
                                                              echo http_build_query($qs); ?>" aria-label="Previous">
                          <span class="triangle-left"></span>
                        </a>
                      </li>
                      <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                          <a class="page-link" href="?<?php $qs['page'] = $i;
                                                      echo http_build_query($qs); ?>"><?= $i ?></a>
                        </li>
                      <?php endfor; ?>
                      <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link next-page" href="?<?php $qs['page'] = min($totalPages, $page + 1);
                                                              echo http_build_query($qs); ?>" aria-label="Next">
                          <span class="triangle-right"></span>
                        </a>
                      </li>
                      <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $qs['page'] = $totalPages;
                                                    echo http_build_query($qs); ?>" aria-label="Last">最後一頁</a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars) 可自定義的覆蓋滾動條-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(popperjs for Bootstrap 5) Bootstrap彈出元素"（如工具提示和彈出窗口）-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)-->
  <!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <script src="<?= ROOT_URL ?>/dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)-->
  <!--begin::OverlayScrollbars Configure 設定滾動條-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      // 當鼠標離開滾動區域時，滾動條會自動隱藏；允許用戶通過點擊滾動條來進行滾動
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    // DOMContentLoaded確保在DOM完全加載後執行代碼
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        // 初始化滾動條，並傳遞配置選項，如主題和自動隱藏行為
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const searchForm = document.getElementById('searchForm');

      if (searchInput && searchForm) {
        searchInput.addEventListener('search', function(event) {
          if (this.value === '') {
            event.preventDefault();
            window.location.href = 'report_comment.php';
          }
        });

        searchForm.addEventListener('submit', function(event) {
          if (searchInput.value.trim() === '') {
            event.preventDefault();
            window.location.href = 'report_comment.php';
          }
        });
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const sortIcons = document.querySelectorAll('.sort-icon');

    sortIcons.forEach(icon => {
      icon.addEventListener('click', function() {
        // 移除所有其他图标的 asc 类
        sortIcons.forEach(otherIcon => {
          if (otherIcon !== icon) {
            otherIcon.classList.remove('asc');
          }
        });

        // 切换当前图标的 asc 类
        this.classList.toggle('asc');

        // 获取排序方向和列名
        const isAscending = this.classList.contains('asc');
        const columnName = this.getAttribute('data-column');

        // 调用排序函数
        sortTable(columnName, isAscending);
      });
    });

    function sortTable(columnName, isAscending) {
      // 构建查询参数
      const params = new URLSearchParams(window.location.search);
      params.set('sort', columnName);
      params.set('order', isAscending ? 'asc' : 'desc');

      // 重定向到带有新排序参数的页面
      window.location.href = `${window.location.pathname}?${params.toString()}`;
    }
  });
  </script>
  <!--end::OverlayScrollbars Configure-->

  <!--end::Script-->
</body>
<!--end::Body-->

</html>
