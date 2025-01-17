<?php
// 先載入初始化檔案
require __DIR__ . '/../parts/init.php';

// 設定標題和頁面名稱
$title = "訂單列表";
$pageName = "order";

// 啟動 Session
// session_start();
// ob_start();

// 檢查是否已登入
// if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
//     header("Location: login.php");  // 如果未登入，跳轉回登入頁面
//     exit;
// }

// -------------- php編輯區 ------------------



$promotion_id = empty($_GET['promotion_id']) ? 0 : intval($_GET['promotion_id']);

if (empty($promotion_id)) {
  header('Location: promotions.php');
  exit;
}

$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];

// 搜尋關鍵字
$where = ' WHERE 1 '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%"); # 字串內容做 SQL 引號的跳脫, 同時前後標單引號
  $where .= " AND ( product_name LIKE $keyword_ OR category_tag LIKE $keyword_ OR product_id LIKE $keyword_  OR product_description LIKE $keyword_ ) ";
}



$t_sql = "SELECT COUNT(1) 
          FROM  
            Products p
          JOIN 
            Categories c
          ON 
            c.category_id = p.category_id 
          $where";

  # 取第一頁的資料
  # 取第一頁的資料
  // products
  $sql = sprintf("SELECT 
    c.category_id,
    c.category_tag,
    c.category_name,
    p.product_id,
    p.product_name,
    p.price AS product_price,
    p.stock_quantity AS product_stock,
    p.product_description,
    p.product_status,
    p.image_url,
    p.created_at,
    p.updated_at
    FROM 
        Products p
    JOIN 
        Categories c
    ON 
        c.category_id = p.category_id
    %s
    "
    ,
    $where
  );
  $rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料

  // 變體
  $sql_v = "SELECT 
    product_id,
    variant_id,
    variant_name,
    price AS variant_price,
    stock_quantity AS variant_stock,
    image_url AS variant_img
    FROM 
        Product_Variants
    ORDER BY product_id ";
  $rows_v = $pdo->query($sql_v)->fetchAll(); # 取得該分頁的資料

  $sql_categories = "SELECT DISTINCT c.category_id, c.category_name 
  FROM Categories c
  JOIN Products p ON c.category_id = p.category_id";
$categories = $pdo->query($sql_categories)->fetchAll();



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
                            <h3 class="mb-0">活動搭配商品</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="promotions.php">促銷活動</a></li>
                                <li class="breadcrumb-item active" aria-current="page">活動搭配商品</li>
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
    <!-- 排序選單 -->
    
    <div class="col-6 d-flex"></div>
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

  <form onsubmit="sendData(event)">
    <input type="hidden" name="promotion_id" value="<?= $promotion_id?>">
  <div class="row">
    <!-- 商品類別 -->
    <div class="col-3">
    <div class="list-group">
    <?php foreach ($categories as $category): ?>
      <button type="button" 
              class="list-group-item list-group-item-action" 
              aria-current="true" 
              data-category-id="<?= $category['category_id'] ?>">
        <?= htmlentities($category['category_name']) ?>
      </button>
    <?php endforeach; ?>
</div>
<button type="submit" class="btn btn-primary mt-3">送出選擇的商品</button>

    </div>
    <!-- 商品 -->
    <div class="col">
        
        <table class="table table-bordered ">
          <thead>
            
            <tr class="list-title">
              <th>
                <div class="form-check">
                <input class="form-check-input me-2" type="checkbox" id="selectAll">
                </div>
              </th>
              <th>編號</th>
              <th>商品</th>
              <th>規格</th>
              <th>價格</th>
              <th>庫存</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($rows as $r): ?>
              <tr class="list-product"  data-category-id="<?= $r['category_id'] ?>" data-product-id="<?= $r['product_id'] ?>" >
                <td>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="product_id[]" value="<?= $r['product_id'] ?>"  id="">
                  </div>
                </td>
                <td><?= $r['product_id'] ?></td>
                <td><?= htmlentities($r['product_name']) ?></td>
                <td>--</td>
                <td><?= $r['product_price'] ?></td>
                <td>
                  <?php if (array_filter($rows_v, fn($v) => $v['product_id'] === $r['product_id'])): ?>
                    <!-- 所有變體的庫存加總 -->--
                  <?php else:
                    echo $r['product_stock'] ?>
                  <?php endif ?>
                </td>
              </tr>
              
              <!-- 變體 -->
              <?php foreach ($rows_v as $v):
                if ($v['product_id'] === $r['product_id']): ?>
                  <tr class="list-variant" data-category-id="<?= $r['category_id'] ?>" data-product-id="<?= $v['product_id'] ?>">
                    <td hidden><?= $r['product_name'] ?></td>
                    <td hidden><?= $v['variant_id'] ?></td>
                    <td>
                      <div class="form-check" >
                        <input class="form-check-input" type="checkbox" name="variant_id[]" value="<?= $v['variant_id'] ?>"  >
                        
                    </td>
                    <td></td>
                    <td></td>
                    <td><?= htmlentities($v['variant_name']) ?></td>
                    <td><?= $v['variant_price'] ?></td>
                    <td><?= $v['variant_stock'] ?></td>
                  </tr>
                <?php endif; endforeach; ?>
  
            <?php endforeach; ?>
          </tbody>
          
        </table>
        
      </div>
      
    </div><!-- row end -->
  </form>
