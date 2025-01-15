<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 資料庫連接設定
    $host = "172.23.53.156";
    $db_user = "mfee59";
    $db_pass = "12345";
    $db_name = "membercenter";
    
    // 取得表單資料
    $manager_account = $_POST['manager_account'];
    $manager_privileges = $_POST['manager_privileges'];
    $manager_password = $_POST['manager_password'];
    $confirm_password = $_POST['confirm_password'];

    // 確認密碼和確認密碼是否一致
    if ($manager_password !== $confirm_password) {
        echo "密碼和確認密碼不一致，請重新輸入。";
        exit;
    }

    // 加密密碼
    $hashed_password = password_hash($manager_password, PASSWORD_DEFAULT);

    // 建立資料庫連接
    $link = mysqli_connect("172.23.53.156", "mfee59", "12345", "membercenter");
    if (!$link) {
        die("無法連接資料庫: " . mysqli_connect_error());
    }

    mysqli_query($link, "SET NAMES utf8");

    // 插入資料庫
    $sql = "INSERT INTO manager (manager_account, manager_privileges, manager_password) 
            VALUES ('$manager_account', '$manager_privileges', '$hashed_password')";

    if (mysqli_query($link, $sql)) {
        echo "新增管理者成功！<br>";
        echo "<a href='manager_list.php'>返回管理者名單</a>";
    } else {
        echo "新增管理者失敗: " . mysqli_error($link);
    }

    // 關閉資料庫連接
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增管理者</title>
</head>
<body>

<h1 align="center">新增管理者</h1>

<form action="add_manager.php" method="POST">
    <label for="manager_account">管理者帳號:</label>
    <input type="text" name="manager_account" id="manager_account" required><br>

    <label for="manager_privileges">管理者權限:</label>
    <input type="text" name="manager_privileges" id="manager_privileges" required><br>

    <label for="manager_password">管理者密碼:</label>
    <input type="password" name="manager_password" id="manager_password" required><br>

    <label for="confirm_password">確認密碼:</label>
    <input type="password" name="confirm_password" id="confirm_password" required><br>

    <input type="submit" value="新增管理者">
</form>

</body>
</html>