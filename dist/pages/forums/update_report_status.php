<?php
// 設置響應頭為 JSON
header('Content-Type: application/json');

// 啟用錯誤報告
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 包含數據庫連接等必要的設置
require_once __DIR__ . '/../parts/init.php';

// 檢查是否收到 POST 請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';

    // 驗證輸入
    if (empty($id) || empty($status)) {
        echo json_encode(['success' => false, 'message' => '缺少必要參數']);
        exit;
    }

    try {
        // 開始事務
        $pdo->beginTransaction();

        // 更新數據庫
        $sql = "UPDATE reports SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$status, $id])) {
            // 如果狀態是"審核通過"或"審核駁回"，從數據庫中刪除該記錄
            if ($status === '審核通過' || $status === '審核駁回') {
                $deleteSql = "DELETE FROM reports WHERE id = ?";
                $deleteStmt = $pdo->prepare($deleteSql);
                $deleteStmt->execute([$id]);
            }

            // 提交事務
            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('數據庫更新失敗');
        }
    } catch (Exception $e) {
        // 回滾事務
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '無效的請求方法']);
}
