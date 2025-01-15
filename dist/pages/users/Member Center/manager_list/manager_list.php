<?php
// 資料庫連接設定
$host = "172.23.53.156";
$db_user = "mfee59";
$db_pass = "12345";
$db_name = "membercenter";

// 建立資料庫連接
$link = mysqli_connect("172.23.53.156","mfee59", "12345","membercenter");
if (!$link) {
    die("無法連接資料庫: " . mysqli_connect_error());
}

mysqli_query($link, "SET NAMES utf8"); // 設定資料庫編碼

// 取得所有管理者資料
$sql = "SELECT * FROM manager";
$result = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>管理者名單</title>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .button {
            padding: 5px 10px;
            color: white;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
        }
        .button-delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<h1 align="center">管理者名單</h1>

<table>
    <thead>
        <tr>
            <th>管理者帳號</th>
            <th>管理者權限</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['manager_account']; ?></td>
                <td><?php echo $row['manager_privileges']; ?></td>
                <td>
                    <a class="button" href="edit_manager.php?id=<?php echo $row['id']; ?>">編輯</a>
                    <a class="button button-delete" href="delete_manager.php?id=<?php echo $row['id']; ?>">刪除</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<p align="center"><a class="button" href="add_manager.php">新增管理者</a></p>

</body>
</html>

<?php
// 關閉資料庫連接
mysqli_close($link);
?>
