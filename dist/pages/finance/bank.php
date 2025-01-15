<?php
require __DIR__ . '/../parts/init.php';
$title = "捐款明細";
$pageName = "bank";

$perPage = 25; # 每一頁有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
}
$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];

$where = ' WHERE 1 '; # SQL 條件的開頭

if ($keyword) {
  $keyword_ = $pdo->quote("%{$keyword}%"); # 字串內容做 SQL 引號的跳脫, 同時前後標單引號
  $where .= " AND ( donor_name LIKE $keyword_ OR reconciliation_status LIKE $keyword_) ";
}

$t_sql = "SELECT COUNT(*) FROM `bank_transfer_details` $where";

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
  $sql = sprintf("SELECT * FROM bank_transfer_details %s
  LIMIT %d, %d", $where,($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料
}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-navbar.php' ?>

<div class="container">
  <div class="row mt-4 align-items-center">
  <div class="row mt-2">
      <div class="col-9"></div>
      <div class="col-3">
        <form class="d-flex" role="search">
          <input class="form-control me-2" name="keyword"
            value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>" type="search"
            placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
    <div class="col-11">
      <?php
      $qs = array_filter($_GET); # 去除值是空字串的項目
      ?>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = 1;
            echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = $page - 1;
            echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>

          <?php for ($i = $page - 5; $i <= $page + 5; $i++):
            if ($i >= 1 and $i <= $totalPages):
              #$qs = array_filter($_GET); # 去除值是空字串的項目
              $qs['page'] = $i;
              ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
              </li>
            <?php endif;
          endfor; ?>

          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = $page + 1;
            echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = $totalPages;
            echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="col mb-0" style="display:none;">
      <a href="add_bank.php"><i class="fa-solid fa-plus " style="border:1px solid black; padding:3px"></i></a>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><i class="fa-solid fa-trash"></i></th>
            <th>捐款編號</th>
            <th>捐款人姓名</th>
            <th>捐款金額</th>
            <th>匯款日期</th>
            <th>帳號末五碼</th>
            <th>對帳狀態</th>
            <th><i class="fa-solid fa-pen-to-square"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><a href="javascript:" onclick="deleteOne(event)">
                  <i class="fa-solid fa-trash"></i>
                </a></td>
              <td style="display:none"><?= $r['id'] ?></td>
              <td><?= $r['donation_id'] ?></td>
              <td><?= $r['donor_name'] ?></td>
              <td><?= $r['transfer_amount'] ?></td>
              <td><?= $r['transfer_date'] ?></td>
              <td><?= $r['account_last_5'] ?></td>
              <td><?= $r['reconciliation_status'] ?></td>
              <td><a href="edit_bank.php?bn_id=<?= $r['id'] ?>">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a></td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/html-scripts.php' ?>

<script>
  const deleteOne = e => {
    e.preventDefault(); // 沒有要連到某處
    const tr = e.target.closest('tr');
    const [, , td_id, td_name, , , , ] = tr.querySelectorAll('td');
    const bn_id = td_id.innerHTML.trim();
    const bn_name = td_name.innerHTML;
    console.log([bn_name.innerHTML]);
    if (confirm(`是否要刪除捐款人id為 ${bn_id} ，姓名為 ${bn_name} 的捐款紀錄?`)) {
      // 使用 JS 做跳轉頁面
      location.href = `del.php?id=${bn_id}`;
    }
  };
</script>
<?php include __DIR__ . '/parts/html-tail.php' ?>