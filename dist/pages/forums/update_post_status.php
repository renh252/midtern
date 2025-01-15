<?php
require __DIR__ . '/../parts/init.php';

header('Content-Type: application/json');

if (isset($_POST['post_id']) && isset($_POST['status'])) {
    $post_id = intval($_POST['post_id']);
    $status = $_POST['status'];

    $sql = "UPDATE posts SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$status, $post_id])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '數據庫更新失敗']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => '缺少必要參數']);
}