</div> <!-- container end -->

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
        <a class="btn btn-primary" href="promotions.php">回到列表頁</a>
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


// ----------------全選
document.addEventListener("DOMContentLoaded", () => {
  const selectAllCheckbox = document.querySelector("#selectAll");
  const checkboxes = document.querySelectorAll('input[name="product_id[]"], input[name="variant_id[]"]');

  selectAllCheckbox.addEventListener("change", () => {
    checkboxes.forEach(checkbox => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });
});


// ----------------選取類別
  document.addEventListener("DOMContentLoaded", () => {
  // 儲存已選擇商品的 localStorage key
  const STORAGE_KEY = "selectedProducts";

  // 綁定類別按鈕點擊事件
  document.querySelectorAll(".list-group-item").forEach(button => {
    button.addEventListener("click", () => {
      const categoryId = button.getAttribute("data-category-id");
      filterProductsByCategory(categoryId);
    });
  });

  // 初始載入全部商品
  filterProductsByCategory(null);

  // 篩選商品
  function filterProductsByCategory(categoryId) {
  const products = document.querySelectorAll(".list-product");
  const variants = document.querySelectorAll(".list-variant");

  products.forEach(product => {
    const productCategoryId = product.getAttribute("data-category-id");
    const productId = product.getAttribute("data-product-id");

    if (!categoryId || productCategoryId === categoryId) {
      product.style.display = ""; // 顯示商品
      // 顯示對應的變體
      variants.forEach(variant => {
        if (variant.getAttribute("data-product-id") === productId) {
          variant.style.display = ""; // 顯示變體
        }
      });
    } else {
      product.style.display = "none"; // 隱藏商品
      // 隱藏對應的變體
      variants.forEach(variant => {
        if (variant.getAttribute("data-product-id") === productId) {
          variant.style.display = "none"; // 隱藏變體
        }
      });
    }
  });
}


  // 處理商品選擇
  function handleProductSelection(productId, button) {
    let selectedProducts = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    if (!selectedProducts.includes(productId)) {
      selectedProducts.push(productId);
      localStorage.setItem(STORAGE_KEY, JSON.stringify(selectedProducts));
    }
    // 更新按鈕狀態
    button.textContent = "已選擇";
    button.disabled = true;
  }

  // 初始化已選商品的狀態
  function initializeSelectedProducts() {
    const selectedProducts = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    document.querySelectorAll(".select-product").forEach(button => {
      const productId = button.getAttribute("data-product-id");
      if (selectedProducts.includes(productId)) {
        button.textContent = "已選擇";
        button.disabled = true;
      }
    });
  }

  // 綁定商品選擇事件
  document.querySelectorAll(".select-product").forEach(button => {
    button.addEventListener("click", () => {
      const productId = button.getAttribute("data-product-id");
      handleProductSelection(productId, button);
    });
  });
});


function sendData(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // 收集选中的商品和变体ID
    const selectedProducts = [];
    const selectedVariants = [];
    document.querySelectorAll('input[name="product_id[]"]:checked').forEach(checkbox => {
        selectedProducts.push(checkbox.value);
    });
    document.querySelectorAll('input[name="variant_id[]"]:checked').forEach(checkbox => {
        selectedVariants.push(checkbox.value);
    });

    // 添加到FormData
    formData.append('product_ids', JSON.stringify(selectedProducts));
    formData.append('variant_ids', JSON.stringify(selectedVariants));

    // 打印FormData内容，用于调试
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    fetch('add-upload-api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.text(); // 先获取文本响应
    })
    .then(text => {
        console.log('Raw response:', text); // 打印原始响应
        return JSON.parse(text); // 尝试解析JSON
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = 'promotions.php';
        } else {
            alert('錯誤：' + (data.error || '沒有新增成功'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('發生錯誤，請稍後再試\n錯誤詳情：' + error.message);
    });
}

/*------------script編輯區END--------------*/

    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
