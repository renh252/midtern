<?php require __DIR__ . '/../parts/init.php';
$title = "文章管理"; // 這個變數可修改，用在<head>的標題
$pageName = "demo"; // 這個變數可修改，用在sidebar的按鈕active

$perPage = 25; # 每一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$birth_begin = empty($_GET['birth_begin']) ? '' : $_GET['birth_begin'];
$birth_end = empty($_GET['birth_end']) ? '' : $_GET['birth_end'];

$where = ' WHERE 1 '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%"); # 字串內容做 SQL 引號的跳脫, 同時前後標單引號
  $where .= " AND (posts.title LIKE $keyword_ OR users.user_name LIKE $keyword_ OR posts.status LIKE $keyword_) ";
}
if ($birth_begin) {
  $t = strtotime($birth_begin); # 把日期字串轉換成 timestamp
  if ($t !== false) {
    $where .= sprintf(" AND posts.created_at >= '%s' ", date('Y-m-d', $t));
  }
}
if ($birth_end) {
  $t = strtotime($birth_end); # 把日期字串轉換成 timestamp
  if ($t !== false) {
    $where .= sprintf(" AND posts.created_at <= '%s' ", date('Y-m-d', $t));
  }
}

$t_sql = "SELECT COUNT(1) FROM `posts` JOIN users ON posts.user_id = users.user_id $where";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 總頁數
$totalPages = ceil($totalRows / $perPage);
$rows = []; # 設定預設值
if ($totalRows > 0) {
  if ($page > $totalPages) {
    # 用戶要看的頁碼超出範圍, 跳到最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  # 取得該分頁的文章資料
  $sql = sprintf("SELECT posts.*, users.user_name FROM posts
  JOIN users ON posts.user_id = users.user_id
  %s ORDER BY is_pinned DESC, posts.id DESC LIMIT %s, %s",
  $where, ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();
  }



?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
<!--begin::Body-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.status-select').change(function() {
    var select = $(this);
    var postId = select.data('post-id');
    var newStatus = select.val();
    var originalStatus = select.data('original-status');

    if (confirm('您確定要更改貼文狀態嗎？')) {
      $.ajax({
        url: 'update_post_status.php',
        method: 'POST',
        data: { post_id: postId, status: newStatus },
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            alert('狀態已更新');
            select.data('original-status', newStatus);
          } else {
            alert('更新失敗：' + response.message);
            select.val(originalStatus);
          }
        },
        error: function() {
          alert('發生錯誤，請稍後再試');
          select.val(originalStatus);
        }
      });
    } else {
      select.val(originalStatus);
    }
  });
});
</script>


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
      type="search" placeholder="搜尋文章標題、作者、狀態等" aria-label="Search">
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
        <ul class="pagination">
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
              # $qs = array_filter($_GET); # 去除值是空字串的項目
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
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
          <th>#</th>
            <th>標題</th>
            <th>作者id</th>
            <th>作者暱稱</th>
            <th>按讚數</th>
            <th>收藏數</th>
            <th>置頂</th>
            <th>建立時間</th>
            <th>更新時間</th>
            <th>狀態</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= htmlentities($r['title']) ?></td>
              <td><?= htmlentities($r['user_id']) ?></td>
              <td><?= htmlentities($r['user_name']) ?></td>
              <td><?= $r['likes_count'] ?></td>
              <td><?= $r['bookmark_count'] ?></td>
              <td><?= $r['is_pinned'] ? '是' : '否' ?></td>
              <td><?= $r['created_at'] ?></td>
              <td><?= $r['updated_at'] ?></td>
              <td>
                <select class="form-select status-select" data-post-id="<?= $r['id'] ?>" data-original-status="<?= $r['status'] ?>">
                <option value="已發佈" <?= $r['status'] == '已發佈' ? 'selected' : '' ?>>已發佈</option>
                <option value="被檢舉" <?= $r['status'] == '被檢舉' ? 'selected' : '' ?>>被檢舉</option>
                <option value="已刪除" <?= $r['status'] == '已刪除' ? 'selected' : '' ?>>已刪除</option>
              </select>
              </td>
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
        window.location.href = 'post.php';
      }
    });

    searchForm.addEventListener('submit', function(event) {
      if (searchInput.value.trim() === '') {
        event.preventDefault();
        window.location.href = 'post.php';
      }
    });
  }
});
</script>

  <!--end::Script-->
</body>
<!--end::Body-->

</html>
