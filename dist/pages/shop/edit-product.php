<?php
// 先載入初始化檔案
require __DIR__ . '/../parts/init.php';

// 設定標題和頁面名稱
$title = "修改商品資訊";
$pageName = "edit_product";

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
$product_id = empty($_GET['product_id']) ? 0 : intval($_GET['product_id']);

if (empty($product_id)) {
  header('Location: products.php');
  exit;
}

# 讀取該筆資料
$sql = "SELECT 
    c.category_id ,
    c.category_tag ,
    p.product_id ,
    p.product_name ,
    p.price ,
    p.stock_quantity ,
    p.product_description ,
    p.product_status ,
    p.image_url ,
    p.created_at ,
    p.updated_at
    FROM 
        Products p
    JOIN 
        Categories c
    ON 
        c.category_id = p.category_id
    WHERE product_id=$product_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  # 如果沒有對應的資料, 就跳走
  header('Location: products.php');
  exit;
}

$sql_category = "SELECT * FROM Categories ORDER BY category_id ";
$rows_category = $pdo->query($sql_category)->fetchAll();



// ----------------- php編輯區END ---------------

?>


  
  <?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= ROOT_URL ?>/dist/pages/shop/parts/shopCSS.css" rel="stylesheet" />
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
                            <h3 class="mb-0">編輯商品</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="products.php">商品列表</a></li>
                                <li class="breadcrumb-item active" aria-current="page">編輯商品</li>
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
            <input type="hidden" name="product_id" value="<?= $r['product_id'] ?>">
            <div class="mb-3">
              <label for="id_check" class="form-label">商品編號</label>
              <input type="text" class="form-control" id="id_check" disabled
              value="<?= $r['product_id'] ?>">
            </div>

            
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱**</label>
              <input type="text" class="form-control" id="product_name" name="product_name"
              value="<?= $r['product_name'] ?>"
              >
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="category" class="form-label">類別**</label>
              <select class="form-control form-select form-select-sm" id="category" name="category">
                <option value="">--請選擇--</option>
                <?php foreach($rows_category as $row_c): ?>
                <option value="<?=$row_c['category_id']?>" <?php if ($row_c['category_id'] == $r['category_id']) echo 'selected'; ?>><?=$row_c['category_id']?>. <?=$row_c['category_name']?></option>
                <?php endforeach?>
              </select>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">描述</label>
              <textarea class="form-control"
                id="description" name="description"><?= $r['product_description']?></textarea>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">價格**</label>
              <input type="number" class="form-control" id="price" name="price" value="<?= $r['price'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="stock" class="form-label">庫存**</label>
              <input type="number" class="form-control" id="stock" name="stock" value="<?= $r['stock_quantity'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_status" class="form-label">狀態**</label>
              <select class="form-control form-select form-select-sm" id="product_status" name="product_status">
                <option value="上架" <?php if ($r['product_status'] == "上架") echo 'selected'; ?>>上架</option>
                <option value="下架" <?php if ($r['product_status'] == "下架") echo 'selected'; ?>>下架</option>
              </select>
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
                <?php if($r['image_url']):?>
                  <input type="hidden" 
                  id="originImg"
                  name="originImg" value="<?= $r['image_url'] ?>">
                  <div class="imgDiv">
                  <i class="fa-solid fa-circle-xmark deleteImg" onclick="deleteImg(event)" ></i>
                    <img src="<?= $r['image_url'] ?>" alt="">
                  </div>
                <?php endif;?>
                </div>
                
            </div>
            <button type="submit" class="btn btn-primary">確認修改</button>
          </form>

          <form name="upload_form" hidden>
            <input type="file" name="photo" accept="image/jpeg,image/png" />
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

const productNameField = document.querySelector('#product_name');
  const categoryField = document.querySelector('#category');
  const descriptionField = document.querySelector('#description');
  const priceField = document.querySelector('#price');
  const stockField = document.querySelector('#stock');
  const statusField = document.querySelector('#product_status');
  const myModal = new bootstrap.Modal('#exampleModal');

  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    productNameField.closest('.mb-3').classList.remove('error');
    categoryField.closest('.mb-3').classList.remove('error');
    descriptionField.closest('.mb-3').classList.remove('error');
    priceField.closest('.mb-3').classList.remove('error');
    stockField.closest('.mb-3').classList.remove('error');
    statusField.closest('.mb-3').classList.remove('error');

    let isPass = true; // 有沒有通過檢查, 預設值是 true
    // TODO: 資料欄位的檢查

    if (!productNameField.value) {
      isPass = false;
      productNameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品名稱`;
      productNameField.closest('.mb-3').classList.add('error');
    }
    if (!priceField.value) {
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品價格`;
      priceField.closest('.mb-3').classList.add('error');
    }else if(priceField.value<0){
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的價格`;
      priceField.closest('.mb-3').classList.add('error');
    }
    if (!stockField.value) {
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }else if(stockField.value<0){
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }
    if (!statusField.value) {
      isPass = false;
      statusField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請選擇商品狀態`;
      statusField.closest('.mb-3').classList.add('error');
    }else if(statusField.value !== '上架' && statusField.value !== '下架'  ){
      isPass = false;
      statusField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請選取正確的商品狀態`;
      statusField.closest('.mb-3').classList.add('error');
    }
    if (!categoryField.value) {
      isPass = false;
      categoryField.nextElementSibling.innerHTML = "請選取類別";
      categoryField.closest('.mb-3').classList.add('error');
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
          <i class="fa-solid fa-circle-xmark deleteImg" onclick="deleteImg(event)"></i>
          <img src="${url}" alt="" id="myImg" >
        </div> `;
        imgContainer.innerHTML = str;
      }
    }else{
      imgContainer.innerHTML ="";
    }
    
  }


  // ------------------刪除圖片
  const originImg= document.querySelector('#originImg');
  function deleteImg (e) {
    e.target.closest('.imgDiv').remove();
    document.querySelector('#img').value="";
    if(originImg){
      originImg.remove();
    }
  }
  // ------------------刪除圖片END
/*------------script編輯區END--------------*/

    </script>
    <!--end::Script-->
</body>
<!--end::Body-->


