<?php 
if (!isset($_SESSION)) {
    // 如果尚未啟動 session 的功能, 就啟動
   session_start();
   ob_start();
}
require __DIR__. '/db-connect.php'; 



// 根目錄的系統路徑（用於 PHP 內文中）
define('ROOT_PATH', dirname(__DIR__, 3) . '/');
// __DIR__ 指向 config.php 所在目錄，dirname(__DIR__, 3) 往上三層到根目錄
/* 
使用ROOT_PATH引入 navbar.php
include ROOT_PATH . 'pages/parts/navbar.php';
*/

// 定義根目錄的 URL（用於 href、src 連結等）
define('ROOT_URL', '/midtern/'); 
/* 
使用 ROOT_URL 來建立連結
<a href="<?= ROOT_URL ?>/dist/pages/index.php">到首頁</a>
<a href="<?= ROOT_URL ?>/dist/pages/pets/pet_info.php">到寵物資訊</a>
<script src="<?=ROOT_URL?>dist/js/adminlte.js"></script>
*/

// 驗證登入
function checkLogin() {
    if (!isset($_SESSION['manager_account'])) {
        header("Location: " . ROOT_URL . "dist/pages/users/Member%20Center/mager_login/login.php");
        exit();
    }
}
// 獲取用戶權限
function getUserPrivileges() {
    global $pdo;
    $account = $_SESSION['manager_account'];
    $sql = "SELECT manager_privileges FROM manager WHERE manager_account = :account";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['account' => $account]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['manager_privileges'] : '';
}
// 執行登入檢查
checkLogin();

// 獲取並存儲用戶權限
$_SESSION['manager_privileges'] = getUserPrivileges();
?>