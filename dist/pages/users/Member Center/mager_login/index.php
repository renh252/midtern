<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>index.php</title>
</head>
<body>
<?php
session_start();
ob_start();
// 檢查是否已登入
if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
    header("Location: login.php");  // 如果未登入，跳轉回登入頁面
    exit;
}
?>

<h1>歡迎來到主頁面！</h1>
<a href="logout.php">登出</a>
</body>
</html>