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


// 驗證並處理輸入數據
$name = trim($_POST['name'] ?? '');
$species = trim($_POST['species'] ?? '');
$variety = trim($_POST['variety'] ?? '');
$gender = $_POST['gender'] ?? '';
$birthday = !empty($_POST['birthday']) ? date('Y-m-d', strtotime($_POST['birthday'])) : null;
$weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : null;
$chip_number = trim($_POST['chip'] ?? '');
$is_adopted = isset($_POST['is-adopted']) ? intval($_POST['is-adopted']) : 0;
$fixed = isset($_POST['fixed']) ? intval($_POST['fixed']) : 0;

// 驗證
$errors = [];

if (strlen($name) < 2) {
    $errors['name'] = '名字至少要兩個字';
}

if (empty($birthday)) {
    $errors['birthday'] = '請選擇生日';
}

if ($weight !== null && $weight <= 0) {
    $errors['weight'] = '請輸入有效的體重';
}

if (!in_array($is_adopted, [0, 1])) {
    $errors['is-adopted'] = '請選擇是否領養';
}

if (!in_array($fixed, [0, 1])) {
    $errors['fixed'] = '請選擇是否絕育';
}

if (!empty($errors)) {
    $output['errors'] = $errors;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "INSERT INTO `pets` 
  (`name`, `species`, `variety`, `gender`, `birthday`, `weight`, `chip_number`, `is_adopted`, `fixed`, `main_photo`)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $name,
        $species,
        $variety,
        $gender,
        $birthday,
        $weight,
        $chip_number,
        $is_adopted,
        $fixed,
        $main_photo
    ]);

    $output['success'] = $stmt->rowCount() > 0;
    $output['lastInsertId'] = $pdo->lastInsertId();
} catch (PDOException $e) {
    $output['error'] = '資料新增失敗：' . $e->getMessage();
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
