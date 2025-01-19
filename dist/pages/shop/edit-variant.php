<?php
// 先載入初始化檔案
require __DIR__ . '/../parts/init.php';

// 設定標題和頁面名稱
$title = "修改商品規格";
$pageName = "edit_variant";

// 啟動 Session
// session_start();
// ob_start();

// 檢查是否已登入
// if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
//     header("Location: login.php");  // 如果未登入，跳轉回登入頁面
//     exit;
// }

// -------------- php編輯區 ------------------


# 取得指定的 PK
$variant_id = empty($_GET['variant_id']) ? 0 : intval($_GET['variant_id']);

if (empty($variant_id)) {
  header('Location: products.php');
  exit;
}

# 讀取該筆資料
$sql = "SELECT 
v.variant_id ,
v.product_id ,
v.variant_name ,
v.price variant_price,
v.stock_quantity ,
v.image_url,
p.product_name,
p.price product_price
FROM product_variants v 
JOIN products p 
ON p.product_id=v.product_id  
WHERE variant_id=$variant_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  # 如果沒有對應的資料, 就跳走
  header('Location: products.php');
  exit;
}



// ----------------- php編輯區END ---------------

?>


  
  <?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
  <!--begin::Body-->
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

#imgContainer{
  display: flex;
  flex-wrap: wrap;
}
.imgDiv{
  height: 100px;
  margin: 10px;
}
.imgDiv img{
  height: 100%;
  }
</style>

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
                            <h3 class="mb-0">編輯商品規格</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="products.php">商品列表</a></li>
                                <li class="breadcrumb-item active" aria-current="page">編輯商品規格</li>
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
          <input type="hidden" name="variant_id" value="<?= $r['variant_id'] ?>">
            
            <div class="mb-3">
              <label for="product_id" class="form-label">商品編號</label>
              <input type="number" class="form-control" name="product_id" id="product_id" value="<?= $r['product_id'] ?>" placeholder="<?= $r['product_id'] ?>"
              >
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱</label>
              <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $r['product_name'] ?>" placeholder="<?= $r['product_name'] ?>" disabled>
            </div>
            <div class="mb-3">
              <label for="variant_name" class="form-label">規格名稱**</label>
              <input type="text" class="form-control" id="variant_name" name="variant_name"
              value="<?= $r['variant_name'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">價格**</label>
              <input type="number" class="form-control" id="price" name="price" placeholder="<?= $r['product_price'] ?>"
                value="<?= $r['variant_price'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="stock" class="form-label">庫存**</label>
              <input type="number" class="form-control" id="stock" name="stock" value="<?= $r['stock_quantity'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="img"  class="form-label">商品圖片
              </label>
              <!-- <img src="" alt="" class="photo" width="200px">
              <input type="hidden" name="photo" value=""> -->
              <!-- <button type="button"
                class="btn btn-warning" onclick="document.upload_form.photo.click()">選擇圖片</button> -->
              <input 
              name="img" 
              id="img"
              class="form-control"
              type="file" 
              accept="image/jpeg,image/png" 
              onchange="imgChange(event)"/>
                
                <div id="imgContainer">
    
                </div>
                
            </div>
            <button type="submit" class="btn btn-primary">確定修改</button>
          </form>

          
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -編輯結果-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">編輯結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料編輯成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a class="btn btn-primary" href="products.php">回到列表頁</a>
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
    <?php include ROOT_PATH . 'dist/js/sidebarJS.php' ?>
    
<script>

/*------------script編輯區--------------*/

/*----------- 檢查商品id -----------*/
const productIdField = document.querySelector('#product_id');
  const productNameField = document.querySelector('#product_name');
  
  document.getElementById('product_id').addEventListener('input', function () {
    const productId = this.value;

    if (productId) {
      // 發送 AJAX 請求
      fetch(`edit-api.php?product_id_check=${productId}`)
        .then(response => response.json())
        .then(data => {
          // 更新商品名稱欄位
          if(data.product_name == '查無此商品'){
            productNameField.value = data.product_name;
            productIdField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確商品編號`;
            productIdField.closest('.mb-3').classList.add('error');
          }else{
            productIdField.closest('.mb-3').classList.remove('error');
            productIdField.nextElementSibling.innerHTML = '';
            productNameField.value = data.product_name;

          }
          
        })
        .catch(error => {
          console.error('發生錯誤:', error);
        });
    } else {
      // 清空商品名稱
      document.getElementById('product_name').value = '';
    }
  });
/*----------- 檢查商品id END-----------*/

  const variantNameField = document.querySelector('#variant_name');
  const priceField = document.querySelector('#price');
  const stockField = document.querySelector('#stock');
  const myModal = new bootstrap.Modal('#exampleModal');

  /*****************送出表單*******************/
  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    // 移除錯誤標示
    variantNameField.closest('.mb-3').classList.remove('error');
    priceField.closest('.mb-3').classList.remove('error');
    stockField.closest('.mb-3').classList.remove('error');

    let isPass = true; // 有沒有通過檢查, 預設值是 true
    // TODO: 資料欄位的檢查

    if (!productIdField.value) {
      isPass = false;
      productIdField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品編號`;
      productIdField.closest('.mb-3').classList.add('error');
    }
    if (!variantNameField.value) {
      isPass = false;
      variantNameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫規格`;
      variantNameField.closest('.mb-3').classList.add('error');
    }
    if (!priceField.value) {
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫此規格價位`;
      priceField.closest('.mb-3').classList.add('error');
    }else if(priceField.value<0){
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的價格`;
      priceField.closest('.mb-3').classList.add('error');
    }
    if (!stockField.value) {
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫此規格庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }else if(stockField.value<0){
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }

    if (isPass) {
      const fd = new FormData(document.forms[0]);

      fetch(`edit-api.php`, {
        method: 'POST',
        body: fd
      }).then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            myModal.show(); // 呈現 modal
          } else {
            alert('資料沒有修改')
          }

        }).catch(console.warn);
    }


  }

  

  // ----------------照片預覽
  const myImg = document.querySelector("#myImg");
  const imgContainer = document.querySelector("#imgContainer");
  const imgChange = (e) => {
    if (e.target.files.length > 0) {
      let str = "";
      for(let f of e.target.files){
        const url = URL.createObjectURL(f);
        str += `
        <div class="imgDiv">
          <img src="${url}" alt="" id="myImg" >
        </div> `;
        imgContainer.innerHTML = str;
      }
    }else{
      imgContainer.innerHTML ="";
    }
    
  }
/*------------script編輯區END--------------*/

    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

