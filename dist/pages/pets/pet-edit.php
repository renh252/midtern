<?php
# 管理者登入驗證
# require __DIR__ . '/parts/admin-required.php'; 
require __DIR__ . '/../parts/init.php';
$title = "編輯寵物資訊"; // 這個變數可修改，用在<head>的標題
$pageName = "pet-edit"; // 這個變數可修改，用在sidebar的按鈕active

// 如果網址列有id就轉換成整數(避免SQL注入)
$id = empty($_GET['id']) ? 0 : intval($_GET['id']);

if ($id === 0) {
  header('Location:pet-list.php');
  exit;
}

# 讀取該筆資料
$sql = "SELECT * FROM pets WHERE id = $id";
$r = $pdo->query($sql)->fetch();
# 如果沒有對應的資料
if (empty($r)) {
  header('Location:pet-list.php');
  exit;
}

?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
<!--begin::Body-->
<style>
  form .mb-3 .form-text {
    display: none;
    color: red;
  }

  form .mb-3.error input.form-control {
    border: 2px solid red;
  }

  form .mb-3.error .form-text {
    display: block;
    color: red;
  }
</style>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper 網頁的主要內容在這-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <?php include ROOT_PATH . 'dist/pages/parts/navbar.php' ?>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <?php include ROOT_PATH . 'dist/pages/parts/sidebar.php' ?>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main pt-5">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">修改寵物資訊</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="./../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pet-list.php">寵物列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">修改寵物資訊</li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                  <div class="card-title">表單</div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <form onsubmit="sendData(event)" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="row mb-3 align-items-center">
                      <input type="hidden" name="id" value="<?= $r['id'] ?>">
                      <label for="id" class="col-sm-2 col-form-label">編號</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="id" value="<?= $r['id'] ?>" disabled>
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="name" class="col-sm-2 col-form-label">名字 **</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $r['name'] ?>">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <input type="hidden" name="species" value="<?= $r['species'] ?>">
                      <label for="species" class="col-sm-2 col-form-label">物種 **</label>
                      <div class="col-sm-10">
                        <input type="text" name="species" class="form-control" value="<?= isset($r['species']) ? $r['species'] : '' ?>">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <input type="hidden" name="variety" value="<?= $r['variety'] ?>">
                      <label for="variety" class="col-sm-2 col-form-label">品種</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $r['variety'] ?>">
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <div class="col-sm-2 col-form-label">性別 **</div>
                      <div class="col-sm-1">
                        <input type="hidden" name="gender" value="<?= $r['gender'] ?>">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            id="genderRadios1"
                            value="公"
                            <?= $r['gender'] === '公' ? 'checked' : '' ?> disabled />
                          <label class="form-check-label" for="genderRadios1"> 公 </label>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            id="genderRadios2"
                            value="母"
                            <?= $r['gender'] === '母' ? 'checked' : '' ?> disabled />
                          <label class="form-check-label" for="genderRadios2"> 母 </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="birthday" class="col-sm-2 col-form-label">生日</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $r['birthday'] ?>">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="weight" class="col-sm-2 col-form-label">體重</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="<?= $r['weight'] ?>">
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="chip" class="col-sm-2 col-form-label">晶片號碼</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="chip" name="chip" value="<?= $r['chip_number'] ?>">
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <div class="col-sm-2 col-form-label">是否領養 **</div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="is-adopted"
                            id="is-adopted1"
                            value="0"
                            <?= $r['is_adopted'] == '0' ? 'checked' : '' ?> />
                          <label class="form-check-label" for="is-adopted1"> 否 </label>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="is-adopted"
                            id="is-adopted2"
                            value="1"
                            <?= $r['is_adopted'] == '1' ? 'checked' : '' ?> />
                          <label class="form-check-label" for="is-adopted2"> 是 </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <div class="col-sm-2 col-form-label">是否絕育 **</div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="fixed"
                            id="fixed1"
                            value="0"
                            <?= $r['fixed'] == '0' ? 'checked' : '' ?> />
                          <label class="form-check-label" for="fixed1"> 否 </label>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="fixed"
                            id="fixed2"
                            value="1"
                            <?= $r['fixed'] == '1' ? 'checked' : '' ?> />
                          <label class="form-check-label" for="fixed2"> 是 </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="avatar" class="col-sm-2 col-form-label">大頭貼</label>
                      <div class="col-sm-10">
                        <?php if (!empty($r['main_photo'])): ?>
                          <img src="<?= ROOT_URL .'dist/pages/pets'. $r['main_photo'] ?>" alt="Current Avatar" style="max-width: 200px; margin-bottom: 10px;">
                        <?php endif; ?>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        <input type="hidden" name="old_avatar" value="<?= $r['main_photo'] ?>">
                        <small class="form-text text-muted">上傳新照片將覆蓋原有照片</small>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">修改</button>
                      <button type="button" class="btn btn-light float-end" onclick="goBack()">取消</button>
                    </div>
                </form>
                <!--end::Form-->
              </div>

            </div>
          </div>
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->

    <!-- Modal -->
    <div class="modal fade" id="pet-add-modal" tabindex="-1" aria-labelledby="pet-add-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">修改結果</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-success" role="alert">
              資料修改成功!
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <a href="pet-list.php" class="btn btn-primary">回到列表</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
    <!-- 資料未修改 Modal -->
    <div class="modal fade" id="noChangeModal" tabindex="-1" aria-labelledby="noChangeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="noChangeModalLabel">修改結果</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            資料未修改
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            <a href="pet-list.php" class="btn btn-primary">回到列表</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

    <!--begin::Footer-->
    <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Required Plugin(AdminLTE)-->
  <script src="<?= ROOT_URL ?>/dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)-->
  <!-- Customized Script -->
  <script>
    const nameField = document.querySelector('#name');
    const myModal = new bootstrap.Modal('#pet-add-modal');

    const sendData = e => {
      e.preventDefault(); //不要讓表單送出

      // 重置所有錯誤提示
      document.querySelectorAll('.mb-3').forEach(el => el.classList.remove('error'));
      document.querySelectorAll('.form-text').forEach(el => el.innerHTML = '');

      let isPass = true; //有沒有通過檢查，預設true

      // 驗證名字
      if (nameField.value.length < 2) {
        isPass = false;
        nameField.nextElementSibling.innerHTML = '名字至少要兩個字';
        nameField.closest('.mb-3').classList.add('error');
      }

      // 驗證生日
      const birthdayField = document.querySelector('#birthday');
      if (!birthdayField.value) {
        isPass = false;
        birthdayField.nextElementSibling.innerHTML = '請選擇生日';
        birthdayField.closest('.mb-3').classList.add('error');
      }

      // 驗證體重
      const weightField = document.querySelector('#weight');
      if (weightField.value && (isNaN(weightField.value) || Number(weightField.value) <= 0)) {
        isPass = false;
        weightField.nextElementSibling.innerHTML = '請輸入有效的體重';
        weightField.closest('.mb-3').classList.add('error');
      }

      // 驗證是否領養
      const isAdoptedField = document.querySelector('input[name="is-adopted"]:checked');
      if (!isAdoptedField) {
        isPass = false;
        const errorElement = document.querySelector('input[name="is-adopted"]').closest('.row').querySelector('.form-text');
        if (errorElement) {
          errorElement.innerHTML = '請選擇是否領養';
          document.querySelector('input[name="is-adopted"]').closest('.mb-3').classList.add('error');
        }
      }

      // 驗證是否絕育
      const isFixedField = document.querySelector('input[name="fixed"]:checked');
      if (!isFixedField) {
        isPass = false;
        const errorElement = document.querySelector('input[name="fixed"]').closest('.row').querySelector('.form-text');
        if (errorElement) {
          errorElement.innerHTML = '請選擇是否絕育';
          document.querySelector('input[name="fixed"]').closest('.mb-3').classList.add('error');
        }
      }

      if (isPass) {
        // 如果通過驗證，發送 AJAX 請求
        const fd = new FormData(document.forms[0]);
        fetch(`./api/pet-edit-api.php`, {
            method: 'POST',
            body: fd
          }).then(r => r.json())
          .then(obj => {
            console.log(obj);
            if (obj.success) {
              myModal.show();
            } else {
              if (obj.errors) {
                for (let k in obj.errors) {
                  const el = document.querySelector(`#${k}`);
                  if (el) {
                    el.closest('.mb-3').classList.add('error');
                    el.nextElementSibling.innerHTML = obj.errors[k];
                  }
                }
              } else {
                // 顯示資料未修改的 Modal
                const noChangeModal = new bootstrap.Modal(document.getElementById('noChangeModal'));
                noChangeModal.show();
              }
            }
          }).catch(ex => {
            console.log(ex)
            // 如果發生錯誤，也顯示資料未修改的 Modal
            const noChangeModal = new bootstrap.Modal(document.getElementById('noChangeModal'));
            noChangeModal.show();
          });
      }
    };
    // 確保在 DOM 加載完成後初始化 Modal
    document.addEventListener('DOMContentLoaded', function() {
      const noChangeModal = new bootstrap.Modal(document.getElementById('noChangeModal'));
    });

    function goBack() {
      window.history.back();
    }
  </script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>