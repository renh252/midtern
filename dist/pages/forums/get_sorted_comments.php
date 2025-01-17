<?php
require __DIR__ . '/../parts/init.php';

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'asc';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$search_field = isset($_GET['search_field']) ? $_GET['search_field'] : 'all';

// 驗證並清理排序參數
$allowedColumns = ['id', 'body', 'user_id', 'user_name', 'likes_count', 'created_at', 'updated_at', 'status'];
if (!in_array($sort, $allowedColumns)) {
  $sort = 'id';
}
$direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

$where = ' WHERE 1 ';
if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%");
  if ($search_field === 'all') {
    $where .= " AND (comments.body LIKE $keyword_ OR users.user_name LIKE $keyword_ OR comments.status LIKE $keyword_) ";
  } elseif ($search_field === 'body') {
    $where .= " AND comments.body LIKE $keyword_ ";
  } elseif ($search_field === 'user_id') {
    $where .= " AND users.user_id LIKE $keyword_ ";
  } elseif ($search_field === 'user_name') {
    $where .= " AND users.user_name LIKE $keyword_ ";
  }
}

// 修改 SQL 查詢以實現數字邏輯排序
$orderBy = $sort;
if (in_array($sort, ['id', 'likes_count'])) {
  $orderBy = "CAST(comments.$sort AS UNSIGNED)";
} elseif ($sort === 'user_id') {
  $orderBy = "CAST(users.user_id AS UNSIGNED)";
}

$sql = "SELECT comments.*, users.user_id, users.user_name
        FROM comments
        JOIN users ON comments.user_id = users.user_id
        $where
        ORDER BY $orderBy $direction";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);
