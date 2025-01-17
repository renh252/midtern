<?php
// 先載入初始化檔案
require __DIR__ . '/../parts/init.php';

// 設定標題和頁面名稱
$title = "新增子類別";
$pageName = "add_categoryChild";

// 啟動 Session
// session_start();
// ob_start();

// 檢查是否已登入
// if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
//     header("Location: login.php");  // 如果未登入，跳轉回登入頁面
//     exit;
// }

// -------------- php編輯區 ------------------



$title = "新增子類別";
$pageName = "add-categoryChild";


$parent_id  = empty($_GET['parent_id']) ? 0 : intval($_GET['parent_id']);


# 讀取該筆資料
$sql = "SELECT * FROM categories WHERE category_id = $parent_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  # 如果沒有對應的資料, 就跳走
  header('Location: category.php');
  exit;
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
    <style>
  form .mb-3 .form-text {
    display: none;
    /* color: red; */
  }

  form .mb-3.error input.form-control {
    border: 2px solid red;
  }

  form .mb-3.error .form-text {
    display: block;
    color: red;
  }
</style>
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
                            <h3 class="mb-0">新增子類別</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="category.php">商品類別</a></li>
                                <li class="breadcrumb-item active" aria-current="page">新增子類別</li>
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
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          

          <form onsubmit="sendData(event)">
            
            <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
            <div class="mb-3">
              <label class="form-label">類別
              </label>
              <input type="text" class="form-control"  value="<?= $r['category_name'] ?>" disabled>
            </div>
            <div class="mb-3">
              <label for="category_name" class="form-label">子類別名稱**</label>
              <input type="text" class="form-control" id="category_name" name="category_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="category_tag" class="form-label">類別標籤**</label>
              <input type="text" class="form-control" id="category_tag" name="category_tag">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">描述</label>
              <textarea class="form-control"
                id="description" name="description"></textarea>
              <div class="form-text"></div>
            </div>
            <button type="submit" class="btn btn-primary">新增</button>
          </form>

          <form name="upload_form" hidden>
            <input type="file" name="photo" accept="image/jpeg,image/png" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -新增結果-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a class="btn btn-primary" href="category.php">回到列表頁</a>
      </div>
    </div>
  </div>
</div>

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

const NameField = document.querySelector('#category_name');
  const descriptionField = document.querySelector('#description');
  const tagField = document.querySelector('#category_tag');
  const myModal = new bootstrap.Modal('#exampleModal');

  /**************** 檢查類別名稱是否重複 ************** */
  NameField.addEventListener('input', function () {
    
    if (NameField.value) {
        // 發送 AJAX 請求
        fetch(`add-upload-api.php?category_name_check=${NameField.value}`)
          .then(response => response.json())
          .then(data => {
            // 更新商品名稱欄位
            console.log(data.count);
            
            if(data.count !== 0){
              NameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 已有此類別名稱，名稱不可重複`;
              NameField.closest('.mb-3').classList.add('error');
            }else{
              NameField.closest('.mb-3').classList.remove('error');
            NameField.nextElementSibling.innerHTML = '';
            }
            
          })
          .catch(error => {
            console.error('發生錯誤:', error);
          });
      } 
    });
  /****************************** */



  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    NameField.closest('.mb-3').classList.remove('error');
    tagField.closest('.mb-3').classList.remove('error');

    let isPass = true; // 有沒有通過檢查, 預設值是 true
    // TODO: 資料欄位的檢查
    // --------------------------------------------------------
    
    
    if (!NameField.value) {
      isPass = false;
      NameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品名稱`;
      NameField.closest('.mb-3').classList.add('error');
    }
    if (!tagField.value) {
      isPass = false;
      tagField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫標籤名稱`;
      tagField.closest('.mb-3').classList.add('error');
    }else if(tagField.value.length>5){
      isPass = false;
      tagField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 標籤名稱需小於五個字元`;
      tagField.closest('.mb-3').classList.add('error');
    }
    
    // --------------------------------------------------------

    if (isPass) {
      const fd = new FormData(document.forms[0]);

      fetch(`add-upload-api.php`, {
          method: 'POST',
          body: fd
        }).then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (!obj.success && obj.error) {
            alert(obj.error)
          }
          if (obj.success) {
            myModal.show(); // 呈現 modal
          }

        }).catch(console.warn);
    }


  }


/*------------script編輯區END--------------*/

    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
