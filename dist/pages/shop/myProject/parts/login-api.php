<?php
require __DIR__ . '/parts/init.php';
header('content-Type: application/json');

$output = [
  'success' => false, # 有沒有登入成功
  'bodyData' => $_POST, # 除錯的用途
  'code' => 0, # 自訂的編號, 除錯的用途
];

# 帳號或密碼其中有一個欄位沒值, 就離開
if (empty($_POST['email']) or empty($_POST['password'])) {
  echo json_encode($output);
  exit;
}
# trim() 去掉頭尾的空白字元
$email = trim($_POST['email']);
$password = trim($_POST['password']);
# 1. 先確認帳號是否正確
$sql = "SELECT * FROM members WHERE email=? ";

$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch();

# 2. 找不到帳號, 帳號是錯的, 就離開
if (empty($row)) {
  $output['code'] = 400;
  echo json_encode($output);
  exit;
}

if (! password_verify($password, $row['password_hash'])) {
  $output['code'] = 420;
  echo json_encode($output);
  exit;
}

# 帳密都是對的, 把狀態存到 session

$_SESSION['admin'] = [
  'id' => $row['member_id'],
  'email' => $email,
  'nickname' => $row['nickname']
];
$output['success'] = true;

echo json_encode($output, JSON_UNESCAPED_UNICODE);
