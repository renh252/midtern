<?php
/***************** 新增上傳api ******************/
# 要是管理者才可以看到這個頁面
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/../parts/init.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



header('content-Type: application/json');

$output = [
  'success' => false, # 有沒有新增成功
  'bodyData' => $_POST, # 除錯的用途
  'code' => 0, # 自訂的編號, 除錯的用途
  'error' => '', # 回應給前端的錯誤訊息
  'lastInsertId' => 0, # 最新拿到的 PK
];




/************** 檢查類別名稱是否重複(類別新增頁) api***************************/ 
if (isset($_GET['category_name_check'])) {

  $sql = "SELECT COUNT(category_name) AS count FROM categories WHERE category_name = :category_name AND parent_id IS NULL";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['category_name' => $_GET['category_name_check']]);
  $row = $stmt->fetch();

  if ($row['count']=='0') {
      echo json_encode(['count' =>  $row['count']]);
  } else {
      echo json_encode(['count' => '此類別名稱已存在']);
  }
  exit;
}
/************** 檢查類別名稱是否重複 END*****************/ 



/*********************** 新增上傳 ***************************** */

if(isset($_POST['category_name']) || isset($_POST['variant_name']) || isset($_POST['category']) || isset($_POST['promotion_name'])  || isset($_POST['promotion_id'])  ){

  /************** 新增促銷活動 *****************/ 
  
  if(!empty($_POST['promotion_name']) ){
    $sql = "INSERT INTO `promotions` ( 
      `promotion_name`, 
      `promotion_description`, 
      `discount_percentage`, 
      `start_date`,
      `end_date`
      ) 
      VALUES ( ?, ?, ?, ?, ?)";
    
      # ********* TODO: 欄位檢查 *************


      if (empty($_POST['start_date']) ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫開始日期!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }else if(empty($_POST['end_date']) ){
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫結束日期!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      else if(empty($_POST['discount_percentage']) ){
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫折扣!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }else if($_POST['discount_percentage']<0 || $_POST['discount_percentage']>100){
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '折扣 % 格式錯誤!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      
      
      
      # *************** TODO END ****************
      $stmt = $pdo->prepare($sql);
      try {
        $stmt->execute([
            $_POST['promotion_name'],
            $_POST['description'] ?? null,
            $_POST['discount_percentage'],
            $_POST['start_date'],
            $_POST['end_date']
        ]);
    } catch (PDOException $e) {
        $output['error'] = '資料庫錯誤:' . $e->getMessage();
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
  }
  
  
  /************** 新增產品類別 *****************/ 
  
  else if(!empty($_POST['category_name']) && empty($_POST['parent_id'])){
    $sql = "INSERT INTO `categories` ( 
      `category_name`, 
      `category_tag`, 
      `category_description`
      ) 
      VALUES ( ?, ?, ?)";
    
      # ********* TODO: 欄位檢查 *************


      if (empty($_POST['category_tag']) ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫標籤!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      
      
      
      # *************** TODO END ****************
      $stmt = $pdo->prepare($sql);
      try {
        $stmt->execute([
            $_POST['category_name'],
            $_POST['category_tag'],
            $_POST['description'] ?? null
        ]);
    } catch (PDOException $e) {
        $output['error'] = '資料庫錯誤:' . $e->getMessage();
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
  }
  
  
  /************** 新增子類別 *****************/ 
  
  else if(!empty($_POST['category_name']) && !empty($_POST['parent_id'])){
    $sql = "INSERT INTO `categories` ( 
      `category_name`, 
      `category_tag`, 
      `category_description`,
      `parent_id`
      ) 
      VALUES ( ?, ?, ?, ?)";
    
      # ********* TODO: 欄位檢查 *************


      if (empty($_POST['category_tag']) ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫標籤!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      # *************** TODO END ****************
      $stmt = $pdo->prepare($sql);
      try {
        $stmt->execute([
            $_POST['category_name'],
            $_POST['category_tag'],
            $_POST['description'] ?? null,
            $_POST['parent_id']
        ]);
    } catch (PDOException $e) {
        $output['error'] = '資料庫錯誤:' . $e->getMessage();
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
  }
  
  
  /************** 新增產品規格 *****************/ 
  
  else if(!empty($_POST['variant_name'])){
    $sql = "INSERT INTO `product_variants` ( 
      `product_id`, 
      `variant_name`, 
      `price`,
      `image_url`,
      `stock_quantity`) 
      VALUES ( ?, ?, ?, ?, ?)";

      
      $upload_path=null;
      // 測試上傳圖片
      $dir= __DIR__.'/photos/'; #存放圖片的資料夾

      // 篩選檔案類型，決定副檔名
      $exts =[
        'image/jpeg' => '.jpg',
        'image/png'=> '.png',
        'image/webp'=> '.webp'
      ];
      # ********* TODO: 欄位檢查 *************
      // if ($_POST['product_id']  ) {
      //   $output['code'] = 401; # 自行決定的除錯編號
      //   $output['error'] = '查無此產品!';
      //   echo json_encode($output, JSON_UNESCAPED_UNICODE);
      //   exit;
      // }
      if (empty($_POST['variant_name'])  ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫產品規格!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      elseif (!isset($_POST['price']) ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫此規格價位!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      elseif ($_POST['price']<0  ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '價位格式錯誤!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      elseif (!isset($_POST['stock'])  ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '沒有填寫庫存!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
      elseif ($_POST['stock'] < 0 ) {
        $output['code'] = 401; # 自行決定的除錯編號
        $output['error'] = '庫存格式錯誤!';
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
      }
       // -------------------照片


    // 檢查是否有上傳檔案
    if(!empty($_FILES['img'])
    and
    !empty($_FILES['img'])
    and
    !empty($_FILES['img']['error'] == 0)
  ){
    // 檢查副檔名(MIME Type檔案類型)
    if(!empty($exts[$_FILES['img']['type']])){
      // 取得副檔名
      $exts = $exts[$_FILES['img']['type']];
      // 建立隨機檔案名稱
      $file_name = md5($_FILES['img']['name'].uniqid());
      $upload_path = $dir.$file_name.$exts;
      // 將檔案移動到指定資料夾
      if(move_uploaded_file(
        // 暫存檔案的路徑
        $_FILES['img']['tmp_name'],
        $upload_path
        )) {
          // $output['success']=true; 
          // $output['file']=$file_name.$exts
          // ;
        }

    }
  }
  // -------------------照片END
      # *************** TODO END ****************
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        $_POST['product_id'],
        $_POST['variant_name'],
        $_POST['price'],
        'photos/'.$file_name.$exts,
        $_POST['stock']
      ]);
  }
  
  
  
  
  /************** 新增產品 **********************************************/ 
  if(!empty($_POST['category'])){
    $sql = "INSERT INTO `Products` ( 
    `product_name`, 
    `product_description`, 
    `price`,
    `category_id`, 
    `product_status`, 
    `image_url`,
    `stock_quantity`) 
    VALUES ( ?, ?, ?, ?, ?, ?, ? )";


    $upload_path=null;
    // 測試上傳圖片
    $dir= __DIR__.'/photos/'; #存放圖片的資料夾

    // 篩選檔案類型，決定副檔名
    $exts =[
      'image/jpeg' => '.jpg',
      'image/png'=> '.png',
      'image/webp'=> '.webp'
    ];
    # ********* TODO: 欄位檢查 *************
    if (empty($_POST['product_name'])  ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '沒有填寫產品規格!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif (!isset($_POST['category']) ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '沒有選取商品類別!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif (!isset($_POST['product_status']) ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '沒有選取商品狀態!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif (!isset($_POST['price']) ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '沒有填寫此規格價位!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif ($_POST['price']<0  ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '價位格式錯誤!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif (!isset($_POST['stock'])  ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '沒有填寫庫存!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
    elseif ($_POST['stock'] < 0 ) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '庫存格式錯誤!';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
  
    // -------------------照片


    // 檢查是否有上傳檔案
    if(!empty($_FILES['img'])
      and
      !empty($_FILES['img'])
      and
      !empty($_FILES['img']['error'] == 0)
    ){
      // 檢查副檔名(MIME Type檔案類型)
      if(!empty($exts[$_FILES['img']['type']])){
        // 取得副檔名
        $exts = $exts[$_FILES['img']['type']];
        // 建立隨機檔案名稱
        $file_name = md5($_FILES['img']['name'].uniqid());
        $upload_path = $dir.$file_name.$exts;
        // 將檔案移動到指定資料夾
        if(move_uploaded_file(
          // 暫存檔案的路徑
          $_FILES['img']['tmp_name'],
          $upload_path
          )) {
            // $output['success']=true; 
            // $output['file']=$file_name.$exts
            // ;
          }

      }
    }
    // -------------------照片END

    # *************** TODO END ****************
   
    /*
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (! $email) {
      $output['code'] = 401; # 自行決定的除錯編號
      $output['error'] = '請填寫正確的 Email !';
      echo json_encode($output, JSON_UNESCAPED_UNICODE);
      exit;
    }
  
  
    # *** 處理日期
    if (empty($_POST['birthday'])) {
      $birthday = null;
    } else {
      $birthday = strtotime($_POST['birthday']); # 轉換成 timestamp
      if ($birthday === false) {
        // 如果格式是錯的, 無法轉換
        $birthday = null;
      } else {
        $birthday = date("Y-m-d", $birthday);
      }
    }
    */
  
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      $_POST['product_name'],
      $_POST['description'] ?? null,
      $_POST['price'],
      $_POST['category'],
      $_POST['product_status'],
      'photos/'.$file_name.$exts  ?? null,
      $_POST['stock']
    ]);
  
  }
  
  
  
  /************** 新增促銷活動商品 **********************************************/ 
  if (isset($_POST['promotion_id']) && 
    (isset($_POST['product_ids']) || isset($_POST['variant_ids']))) {

    $promotion_id = intval($_POST['promotion_id']);
    $selectedProducts = json_decode($_POST['product_ids'] ?? '[]', true);
    $selectedVariants = json_decode($_POST['variant_ids'] ?? '[]', true);

    $sql = "INSERT INTO Promotion_Products (promotion_id, product_id, variant_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $pdo->beginTransaction();

        // 插入商品
        foreach ($selectedProducts as $product_id) {
            $stmt->execute([$promotion_id, $product_id, null]);
        }

        // 插入變體
        foreach ($selectedVariants as $variant_id) {
            $stmt->execute([$promotion_id, null, $variant_id]);
        }

        $pdo->commit();
        $output['success'] = true;
        $output['message'] = '促銷活動商品新增成功';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $output['success'] = false;
        $output['error'] = '資料庫錯誤: ' . $e->getMessage();
    }
}








  
  $output['success'] = !! $stmt->rowCount(); # 新增了幾筆, 轉布林值
  $output['lastInsertId'] = $pdo->lastInsertId(); # 最新拿到的 PK
  
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
}
