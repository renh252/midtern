<?php
#管理者才可看到這頁面
// require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/init.php';

/***************** products *************************/
#取得指定的primary key
$product_id = empty($_GET['product_id']) ? 0 : intval($_GET['product_id']);

if($product_id){
  $sql = "DELETE FROM products WHERE product_id= $product_id";
  $pdo->query($sql);
}


/***************** product_variants *************************/
$variant_id = empty($_GET['variant_id']) ?0: intval($_GET['variant_id']);

if($variant_id){
  $sql = "DELETE FROM product_variants WHERE variant_id= $variant_id";
  $pdo->query($sql);
}

/***************** category *************************/
$category_id = empty($_GET['category_id']) ?0: intval($_GET['category_id']);

// 刪除類別
if($category_id){
  // 確認是否有子類別
  $sql_check = "SELECT COUNT(*) AS count FROM categories WHERE parent_id = ?";
  $stmt_check = $pdo->prepare($sql_check);
  $stmt_check->execute([$category_id]);
  $result_check = $stmt_check->fetch();
  // 確認是否有被商品選擇
  $sql_check_p = "SELECT COUNT(*) AS count FROM products WHERE category_id  = ?";
  $stmt_check_p = $pdo->prepare($sql_check_p);
  $stmt_check_p->execute([$category_id]);
  $result_check_p = $stmt_check_p->fetch();

  if($result_check['count'] && !$result_check['count'] == 0){
    echo json_encode([
      'success' => false,
      'message' => "該資料有 {$result_check['count']} 項子類別，無法刪除。",
    ]);
    exit;
  }else if($result_check_p['count'] && !$result_check_p['count'] == 0){
    echo json_encode([
      'success' => false,
      'message' => "該資料為 {$result_check_p['count']} 項商品的類別，無法刪除。",
    ]);
    exit;
  }else{
    echo json_encode([
      'success' => true,
      'message' => "資料刪除成功",
    ]);
    $sql = "DELETE FROM categories WHERE category_id= $category_id";
    $pdo->query($sql);
    // 刪掉資料還在原本頁
    exit;
  }
  
}



// 刪掉資料還在原本頁面，不會回到第一頁
$come_from = 'list.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  # 從哪個頁面來的 (獲取前一頁面的URL 地址)
  $come_from = $_SERVER['HTTP_REFERER'];
}

// 導向到某一個地方
header("Location: $come_from");