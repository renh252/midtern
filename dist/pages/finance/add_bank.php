<?php
require __DIR__ . '/../parts/init.php';
$title = "新增銀行轉帳資料";
$pageName = "add_bank";

// 如果表單已經提交，檢查 donation_id 是否有效
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 取得捐款 ID
  $donation_id = $_POST['donation_id'];

  // 檢查該捐款 ID 是否存在於資料庫中
  $sql = "SELECT * FROM donations WHERE id = :donation_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['donation_id' => $donation_id]);
  $donation = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$donation) {
    // 如果 donation_id 不存在，顯示錯誤並終止
    $errorMessage = "提供的捐款 ID 不存在。";
  }
}
?>
<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <?php include ROOT_PATH . 'dist/pages/parts/navbar.php' ?>
    <?php include ROOT_PATH . 'dist/pages/parts/sidebar.php' ?>
    <main class="app-main pt-5">
      <div class="app-content-header">

        <div class="container-fluid">
          <div class="row mt-4">
            <div class="col-6">
              <h2>新增銀行轉帳資料</h2>
              <form onsubmit="sendData(event)" novalidate>
                <div class="mb-3">
                  <label for="donation_id" class="form-label">捐款編號</label>
                  <input type="text" class="form-control" id="donation_id" name="donation_id" required>
                  <?php if (isset($errorMessage)): ?>
                    <div class="form-text text-danger"><?= $errorMessage ?></div>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label for="donor_name" class="form-label">捐款人姓名</label>
                  <input type="text" class="form-control" id="donor_name" name="donor_name" required>
                  <div class="form-text"></div>
                </div>

                <div class="mb-3">
                  <label for="transfer_amount" class="form-label">匯款金額</label>
                  <input type="number" class="form-control" id="transfer_amount" name="transfer_amount" required>
                  <div class="form-text"></div>
                </div>

                <div class="mb-3">
                  <label for="transfer_date" class="form-label">匯款日期</label>
                  <input type="date" class="form-control" id="transfer_date" name="transfer_date" required>
                  <div class="form-text"></div>
                </div>

                <div class="mb-3">
                  <label for="account_last_5" class="form-label">帳號末五碼</label>
                  <input type="text" class="form-control" id="account_last_5" name="account_last_5" required>
                  <div class="form-text"></div>
                </div>

                <div class="mb-3">
                  <label for="reconciliation_status" class="form-label">對帳狀態</label>
                  <select class="form-select" id="reconciliation_status" name="reconciliation_status" required>
                    <option value="已完成">已完成</option>
                    <option value="未完成">未完成</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">新增資料</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-success" role="alert">
            資料新增成功
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
          <a class="btn btn-primary" href="bank.php">回到列表頁</a>
        </div>
      </div>
    </div>
  </div>

  <?php include __DIR__ . '/parts/html-scripts.php' ?>
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!--end::Required Plugin(Bootstrap 5)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <script src="<?= ROOT_URL ?>/dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)-->
  <!--begin::OverlayScrollbars Configure 設定滾動條-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      // 當鼠標離開滾動區域時，滾動條會自動隱藏；允許用戶通過點擊滾動條來進行滾動
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    // DOMContentLoaded確保在DOM完全加載後執行代碼
    document.addEventListener('DOMContentLoaded', function () {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        // 初始化滾動條，並傳遞配置選項，如主題和自動隱藏行為
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
</body>
<script>
  const myModal = new bootstrap.Modal('#exampleModal');

  const sendData = e => {
    e.preventDefault();

    const donationIdField = document.querySelector('#donation_id');
    const donorNameField = document.querySelector('#donor_name');
    const transferAmountField = document.querySelector('#transfer_amount');
    const transferDateField = document.querySelector('#transfer_date');
    const account_last_5Field = document.querySelector('#account_last_5');
    const reconciliationStatusField = document.querySelector('#reconciliation_status');


    let isPass = true;

    // Validate donation_id
    if (donationIdField.value.trim() === '') {
      isPass = false;
      donationIdField.closest('.mb-3').classList.add('error');
      const errorField = donationIdField.nextElementSibling;
      if (errorField) {
        errorField.innerHTML = "請填寫正確的捐款編號";
      }
    } else {
      donationIdField.closest('.mb-3').classList.remove('error');
    }

    if (donorNameField.value.trim() === '') {
      isPass = false;
      donorNameField.closest('.mb-3').classList.add('error');
      const errorField = donorNameField.nextElementSibling;
      if (errorField) {
        errorField.innerHTML = "請填寫正確的姓名";
      }
    } else {
      donorNameField.closest('.mb-3').classList.remove('error');
    }

    if (transferAmountField.value <= 0) {
      isPass = false;
      transferAmountField.closest('.mb-3').classList.add('error');
      const errorField = transferAmountField.nextElementSibling;
      if (errorField) {
        errorField.innerHTML = "請輸入正確的匯款金額";
      }
    } else {
      transferAmountField.closest('.mb-3').classList.remove('error');
    }

    if (transferDateField.value.trim() === '') {
      isPass = false;
      transferDateField.closest('.mb-3').classList.add('error');
      const errorField = transferDateField.nextElementSibling;
      if (errorField) {
        errorField.innerHTML = "請選擇匯款日期";
      }
    } else {
      transferDateField.closest('.mb-3').classList.remove('error');
    }
    if (isPass) {
      const fd = new FormData(document.forms[0]);

      fetch(`add_bank-api.php`, {
        method: 'POST',
        body: fd
      }).then(r => r.json())
        .then(obj => {
          if (!obj.success) {
            alert(`錯誤：${obj.error}`);
          } else {
            myModal.show(); // Show success modal
          }
        }).catch(err => {
          console.error('伺服器錯誤:', err);
          alert('伺服器發生錯誤，請稍後再試');
        });
    }
  }
</script>

</html>