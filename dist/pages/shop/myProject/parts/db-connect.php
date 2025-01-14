<?php
// 連接資料庫
require __DIR__ ."/config.php";

// $dsn 是建立"資料源名稱"的字串，用來指定資料庫的連接參數
// 文字間不要有空格
// charset=utf8mb4：設定字符集為 utf8mb4，它支援更多的 Unicode 字元（例如 emoji）
$dsn = sprintf("mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4",
    DB_HOST, 
    DB_NAME,
    DB_PORT,
);


//$pdo_options 是一個選項陣列，用來設定 PDO 的行為：
$pdo_options = array(
    // 設定錯誤模式
    PDO::ATTR_ERRMODE => 
    PDO::ERRMODE_EXCEPTION, # 發生錯誤時會拋出異常

    // 設定默認的資料提取模式
    PDO::ATTR_DEFAULT_FETCH_MODE =>
    PDO::FETCH_ASSOC); # 提取的資料以關聯陣列形式返回（鍵是欄位名稱）



// 建立了一個 PDO 物件，並連接到 MySQL 資料庫
$pdo = new PDO($dsn, DB_USER, DB_PASS); //建立連線物件

/*
範例：執行查詢
try {
    // 使用 PDO 物件執行查詢
    $stmt = $pdo->query("SELECT * FROM users");

    // 提取資料
    $results = $stmt->fetchAll();

    // 顯示結果
    foreach ($results as $row) {
        echo "ID: " . $row['id'] . " Name: " . $row['name'] . "<br>";
    }
} catch (PDOException $e) {
    // 錯誤處理
    echo "資料庫錯誤：" . $e->getMessage();
}

輸出示例：
ID: 1 Name: Alice
ID: 2 Name: Bob

*/