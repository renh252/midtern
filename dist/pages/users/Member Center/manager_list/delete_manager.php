<?php
// 資料庫連接設定
$host = "127.0.0.1";
$db_user = "root";
$db_pass = "P@ssw0rd";
$db_name = "membercenter";

// 檢查是否有傳遞管理者ID
if (isset($_GET['id'])) {
    $manager_id = $_GET['id'];

    // 建立資料庫連接
    $link = mysqli_connect($host, $db_user, $db_pass, $db_name);
    if (!$link) {
        die("無法連接資料庫: " . mysqli_connect_error());
    }

    mysqli_query($link, "SET NAMES utf8");

    // 刪除資料
    $sql = "DELETE FROM manager WHERE id = '$manager_id'";
    if (mysqli_query($link, $sql)) {
        echo "刪除成功！<br>";
        echo "<a href='manager_list.php'>返回管理者名單</a>";
    } else {
        echo "刪除失敗: " . mysqli_error($link);
    }

    mysqli_close($link);
} else {
    echo "無效的管理者ID";
}
?>
