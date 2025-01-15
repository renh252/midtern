<?php
// 設定資料庫連接參數
    $host = "127.0.0.1";
    $db_user = "root";
    $db_pass = "P@ssw0rd";
    $db_name = "membercenter";

// 建立資料庫連接
$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

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
        $message = "刪除成功！";
    } else {
        $message = "刪除失敗！";
    }
} else {
    $message = "未指定要刪除的資料！";
}

// 關閉資料庫連接
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>刪除結果</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .message {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .success {
            color: green;
        }
        .failure {
            color: red;
        }
        .button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="message <?php echo (isset($message) && strpos($message, "成功") !== false) ? 'success' : 'failure'; ?>">
        <?php echo $message; ?>
    </div>

    <!-- 按鈕會在幾秒後引導回會員列表頁 -->
    <a href="members_list.php" class="button">返回會員列表</a>

    <script>
        // 讓頁面顯示一段時間後自動跳轉到會員列表頁
        setTimeout(function() {
            window.location.href = 'members_list.php';
        }, 3000); // 3秒後自動跳轉
    </script>

</body>
</html>