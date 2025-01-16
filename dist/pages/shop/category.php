<?php
// 先載入初始化檔案
require __DIR__ . '/../parts/init.php';

// 設定標題和頁面名稱
$title = "商品類別";
$pageName = "category";

// 啟動 Session
// session_start();
// ob_start();

// 檢查是否已登入
// if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
//     header("Location: login.php");  // 如果未登入，跳轉回登入頁面
//     exit;
// }

// -------------- php編輯區 ------------------


$perPage = 5; # 每一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
  //die(); # 同 exit 的功能, 但可以回傳字串或編號
}

$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];
// $birth_begin = empty($_GET['birth_begin']) ? '' : $_GET['birth_begin'];
// $birth_end = empty($_GET['birth_end']) ? '' : $_GET['birth_end'];

/***************** 搜尋關鍵字 ****************/
$where = ' WHERE parent_id IS NULL '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%"); # 字串內容做 SQL 引號的跳脫, 同時前後標單引號
  $where .= " AND ( product_name LIKE $keyword_ OR category_tag LIKE $keyword_ OR product_id LIKE $keyword_  OR product_description LIKE $keyword_ ) ";
}

# 查詢總筆數
$t_sql = "SELECT COUNT(1) 
          FROM  
            Categories 
          $where";

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
  // Categories
  $sql = sprintf("SELECT  * FROM Categories 
    %s ORDER BY	category_id  DESC LIMIT %d, %d",
    $where,
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料


  // Categories-child
  $sql_child = "SELECT  * FROM Categories 
    WHERE parent_id IS NOT NULL ORDER BY	category_id  DESC "
  ;
  $rows_child = $pdo->query($sql_child)->fetchAll(); # 取得該分頁的資料

}



// ----------------- php編輯區END ---------------

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $title; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

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
                            <h3 class="mb-0">商品類別</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">商品類別</li>
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
<!-- --------- 內容編輯區 --------- -->

<div class="container">
  <div class="row mt-2 mb-2">
    <div class="col-6">
      <a href="./add-category.php" class="btn btn-outline-secondary" >新增類別</a>
    </div>
    <!-- 搜尋框 -->
    <div class="col-6">
      <form class="d-flex" role="search">
        <input class="form-control me-2" name="keyword"
          value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>" type="search"
          placeholder="編號/名稱/類別/介紹" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
  

  <div class="row">
    <div class="col">
      <table class="table table-bordered ">
        <thead>
          <tr class="list-title">
            <th><i class="fa-solid fa-trash"></i></th>
            <th>類別編號</th>
            <th>類別</th>
            <td hidden></td>
            <td hidden></td>
            <th>子類別</th>
            <th>tag</th>
            <th>描述</th>
            <th><i class="fa-solid fa-pen-to-square"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr class="list-product">
              <!-- 1 -->
              <td>
                <a href="javascript:" onclick="deleteCategory(event)">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
              <!-- 2 -->
              <td><?= $r['category_id'] ?></td>
              <!-- 3 -->
              <td><?= htmlentities($r['category_name']) ?></td>
              <td hidden></td>
              <td hidden></td>
              <!-- 5 -->
              <td><a href="add-childCategory.php?parent_id=<?= $r['category_id'] ?>"><i class="fa-solid fa-square-plus"></i></a></td>
              <!-- 6 -->
              <td><?= htmlentities($r['category_tag']) ?></td>
              <!-- 7 -->
              <td><?= htmlentities($r['category_description']) ?></td>
              <!-- 8 -->
              <td>
                <a href="edit-category.php?category_id=<?= $r['category_id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
              </td>

            <!-- 子類別 -->
            <?php foreach ($rows_child as $r_child):
              if ($r_child['parent_id'] === $r['category_id']): ?>
                <tr class="list-child">
                  <!-- 1 -->
                  <td>
                    <a href="javascript:" onclick="deleteCategory(event)">
                      <i class="fa-solid fa-trash text-warning"></i>
                    </a>
                  </td>
                  <!-- 2 -->
                  <td>( <?= $r_child['category_id'] ?> )</td>
                  <!-- 3 -->
                  <td></td>
                  <!-- hidden -->
                  <td hidden><?= $r_child['parent_id'] ?></td>
                  <td hidden><?= $r['category_name'] ?></td>
                  <!-- 5 -->
                  <td><?= htmlentities($r_child['category_name']) ?></td>
                  <!-- 6 -->
                  <td><?= htmlentities($r_child['category_tag']) ?></td>
                  <!-- 7 -->
                  <td><?= htmlentities($r_child['category_description']) ?></td>
                  <td>
                    <a href="edit-childCategory.php?parent_name=<?= $r['category_name'] ?>&category_id=<?= $r_child['category_id'] ?>">
                      <i class="fa-solid fa-pen-to-square text-warning"></i>
                    </a>
                  </td>
                </tr>
              <?php endif; endforeach; ?>

          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 頁碼 -->
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

</div> <!-- end container -->


<!-- --------- 內容編輯區END --------- -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>/dist/js/adminlte.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true,
                    },
                });
            }
        });

/*------------script編輯區--------------*/

const deleteCategory = e => {
    e.preventDefault(); // 沒有要連到某處
    const tr = e.target.closest('tr');
    const [
      ,
      td_category_id ,
      td_category_name,
      td_parent_id_hidden,
      td_parent_name_hidden,
      td_category_child_name,
      td_category_tag,
      td_category_description,
      
    ] = tr.querySelectorAll('td');
    const category_id = td_category_id.innerHTML.match(/\d+/)[0];
    const category_name = td_category_name.innerHTML;
    const child_name = td_category_child_name.innerHTML;
    const parent_name = td_parent_name_hidden.innerHTML;
    const parent_id = td_parent_id_hidden.innerHTML;
    // console.log([td_product_id.innerHTML, product_name.innerHTML]);
    //------------刪除類別---------------------
    if(category_name){
      if (confirm(`是否要刪除類別 : 編號 ${category_id}【 ${category_name} 】?`)) {
      // 使用 JS 做跳轉頁面
      // location.href = `del.php?category_id=${category_id}`;
      fetch(`del.php?category_id=${category_id}`, {
        method: 'GET'
      }).then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            alert('資料已刪除') // 呈現 modal
            location.reload(true);
          } else {
            alert(obj.message)
          }

        }).catch(err => console.error(err));
      }
    }
    // ------------刪除子類別---------------------
    else if(child_name){
      if (confirm(`是否要刪除 ${parent_id}. ${parent_name} 的子類別 : ${category_id}  【${child_name}】 ?`)) {
      // 使用 JS 做跳轉頁面
      // location.href = `del.php?category_id=${category_id}`;
        fetch(`del.php?category_id=${category_id}`, {
          method: 'GET'
        }).then(r => r.json())
          .then(obj => {
            console.log(obj);
            if (obj.success) {
              // 成功刪除              
              alert(obj.message) ;
              location.reload(true);
            } else {
              // 刪除失敗
              alert(obj.message);
              location.reload(true);
            }

          }).catch(err => console.error(err));

      }
    }
    
  }

/*------------script編輯區END--------------*/

    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
