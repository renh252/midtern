<?php
require __DIR__ . '/../parts/init.php';
$title = "平台支出管理";
$pageName = "expenses";

// 查詢記錄人員的帳號
$petSql = "SELECT `manager_account` FROM manager";
$pets = $pdo->query($petSql)->fetchAll(PDO::FETCH_ASSOC);

$perPage = 25; # 每一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
}
$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];

$where = ' WHERE 1 '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%"); # 字串內容做 SQL 引號的跳脫, 同時前後標單引號
  $where .= " AND ( expense_purpose LIKE $keyword_ OR created_by LIKE $keyword_) ";
}
$t_sql = "SELECT COUNT(*) FROM `expenses` $where";

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

  # 取第一頁的資料
  $sql = sprintf("SELECT expenses.*, manager.id AS manager_id, manager.manager_account
FROM expenses
JOIN manager ON expenses.created_by = manager.id %s
ORDER BY expenses.id DESC 
  LIMIT %d, %d", $where, ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料
}


?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    <?php include ROOT_PATH . 'dist/pages/parts/navbar.php' ?>
    <?php include ROOT_PATH . 'dist/pages/parts/sidebar.php' ?>
    <main class="app-main pt-5">
      <div class="app-content-header">
        <div class="row">
          <div class="col-sm-6">
            <h3 class="mb-0">支出管理</h3>
          </div>
          <div class="col-sm-6">
            <div class="row mt-2">
              <div class="col"></div>
              <div class="col-9">
                <form class="d-flex" role="search">
                  <input class="form-control me-2" name="keyword"
                    value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>" type="search"
                    placeholder="搜尋支出項目、記錄人員編號" aria-label="Search">
                  <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
              </div>
            </div>
            </ol>
          </div>
        </div>
      </div>
      <div class="app-content">
        <div class="container-fluid">

          <div class="row mt-4 align-items-center">

            <div class="col-6">
              <?php
              $qs = array_filter($_GET); # 去除值是空字串的項目
              ?>
              <nav aria-label="Page navigation">
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
                      #$qs = array_filter($_GET); # 去除值是空字串的項目
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
            <div class="col-6 mb-3" style="display:flex;  justify-content: end;">
            <a href="add_expenses.php" class="btn btn-outline-primary"><i class="fa-solid fa-plus p-2"></i>新增資料</a>
          </div>
          </div>
          <div class="row">
            <div class="col">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th><i class="fa-solid fa-trash"></i></th>
                    <th>支出編號</th>
                    <th>支出項目</th>
                    <th>支出金額</th>
                    <th>支出日期</th>
                    <th>支出描述</th>
                    <th style="display: none;">退款編號</th>
                    <th>記錄人員</th>
                    <th><i class="fa-solid fa-pen-to-square"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rows as $r): ?>
                    <tr>
                      <td><a href="javascript:" onclick="deleteOne(event)">
                          <i class="fa-solid fa-trash"></i>
                        </a></td>
                      <td><?= $r['id'] ?></td>
                      <td><?= $r['expense_purpose'] ?></td>
                      <td><?= $r['amount'] ?></td>
                      <td><?= $r['expense_date'] ?></td>
                      <td><?= $r['e_description'] ?></td>
                      <td style="display: none;"><?= $r['refund_id'] ?></td>
                      <td><?= $r['manager_account'] ?></td>
                      <td><a href="edit_expenses.php?bn_id=<?= $r['id'] ?>">
                          <i class="fa-solid fa-pen-to-square"></i>
                        </a></td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
  </div>
  <?php include __DIR__ . '/parts/html-scripts.php' ?>
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars) 可自定義的覆蓋滾動條-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    document.addEventListener('DOMContentLoaded', function () {
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

  <!--end::Script-->
</body>
<script>
  const deleteOne = e => {
    e.preventDefault(); // 沒有要連到某處
    const tr = e.target.closest('tr');
    const [, td_id, td_name, , , , ,] = tr.querySelectorAll('td');
    const bn_id = td_id.innerHTML.trim();
    const bn_name = td_name.innerHTML;
    console.log([bn_name.innerHTML]);
    if (confirm(`是否要刪除支出編號為 ${bn_id} ，支出項目為 ${bn_name} 的支出紀錄?`)) {
      // 使用 JS 做跳轉頁面
      location.href = `del_expenses.php?id=${bn_id}`;
    }
  };
</script>

</html>