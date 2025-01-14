<?php
header('Content-Type: application/json');

require __DIR__ . '/parts/db-connect.php';

$sql = "SELECT * 
  FROM `address_book` 
  ORDER BY ab_id DESC 
  LIMIT 3";
$stmt = $pdo->query($sql); # PDOStatement 類型的代理物件

# PDO::FETCH_ASSOC, 以關聯式陣列的方式來取值
# PDO::FETCH_NUM, 以關聯式陣列的方式來取值
# $row = $stmt->fetch(); # 只拿一筆

$rows = $stmt->fetchAll();
echo json_encode($rows, JSON_UNESCAPED_UNICODE);
