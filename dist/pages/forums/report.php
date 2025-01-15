<?php require __DIR__ . '/../parts/init.php';
$title = "檢舉列表(貼文)"; // 這個變數可修改，用在<head>的標題
$pageName = "demo"; // 這個變數可修改，用在sidebar的按鈕active

$perPage = 25; # 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];

$where = ' WHERE 1 '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%");
  $where .= " AND (
    posts.title LIKE $keyword_ OR
    users.user_name LIKE $keyword_ OR
    reporters.user_name LIKE $keyword_ OR
    reports.status LIKE $keyword_ OR
    reports.created_at LIKE $keyword_
  )";
}

$t_sql = "SELECT COUNT(1) FROM reports
          JOIN posts ON reports.target_id = posts.id
          JOIN users ON posts.user_id = users.user_id
          JOIN users AS reporters ON reports.reporter_id = reporters.user_id
          $where";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 總頁數
$totalPages = ceil($totalRows / $perPage);

if ($totalRows > 0) {
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }

  # 取得該分頁的檢舉資料
  $sql = sprintf(
    "SELECT reports.*, posts.user_id AS reports_user_id, posts.title AS reports_title, users.user_name AS reports_user_name, reporters.user_name AS target_name
    FROM reports
    JOIN posts ON reports.target_id = posts.id
    JOIN users ON posts.user_id = users.user_id
    JOIN users AS reporters ON reports.reporter_id = reporters.user_id
    %s
    ORDER BY reports.created_at DESC, reports.id DESC
    LIMIT %s, %s",
    $where, ($page - 1) * $perPage, $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}



?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper 網頁的主要內容在這-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <?php include ROOT_PATH . 'dist/pages/parts/navbar.php' ?>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <?php include ROOT_PATH . 'dist/pages/parts/sidebar.php' ?>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <br>
    <main class="app-main pt-5">
    <div class="container">
  <div class="row mt-2">

    <div class="col-6"></div>
    <div class="col-6">
  <form class="d-flex" role="search" id="searchForm">
    <input class="form-control me-2"
      id="searchInput"
      name="keyword"
      value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>"
      type="search" placeholder="搜尋文章標題、被檢舉人、檢舉人等" aria-label="Search">
    <button class="btn btn-outline-primary" type="submit">Search</button>
  </form>
</div>
  </div>
  <div class="row mt-2">
    <div class="col">
      <?php
      $qs = array_filter($_GET); # 去除值是空字串的項目
      ?>
      <nav aria-label="Page navigation example">
        <!-- 讓 pagination 和按鈕都放入 flex 容器內 -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <ul class="pagination mb-0">
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?php $qs['page'] = 1;
                                          echo http_build_query($qs) ?>">
                <i class="fa-solid fa-angles-left"></i>
              </a>
            </li>
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?php $qs['page'] = $page - 1;
                                          echo http_build_query($qs) ?>">
                <i class="fa-solid fa-angle-left"></i>
              </a>
            </li>

            <?php for ($i = $page - 5; $i <= $page + 5; $i++):
              if ($i >= 1 and $i <= $totalPages):
                $qs['page'] = $i;
            ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                  <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                </li>
            <?php endif;
            endfor; ?>

            <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?php $qs['page'] = $page + 1;
                                          echo http_build_query($qs) ?>">
                <i class="fa-solid fa-angle-right"></i>
              </a>
            </li>
            <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?php $qs['page'] = $totalPages;
                                          echo http_build_query($qs) ?>">
                <i class="fa-solid fa-angles-right"></i>
              </a>
            </li>
          </ul>

          <!-- 讓按鈕保持在同一行並對齊右側 -->
          <div>
          <div>
          <a href="/midtern/dist/pages/forums/report.php" class="btn btn-primary">貼文檢舉</a>
          <a href="/midtern/dist/pages/forums/report_comment.php" class="btn btn-primary">留言檢舉</a>
</div>

          </div>
        </div>
      </nav>
    </div>
</div>

  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
          <th>#</th>
            <th>被檢舉文章</th>
            <th>被檢舉人id</th>
            <th>被檢舉人暱稱</th>
            <th>檢舉人id</th>
            <th>檢舉人暱稱</th>
            <th>檢舉時間</th>
            <th>狀態</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= htmlentities($r['reports_title']) ?></td>
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
  <!--end::OverlayScrollbars Configure-->
  <script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const searchForm = document.getElementById('searchForm');

  if (searchInput && searchForm) {
    searchInput.addEventListener('search', function(event) {
      if (this.value === '') {
        event.preventDefault();
        window.location.href = 'report.php';
      }
    });

    searchForm.addEventListener('submit', function(event) {
      if (searchInput.value.trim() === '') {
        event.preventDefault();
        window.location.href = 'report.php';
      }
    });
  }
});
</script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>
