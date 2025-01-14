<?php
session_start();

// 移除陣列裡的
unset($_SESSION['admin']);

// 回預設首頁
$come_from = 'index_.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  # 從哪個頁面來的 (獲取前一頁面的URL 地址)
  $come_from = $_SERVER['HTTP_REFERER'];
}

// 導向到某一個地方
header("Location: $come_from");