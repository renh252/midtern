<?php
# 權限管控
//$_SESSION 是 PHP 中的全域變數，用於儲存會話資料。追蹤使用者狀態，例如登入資訊。
if (! isset($_SESSION)) {
  session_start();
}

//檢查使用者是否為管理員admin
if (!isset($_SESSION['admin'])) {
  //使用 HTTP Header 將使用者重定向到 login.php 頁面,引導未登入的使用者進行登入
  header('Location: login.php');
  exit;
}
