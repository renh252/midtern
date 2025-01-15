<?php
// 設定資料庫連接參數
    $host = "127.0.0.1";
    $db_user = "root";
    $db_pass = "P@ssw0rd";
    $db_name = "membercenter";

// 建立資料庫連接
$link = mysqli_connect("$db_host", "$db_username", "$db_password", "$database");

// 檢查連接是否成功
if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 設置編碼，防止中文亂碼
mysqli_query($link, "SET NAMES utf8");

// 處理刪除請求
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // 建立刪除的 SQL 指令
    $delete_sql = "DELETE FROM users WHERE user_id = $delete_id";

    // 執行刪除操作
    if (mysqli_query($link, $delete_sql)) {
        echo "<script>alert('刪除成功'); window.location.href='members_list.php';</script>";
    } else {
        echo "<script>alert('刪除失敗'); window.location.href='members_list.php';</script>";
    }
}

// 撰寫 SQL 查詢指令來提取所有會員
$sql = "SELECT user_id, user_email, user_password, user_name, user_number, user_address, user_birthday, user_level, profile_picture, user_status FROM users"; 

// 執行 SQL 查詢
$result = mysqli_query($link, $sql);

// 檢查查詢是否成功
if (!$result) {
    die("查詢失敗: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員列表</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>會員列表</h1>
    <table>
        <thead>
            <tr>
                <th>會員ID</th>
                <th>會員Email</th>
                <th>密碼</th>
                <th>姓名</th>
                <th>電話</th>
                <th>地址</th>
                <th>生日</th>
                <th>等級</th>
                <th>頭像</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 使用 while 迴圈來提取每一行數據並顯示在表格中
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['user_email'] . "</td>";
                echo "<td>" . $row['user_password'] . "</td>";
                echo "<td>" . $row['user_name'] . "</td>";
                echo "<td>" . $row['user_number'] . "</td>";
                echo "<td>" . $row['user_address'] . "</td>";
                echo "<td>" . $row['user_birthday'] . "</td>";
                echo "<td>" . $row['user_level'] . "</td>";
                
                // 顯示頭像，如果有圖片檔案
                if (!empty($row['profile_picture'])) {
                    echo "<td><img src='" . $row['profile_picture'] . "' alt='Profile Picture' width='50' height='50'></td>";
                } else {
                    echo "<td>無頭像</td>";
                }

                echo "<td>" . $row['user_status'] . "</td>";
                echo "<td><a href='members_list.php?delete_id=" . $row['user_id'] . "' onclick='return confirm(\"確定要刪除此會員嗎？\");'>刪除</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // 釋放結果集
    mysqli_free_result($result);

    // 關閉資料庫連接
    mysqli_close($link);
    ?>
</body>
</html>