<?php
require __DIR__ . '/../parts/init.php';
$title = "寵物列表";
$pageName = "pet-list";

$perPage = 25; #每頁幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); #redirect 跳轉頁面 (後端)
  exit; #離開程式 同die('字串');
}

$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];
$birth_begin = empty($_GET['birth_begin']) ? '' : $_GET['birth_begin'];
$birth_end = empty($_GET['birth_end']) ? '' : $_GET['birth_end'];

$where = 'WHERE 1'; #SQL查詢條件開頭
if (!empty($keyword)) {
  $keyword_ = $pdo->quote("%$keyword%"); // 字串加上%之後跳脫引號，避免SQL注入
  $where .= " AND (name LIKE $keyword_ OR mobile LIKE $keyword_)"; #SQL查詢條件結尾
}

if (!empty($birth_begin)) {
  $t = strtotime($birth_begin); #將字串轉換成時間戳記
  if ($t !== false) {
    $where .= sprintf(" AND birthday >= '%s' ", date('Y-m-d', $t));
  }
}
if (!empty($birth_end)) {
  $t = strtotime($birth_end); #將字串轉換成時間戳記
  if ($t !== false) {
    $where .= sprintf(" AND birthday <= '%s' ", date('Y-m-d', $t));
  }
}

// 流程:用$pdo做query('select式')再拿去做fetch取值，最後解析json
$t_sql = "SELECT COUNT(1) 
FROM `pets` $where";

#總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];  // 索引式陣列取值

#總頁數
$totalPages = ceil($totalRows / $perPage); #ceil無條件進位

$rows = []; //設定預設值
if ($totalRows > 0) {
  if ($page > $totalPages) {
    # 用戶要看的頁數超出範圍
    header('Location: ?page=' . $totalPages);
    exit;
  }
  #取第一頁資料
  $sql = sprintf(
    "SELECT * FROM pets 
    %s
    ORDER BY id DESC LIMIT %s,%s",
    $where,
    $perPage * ($page - 1),
    $perPage
  );
  #取得該分頁的資料
  $rows = $pdo->query($sql)->fetchAll();
}

$qs = array_filter($_GET); #去除值為空的項目
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
    <main class="app-main pt-5">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">這裡是標題</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">breadcrumb</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <!-- 這裡是內容 -->
          <div class="row">
            <div class="col-8">
              <ul class="pagination">
                <li class="page-item <?= $page === 1 ? 'disabled' : '' ?>">
                  <a class="page-link "
                    href="?<?= $qs['page'] = 1;
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
                <!-- for迴圈產生按鈕 -->
                <?php for (
                  $i = ($page >= ($totalPages - 1)) ?
                    (($page == $totalPages - 1) ? $page - 3 : $page - 4) : ($page - 2);
                  $i <= (($page <= 2) ? 5 : ($page + 2));
                  $i++
                ):
                  // 限制分頁按鈕的邊界
                  if ($i >= 1 and $i <= $totalPages):
                    $qs = array_filter($_GET); #去除值為空的項目
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
                  <a class="page-link" href="?
                            <?php $qs['page'] = $totalPages;
                            echo http_build_query($qs) ?>">
                    <i class="fa-solid fa-angles-right"></i>
                  </a>
                </li>
              </ul>
            </div>

            <div class="col-4">
              <form class="d-flex" role="search">
                <input class="form-control me-2"
                  name="keyword" value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>"
                  type="search" placeholder="搜尋" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="pet-info" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th><i class="fa-regular fa-trash-can"></i></th>
                    <th>id</th>
                    <th>name</th>
                    <th>species</th>
                    <th>variety</th>
                    <th>gender</th>
                    <th>birthday</th>
                    <th>weight</th>
                    <th>chip_number</th>
                    <th>is_adopted</th>
                    <th><i class="fa-regular fa-pen-to-square"></i></th>
                    <th>main_photo</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($rows as $r):
                  ?>
                    <tr>
                      <td><a href="javascript:" onclick="deleteOne(event)">
                          <i class="fa-regular fa-trash-can"></i>
                        </a></td>
                      <td><?= $r['id'] ?></td>
                      <td><?= $r['name'] ?></td>
                      <td><?= $r['species'] ?></td>
                      <td><?= $r['variety'] ?></td>
                      <td><?= $r['gender'] ?></td>
                      <td><?= $r['birthday'] ?></td>
                      <td><?= $r['weight'] ?></td>
                      <td><?= $r['chip_number'] ?></td>
                      <td><?= $r['is_adopted'] ?></td>
                      <td><a href="pet-edit.php?id=<?= $r['id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a></td>
                      <th><?php if (!empty($r['main_photo'])):
                          ?>
                          <img src="./pets_photo/<?= $r['main_photo'] ?>" alt="" width="100px">
                        <?php endif; ?>
                      </th>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th><i class="fa-regular fa-trash-can"></i></th>
                    <th>id</th>
                    <th>name</th>
                    <th>species</th>
                    <th>variety</th>
                    <th>gender</th>
                    <th>birthday</th>
                    <th>weight</th>
                    <th>chip_number</th>
                    <th>is_adopted</th>
                    <th><i class="fa-regular fa-pen-to-square"></i></th>
                    <th>main_photo</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <script>
    const deleteOne = e => {
        e.preventDefault(); //取消超連結導向
        const tr = e.target.closest('tr');
        const [, td_id, td_name] = tr.querySelectorAll('td'); //陣列的解構賦值
        const id = parseInt(td_id.innerHTML);
        const name = td_name.innerHTML;
        console.log('刪除', id, name);
        if (confirm(`是否要刪除編號為 ${id} 名字為 ${name} 的資料?`)) {
            // 使用javascript做跳轉頁面
            location.href = `pet-del.php?id=${id}`;
        }
    }
</script>
  <!--begin::Third Party Plugin(OverlayScrollbars) 可自定義的覆蓋滾動條-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!--end::Required Plugin(Bootstrap 5)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <script src="<?=ROOT_URL?>dist/js/adminlte.js"></script>
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
  <!-- OPTIONAL SCRIPTS 額外功能&實作-->
  
  <!--end::Script-->
</body>
<!--end::Body-->

</html>