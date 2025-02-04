<?php
# 管理者登入驗證
# require __DIR__ . '/parts/admin-required.php'; 
require __DIR__ . '/../parts/init.php';
$title = "新增寵物資訊"; // 這個變數可修改，用在<head>的標題
$pageName = "pet-add"; // 這個變數可修改，用在sidebar的按鈕active
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
              <h3 class="mb-0">新增寵物資訊</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="./../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="./pet-list.php">寵物列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">新增寵物資訊</li>
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
                      <label for="name" class="col-sm-2 col-form-label">名字 **</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="species" class="col-sm-2 col-form-label">物種 **</label>
                      <div class="col-sm-10">
                        <select class="form-select" aria-label="select species" name="species">
                          <option value="null" selected disabled>請選擇</option>
                          <option value="狗">狗</option>
                          <option value="貓">貓</option>
                        </select>
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="variety" class="col-sm-2 col-form-label">品種</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="variety" name="variety" placeholder="請輸入品種">
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <div class="col-sm-2 col-form-label">性別 **</div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="gender"
                            id="genderRadios1"
                            value="公"
                            checked />
                          <label class="form-check-label" for="genderRadios1"> 公 </label>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="gender"
                            id="genderRadios2"
                            value="母" />
                          <label class="form-check-label" for="genderRadios2"> 母 </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="birthday" class="col-sm-2 col-form-label">生日 **</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="birthday" name="birthday">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="weight" class="col-sm-2 col-form-label">體重(公斤) **</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="weight" name="weight" step="0.01">
                      </div>
                      <div class="form-text"></div>
                    </div>
                    <div class="row mb-3 align-items-center">
                      <label for="chip" class="col-sm-2 col-form-label">晶片號碼(10碼數字) **</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" id="chip" name="chip" value="">
                        <div class="form-text"></div>
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
                            checked />
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
                            value="1" />
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
                            checked />
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
                            value="1" />
                          <label class="form-check-label" for="fixed2"> 是 </label>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                      <label for="avatar" class="col-sm-2 col-form-label">大頭貼</label>
                      <div class="col-sm-10">
                        <img src="" alt="" class="avatar-preview" style="max-width: 200px; margin-bottom: 10px;">
                        <input type="file" class="form-control" id="avatarInput" name="avatar" accept="image/*">
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">提交</button>
                      <button type="button" class="btn btn-light float-end" onclick="goBack()">取消</button>
                    </div>
                </form>

                <form name="upload_form" hidden>
                  <input type="file" name="avatar" accept="image/jpeg,image/png" />
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-success" role="alert">
              資料新增成功!
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
    const weightField = document.querySelector('#weight');
    const speciesField = document.querySelector('select[name="species"]');
    const myModal = new bootstrap.Modal('#pet-add-modal');
    const avatarInput = document.getElementById('avatarInput');
    const birthdayField = document.querySelector('#birthday');
    const chipField = document.querySelector('#chip');
    let selectedFile = null;

    // 為名字欄位添加 blur 事件監聽器
    nameField.addEventListener('blur', validateName);

    function validateName() {
      const errorElement = nameField.closest('.row').querySelector('.form-text');
      if (nameField.value.length < 2) {
        errorElement.innerHTML = '名字至少要兩個字';
        nameField.closest('.mb-3').classList.add('error');
      } else {
        errorElement.innerHTML = '';
        nameField.closest('.mb-3').classList.remove('error');
      }
    }
    avatarInput.onchange = (e) => {
      const file = e.target.files[0];
      if (file) {
        selectedFile = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          const myImg = document.querySelector('img.avatar-preview');
          myImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    };

    // 為生日欄位添加 blur 事件監聽器
    birthdayField.addEventListener('blur', validateBirthday);

    function validateBirthday() {
      const errorElement = birthdayField.closest('.row').querySelector('.form-text');
      if (!errorElement) {
        console.error('找不到生日欄位的錯誤訊息元素');
        return;
      }

      const inputDate = new Date(birthdayField.value);
      const today = new Date();
      // 設置輸入日期和今天的時間為當天的開始（00:00:00）
      inputDate.setHours(0, 0, 0, 0);
      today.setHours(0, 0, 0, 0);

      if (isNaN(inputDate.getTime())) {
        // 日期無效
        errorElement.innerHTML = '請輸入有效的日期';
        birthdayField.closest('.mb-3').classList.add('error');
      } else if (inputDate > today) {
        // 日期超過今天
        errorElement.innerHTML = '生日不能超過今天';
        birthdayField.closest('.mb-3').classList.add('error');
      } else {
        // 日期有效
        errorElement.innerHTML = '';
        birthdayField.closest('.mb-3').classList.remove('error');
      }
    }

    // 體重欄位驗證
    weightField.addEventListener('blur', validateWeight);

    function validateWeight() {
      const errorElement = weightField.closest('.row').querySelector('.form-text');
      let weight = parseFloat(weightField.value);

      if (isNaN(weight) || weight <= 0) {
        errorElement.innerHTML = '請輸入正確的體重';
        weightField.closest('.mb-3').classList.add('error');
      } else {
        // 如果小數點後超過兩位，則四捨五入到第二位
        if (weight.toString().split('.')[1]?.length > 2) {
          weight = Math.round(weight * 100) / 100;
          weightField.value = weight.toFixed(2);
        }
        errorElement.innerHTML = '';
        weightField.closest('.mb-3').classList.remove('error');
      }
    }

    // 為晶片號碼欄位添加 blur 事件監聽器
    chipField.addEventListener('blur', validateChip);

    function validateChip() {
      const errorElement = chipField.closest('.row').querySelector('.form-text');
      if (!errorElement) {
        console.error('找不到晶片號碼欄位的錯誤訊息元素');
        return;
      }

      const chipNumber = chipField.value.trim();
      const chipRegex = /^\d{10}$/; // 正則表達式：匹配10個數字

      if (chipNumber === '') {
        errorElement.innerHTML = '請填入晶片號碼(10碼純數字)';
        chipField.closest('.mb-3').classList.add('error');
      } else if (!chipRegex.test(chipNumber)) {
        // 晶片號碼不符合要求
        errorElement.innerHTML = '晶片號碼必須為10碼數字';
        chipField.closest('.mb-3').classList.add('error');
      } else {
        // 晶片號碼有效
        errorElement.innerHTML = '';
        chipField.closest('.mb-3').classList.remove('error');
      }
    }

    const sendData = e => {
      e.preventDefault(); //不要讓表單送出

      nameField.closest('.mb-3').classList.remove('error');
      weightField.closest('.mb-3').classList.remove('error');
      speciesField.closest('.mb-3').classList.remove('error');

      let isPass = true; //有沒有通過檢查，預設true
      // TODO: 資料欄位的檢查 birthday variety

      // 驗證名字
      validateName();
      if (nameField.closest('.mb-3').classList.contains('error')) {
        isPass = false;
      }

      // 驗證體重
      validateWeight();
      if (weightField.closest('.mb-3').classList.contains('error')) {
        isPass = false;
      }

      // 驗證生日
      validateBirthday();
      if (birthdayField.closest('.mb-3').classList.contains('error')) {
        isPass = false;
      }

      // 驗證晶片號碼
      validateChip();
      if (chipField.closest('.mb-3').classList.contains('error')) {
        isPass = false;
      }

      // 驗證是否絕育
      const isfixedField = document.querySelector('input[name="fixed"]:checked');
      if (!isfixedField || (isfixedField.value !== '0' && isfixedField.value !== '1')) {
        const errorElement = document.querySelector('input[name="fixed"]').closest('.row').querySelector('.form-text');
        if (errorElement) {
          errorElement.innerHTML = '請選擇是否絕育';
          document.querySelector('input[name="fixed"]').closest('.mb-3').classList.add('error');
        }
        isPass = false;
      }

      // 驗證物種
      const speciesErrorElement = speciesField.closest('.row').querySelector('.form-text');
      if (speciesField.value === 'null') {
        speciesErrorElement.innerHTML = '請選擇物種';
        speciesField.closest('.mb-3').classList.add('error');
        isPass = false;
      } else {
        speciesErrorElement.innerHTML = '';
        speciesField.closest('.mb-3').classList.remove('error');
      }

      if (isPass) {
        //先做一個空的表單
        const fd = new FormData(document.forms[0]);

        // 如果有選擇檔案，添加到 FormData
        if (selectedFile) {
          fd.set('avatar', selectedFile);
        }

        fetch(`./api/pet-add-api.php`, {
            method: 'POST',
            body: fd
          }).then(r => r.json())
          .then(data => {
            console.log(data);
            if (data.success) {
              myModal.show();
            } else {
              if (data.error === 'duplicate_chip') {
                // 顯示晶片號碼重複的錯誤
                const chipErrorElement = chipField.closest('.row').querySelector('.form-text');
                if (chipErrorElement) {
                  chipErrorElement.innerHTML = '晶片號碼重複';
                  chipField.closest('.mb-3').classList.add('error');
                }
              } else {
                // 處理其他錯誤
                alert('新增失敗');
              }
            }
          }).catch(error => {
            console.error('Error:', error);
            alert('新增過程中發生錯誤');
          })
        document.querySelector('form').onsubmit = sendData;
      }
    };

    function goBack() {
      window.history.back();
    }
  </script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>