<?php

# 管理者登入驗證
// require __DIR__ . '/parts/admin-required.php'; 

require __DIR__ . '/../../parts/init.php';

header('content-Type: application/json');

$output = [
    'success' => false, #有沒有新增成功
    'bodyData' => $_POST, #除錯的用途
    'code' => 0, #自訂的編號 除錯用
    'error' => '', #回應給前端的錯誤訊息
    'lastInsertId' => 0 #最新拿到的primaryKey
];

// 處理上傳
$main_photo = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/pet_avatars/'; // 上傳目錄
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExtension;
    $uploadFile = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
        $main_photo = '/uploads/pet_avatars/' . $newFileName; // 儲存路徑
    } else {
        $output['error'] =  '上傳失敗：' . error_get_last()['message'];
        error_log("File upload failed: " . error_get_last()['message']);
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

//避免SQL注入 用?佔位符號
$sql = "INSERT INTO `pets` 
  ( `name`, `species`,
    `variety`, `gender`, `birthday`, `weight`, `chip_number`, `is_adopted`, `main_photo`)
    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";

# TODO: 欄位檢查 

$birthday = empty($_POST['birthday']) ?null:$_POST['birthday'];
# 處理日期
if (empty($_POST['birthday'])) {
    $birthday = null;
} else {
    $birthday = strtotime($_POST['birthday']); #轉換成timestamp
    if ($birthday === false) {
        //用==如果輸入0也會變成true，所以需要用嚴格等於
        //如果不能轉換成timestamp格式
        $birthday = null;
    } else {
        $birthday = date('Y-m-d', $birthday);
    }
}

// `name`, `species`, `variety`, `gender`, `birthday`, `weight`, `chip`, `is-adopted`
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['name'],
        $_POST['species'],
        $_POST['variety'],
        $_POST['gender'],
        $birthday,
        $_POST['weight'],
        $_POST['chip'],
        $_POST['is-adopted'],
        $main_photo
    ]);

    $output['success'] = !! $stmt->rowCount(); #新增幾筆，轉換成bool
    $output['lastInsertId'] = $pdo->lastInsertId(); # 最新拿到的 PK
} catch (PDOException $e) {
    $output['success'] = false;
    // 如果有重複的chip_number，就回傳錯誤訊息
    if ($e->getCode() == '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'chip_number') !== false) {
        $output['error'] = 'duplicate_chip';
    } else {
        $output['error'] = 'database_error';
        // 可以選擇記錄詳細錯誤信息，但不要發送給客戶端
        error_log("Database error: " . $e->getMessage());
    }
}

// 輸出
echo json_encode($output, JSON_UNESCAPED_UNICODE);
