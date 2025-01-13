<?php
# address-book/parts/config.php 設定檔，不加入版本控制
# 資料庫連線設定
const DB_HOST = '127.0.0.1';
const DB_USER = 'root';
const DB_PASS = 'P@ssw0rd';
const DB_NAME = 'pet_adopt';
const DB_PORT = 3306; #若不是使用 3306 需要設定


// 定義網站根目錄的 URL（用於 href 連結）
define('ROOT_URL', '/midtern/'); 

// 網站根目錄的系統路徑（用於 PHP 內文中）
define('ROOT_PATH', dirname(__DIR__, 3) . '/');
// __DIR__ 指向 config.php 所在目錄，dirname(__DIR__, 3) 往上三層到根目錄


// include ROOT_PATH . 'pages/parts/navbar.php'; // 使用ROOT_PATH引入 navbar.php