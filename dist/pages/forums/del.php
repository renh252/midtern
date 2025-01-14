<?php
# 要是管理者才可以看到這個頁面
require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/init.php';

# 取得指定的 PK
$ab_id = empty($_GET['ab_id']) ? 0 : intval($_GET['ab_id']);

if ($ab_id) {
  $sql = "DELETE FROM address_book WHERE ab_id={$ab_id} ";
  $pdo->query($sql);
}

$come_from = 'list.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  # 從哪個頁面來的
  $come_from = $_SERVER['HTTP_REFERER'];
}


header("Location: $come_from");
