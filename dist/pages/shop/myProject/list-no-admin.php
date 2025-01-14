<?php
require __DIR__ . '/parts/init.php';
$title = "商品列表";
$pageName = "list";

$perPage = 5; # 每一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
  //die(); # 同 exit 的功能, 但可以回傳字串或編號
}


$t_sql = "SELECT COUNT(1) FROM Products ";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 總頁數
$totalPages = ceil($totalRows / $perPage);
$rows = []; # 設定預設值
if ($totalRows > 0) {
  if ($page > $totalPages) {
    # 用戶要看的頁碼超出範圍, 跳到最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  # 取第一頁的資料
  // products
  $sql = sprintf("SELECT 
    c.category_id,
    c.category_tag,
    p.product_id,
    p.product_name,
    p.price AS product_price,
    p.stock_quantity AS product_stock,
    p.product_description,
    p.product_status,
    p.image_url,
    p.created_at,
    p.updated_at
    FROM 
        Products p
    JOIN 
        Categories c
    ON 
        c.category_id = p.category_id
    ORDER BY p.product_id  DESC LIMIT %s, %s", ($page - 1) * $perPage,  $perPage);
  $rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料

  // 變體
  $sql_v = "SELECT 
    product_id,
    variant_id,
    variant_name,
    price AS variant_price,
    variant_status,
    stock_quantity AS variant_stock,
    image_url AS variant_img
    FROM 
        Product_Variants
    ORDER BY product_id ";
  $rows_v = $pdo->query($sql_v)->fetchAll(); # 取得該分頁的資料

}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-navbar.php' ?>

<div class="container">
  <div class="row mt-4">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>

          <?php for ($i = $page - 1; $i <= $page + 1; $i++):
            if ($i >= 1 and $i <= $totalPages):
          ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>

          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>

          
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-bordered ">
        <thead>
          <tr class="list-title">

            <th>#</th>
            <th>名稱</th>
            <th>介紹</th>
            <th>型號</th>
            <th>價格</th>
            <th>類別</th>
            <th>狀態</th>
            <th>照片</th>
            <!-- <th>照片</th> -->
            <th>庫存</th>
            <th>創建時間</th>
            <th>更新時間</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr class="list-product">

              <td><?= $r['product_id'] ?></td>
              <td><?= htmlentities($r['product_name']) ?></td>
              <td><?= htmlentities($r['product_description']) ?></td>
              <td></td>
              <td><?= $r['product_price'] ?></td>
              <td><?= $r['category_tag'] ?></td>
              <td><?= htmlentities($r['product_status']) ?></td>
              <!-- <td><?= htmlentities(string: $r['image_url']) ?></td> -->
              <td>
                <?php if (! empty($r['image_url'])): ?>
                  <img src="<?= $r['image_url'] ?>" alt="" width="100px">
                <?php endif; ?>
              </td>
              <td><?= $r['product_stock'] ?></td>
              <td><?= $r['created_at'] ?></td>
              <td><?= $r['updated_at'] ?></td>
              <!--
              <td><?= strip_tags($r['address']) ?></td>
          -->

            </tr>
            
            <!-- 變體 -->
            <?php foreach ($rows_v as $v):  if($v['product_id'] === $r['product_id']): ?>
              <tr class="list-variant">

                <td></td>
                <td></td>
                <td></td>
                <td><?= htmlentities($v['variant_name'] )?></td>
                <td><?= $v['variant_price'] ?></td>
                <td></td>
                <td><?= htmlentities($v['variant_status']) ?></td>
                <td><?= htmlentities($v['variant_img']) ?></td>
                <!-- <td>
                  <?php if (! empty($v['image_url'])): ?>
                    <img src="<?= $r['image_url'] ?>" alt="" width="100px">
                  <?php endif; ?>
                </td> -->
                <td><?= $v['variant_stock'] ?></td>
                <td></td>
                <td></td>
              </tr>
            <?php endif;   endforeach; ?>
          
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/html-scripts.php' ?>
<?php include __DIR__ . '/parts/html-tail.php' ?>