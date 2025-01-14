<?php
session_start();
session_destroy();  // 清除所有Session
header("Location: login.php");  // 重定向回登入頁面
exit;
?>