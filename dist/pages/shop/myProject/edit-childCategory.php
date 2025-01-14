<?php
/************** 修改商品頁面 ****************/

#管理者才可看到這頁面
// require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/init.php';
$title = "修改商品類別";
$pageName = "edit-category";

# 取得指定的 PK
$category_id = empty($_GET['category_id']) ? 0 : intval($_GET['category_id']);
$parent_name = empty($_GET['parent_name']) ? 0 : ($_GET['parent_name']);

if (empty($category_id ) || empty($parent_name)) {
  header('Location: list.php');
  exit;
}

# 讀取該筆資料
$sql = "SELECT 
    *
    FROM 
        Categories 
    WHERE category_id=$category_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  # 如果沒有對應的資料, 就跳走
  header('Location: list.php');
  exit;
}

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-navbar.php' ?>
<style>
  form .mb-3 .form-text {
    display: none;
    /* color: red; */
  }

  form .mb-3.error input.form-control {
    border: 2px solid red;
  }

  form .mb-3.error .form-text {
    display: block;
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">修改子類別</h5>
          <form onsubmit="sendData(event)">
          <div class="mb-3">
              <label for="parent_name" class="form-label">類別</label>
              <input type="text" class="form-control" id="parent_name" name="parent_name"
                value="<?= $parent_name ?>" disabled>
              <div class="form-text"></div>
            </div>
            <input type="hidden" name="category_id" value="<?= $r['category_id'] ?>">
            <div class="mb-3">
              <label for="id_check" class="form-label">子類別編號</label>
              <input type="text" class="form-control" id="id_check" disabled value="<?= $r['category_id'] ?>">
            </div>

            
            <div class="mb-3">
              <label for="product_name" class="form-label">子類別名稱**</label>
              <input type="text" class="form-control" id="category_name" name="category_name"
                value="<?= $r['category_name'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="category_tag" class="form-label">標籤名稱**</label>
              <input type="text" class="form-control" id="category_tag" name="category_tag"
                value="<?= $r['category_tag'] ?>">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">描述</label>
              <textarea class="form-control" id="description"
                name="description"><?= $r['category_description'] ?></textarea>
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">確認修改</button>
          </form>



        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -編輯結果-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">編輯結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料編輯成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a class="btn btn-primary" href="list.php">回到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/html-scripts.php' ?>
<script>
  const categoryNameField = document.querySelector('#category_name');
  const categoryTagField = document.querySelector('#category_tag');
  const descriptionField = document.querySelector('#description');
  const myModal = new bootstrap.Modal('#exampleModal');

  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    categoryNameField.closest('.mb-3').classList.remove('error');
    categoryTagField.closest('.mb-3').classList.remove('error');
    descriptionField.closest('.mb-3').classList.remove('error');


    let isPass = true; // 有沒有通過檢查, 預設值是 true
    // TODO: 資料欄位的檢查

    if (!categoryNameField.value) {
      isPass = false;
      categoryNameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫類別名稱`;
      categoryNameField.closest('.mb-3').classList.add('error');
    }
    if (!categoryTagField.value) {
      isPass = false;
      categoryTagField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫類別標籤`;
      categoryTagField.closest('.mb-3').classList.add('error');
    }


    if (isPass) {
      const fd = new FormData(document.forms[0]);

      fetch(`edit-api.php`, {
        method: 'POST',
        body: fd
      }).then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (obj.success) {
            myModal.show(); // 呈現 modal
          } else {
            alert('資料沒有修改')
          }

        }).catch(console.warn);
    }


  }


</script>
<?php include __DIR__ . '/parts/html-tail.php' ?>