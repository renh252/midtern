
<?php
header('Content-Type: application/json');
require_once '../../../parts/db_connect.php';

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);

    $sql = "SELECT posts.id, posts.title, posts.body, posts.user_id, users.user_name
            FROM posts
            JOIN users ON posts.user_id = users.user_id
            WHERE posts.id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        echo json_encode([
            'status' => 'success',
            'data' => [
                'id' => $post['id'],
                'title' => $post['title'],
                'body' => $post['body'],
                'user_id' => $post['user_id'],
                'user_name' => $post['user_name']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No post ID provided']);
}
