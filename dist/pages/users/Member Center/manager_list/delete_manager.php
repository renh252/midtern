<?php
// 資料庫連接設定
$host = "localhost";
$db_user = "mfee59";
$db_pass = "12345";
$db_name = "membercenter";

// 檢查是否有傳遞管理者ID
if (isset($_GET['id'])) {
    $manager_id = $_GET['id'];

    // 建立資料庫連接
    $link = mysqli_connect("172.23.53.156","mfee59", "12345","membercenter");
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
