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

    // 取得管理者資料
    $sql = "SELECT * FROM manager WHERE id = '$manager_id'";
    $result = mysqli_query($link, $sql);
    $manager = mysqli_fetch_assoc($result);
    if (!$manager) {
        die("管理者資料不存在");
    }

    // 如果表單提交，更新資料庫
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $manager_account = $_POST['manager_account'];
        $manager_privileges = $_POST['manager_privileges'];

        $update_sql = "UPDATE manager SET manager_account='$manager_account', manager_privileges='$manager_privileges' 
                       WHERE id='$manager_id'";

        if (mysqli_query($link, $update_sql)) {
            echo "管理者資料更新成功！<br>";
            echo "<a href='manager_list.php'>返回管理者名單</a>";
        } else {
            echo "更新失敗: " . mysqli_error($link);
        }
    }
    
    mysqli_close($link);
} else {
    echo "無效的管理者ID";
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>編輯管理者</title>
</head>
<body>

<h1 align="center">編輯管理者</h1>

<form action="edit_manager.php?id=<?php echo $manager['id']; ?>" method="POST">
    <label for="manager_account">管理者帳號:</label>
    <input type="text" name="manager_account" id="manager_account" value="<?php echo $manager['manager_account']; ?>" required><br>

    <label for="manager_privileges">管理者權限:</label>
    <input type="text" name="manager_privileges" id="manager_privileges" value="<?php echo $manager['manager_privileges']; ?>" required><br>

    <input type="submit" value="更新管理者資料">
</form>

</body>