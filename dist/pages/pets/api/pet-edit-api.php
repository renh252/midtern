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
];

// 處理上傳
$main_photo = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/pet_avatars/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExtension;
    $uploadFile = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
        $main_photo = '/uploads/pet_avatars/' . $newFileName;
        
        // 刪除舊照片
        if (!empty($_POST['old_avatar'])) {
            $oldFile = __DIR__ . '/..' . $_POST['old_avatar'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } else {
        $output['error'] = '上傳失敗：' . error_get_last()['message'];
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
$id = intval($_POST['id'] ?? 0);

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

// SQL 查詢
$sql = "UPDATE `pets` SET
    `name`=?, 
    `species`=?,
    `variety`=?,
    `gender`=?,
    `birthday`=?,
    `weight`=?,
    `chip_number`=?,
    `is_adopted`=?,
    `fixed`=?";

if ($main_photo !== null) {
    $sql .= ", `main_photo`=?";
}

$sql .= " WHERE `id`=?";

$stmt = $pdo->prepare($sql);

$params = [
    $name,
    $species,
    $variety,
    $gender,
    $birthday,
    $weight,
    $chip_number,
    $is_adopted,
    $fixed
];

if ($main_photo !== null) {
    $params[] = $main_photo;
}

$params[] = $id;

try {
    $stmt->execute($params);
    $output['success'] = $stmt->rowCount() > 0;
} catch (PDOException $e) {
    $output['error'] = '資料更新失敗：' . $e->getMessage();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
