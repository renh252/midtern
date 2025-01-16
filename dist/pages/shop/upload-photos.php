<?php
require __DIR__ . '/../parts/init.php';
require __DIR__ . '/../parts/db-connect.php';


$upload_dir = './photo/';  // 設置上傳目錄

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$result = [
    'success' => false,
    'file' => null,
    'error' => '',
];

if (isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $target = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        $result['success'] = true;
        $result['file'] = $filename;

        // 將檔案路徑存入資料庫
        $sql = "INSERT INTO products VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $image_path = './ph/' . $filename;
        if ($stmt->execute([$image_path])) {
            $result['image_id'] = $pdo->lastInsertId();
        } else {
            $result['error'] = '資料庫寫入失敗';
        }
    } else {
        $result['error'] = '檔案上傳失敗';
    }
} else {
    $result['error'] = '沒有檔案';
}

header('Content-Type: application/json');
echo json_encode($result, JSON_UNESCAPED_UNICODE);
