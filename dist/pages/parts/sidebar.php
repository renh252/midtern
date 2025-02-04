<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="<?= ROOT_URL ?>dist/pages/index.php" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="<?= ROOT_URL ?>dist/assets/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">寵物認養網站</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">
        <li class="nav-header">後台介面</li>
        <li class="nav-item menu">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-coin"></i>
            <p>
              金流管理
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/finance/donations.php" class="nav-link" onclick="return checkPrivilege('donation', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>捐款管理</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/finance/bank.php" class="nav-link" onclick="return checkPrivilege('donation', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>對帳管理</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/finance/expenses.php" class="nav-link" onclick="return checkPrivilege('donation', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>支出管理</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-bag"></i>
            <p>
              商城管理
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/shop/orders.php" class="nav-link" onclick="return checkPrivilege('shop', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>訂單</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/shop/products.php" class="nav-link" onclick="return checkPrivilege('shop', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>商品列表</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/shop/category.php" class="nav-link" onclick="return checkPrivilege('shop', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>商品類別</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/shop/promotions.php" class="nav-link" onclick="return checkPrivilege('shop', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>促銷活動</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-file-earmark-text"></i>
            <p>
              論壇管理
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/forums/post.php" class="nav-link" onclick="return checkPrivilege('post', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>文章</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/forums/comment.php" class="nav-link" onclick="return checkPrivilege('post', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>留言列表</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/forums/report.php" class="nav-link" onclick="return checkPrivilege('post', this)">
                <i class="nav-icon bi bi-circle"></i>
                <p>檢舉列表</p>
              </a>
            </li>
            <li class="nav-item">

              <a href="<?= ROOT_URL ?>dist/pages/forums/user_status.php" class="nav-link" onclick="return checkPrivilege('post', this)">

                <i class="nav-icon bi bi-circle"></i>
                <p>黑名單</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item menu">
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-smile"></i>
            <p>
              會員管理
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/users/Member Center/member_form/members_list.php" class="nav-link" onclick="return checkPrivilege('member', this)">
                <i class="nav-icon bi bi-people"></i>
                <p>會員列表</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/users/Member Center/manager_list/manager_list.php" class="nav-link" onclick="return checkPrivilege('member', this)">
                <i class="nav-icon bi bi-person"></i>
                <p>管理員列表</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/pets/pet-list.php" class="nav-link" onclick="return checkPrivilege('pet', this)">
            <i class="nav-icon fas fa-paw"></i>
            <p>寵物列表</p>
          </a>
        </li>
        <li class="nav-header">雜項</li>
        <li class="nav-item menu">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              儀表板
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/index.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/index2.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/index3.php" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v3</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-box-seam-fill"></i>
            <p>
              元件
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/widgets/small-box.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Small Box</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/widgets/info-box.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>info Box</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/widgets/cards.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Cards</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-clipboard-fill"></i>
            <p>
              排版
              <span class="nav-badge badge text-bg-secondary me-3">6</span>
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/unfixed-sidebar.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Default Sidebar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/fixed-sidebar.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Fixed Sidebar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/layout-custom-area.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Layout <small>+ Custom Area </small></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/sidebar-mini.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Sidebar Mini</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/collapsed-sidebar.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Sidebar Mini <small>+ Collapsed</small></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/logo-switch.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Sidebar Mini <small>+ Logo Switch</small></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/layout/layout-rtl.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Layout RTL</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-tree-fill"></i>
            <p>
              UI元件
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/UI/general.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>General</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/UI/icons.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Icons</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/UI/timeline.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Timeline</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-pencil-square"></i>
            <p>
              表單
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/forms/general.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>General Elements</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-table"></i>
            <p>
              表格
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/tables/simple.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Simple Tables</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">EXAMPLES</li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/generate/theme.html" class="nav-link">
            <i class="nav-icon bi bi-palette"></i>
            <p>主題產生器</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-box-arrow-in-right"></i>
            <p>
              授權
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-box-arrow-in-right"></i>
                <p>
                  Version 1
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= ROOT_URL ?>dist/pages/examples/login.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Login</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= ROOT_URL ?>dist/pages/examples/register.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Register</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-box-arrow-in-right"></i>
                <p>
                  Version 2
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= ROOT_URL ?>dist/pages/examples/login-v2.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Login</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= ROOT_URL ?>dist/pages/examples/register-v2.html" class="nav-link">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Register</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/examples/lockscreen.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Lockscreen</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">DOCUMENTATIONS</li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/introduction.html" class="nav-link">
            <i class="nav-icon bi bi-download"></i>
            <p>如何安裝</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/layout.html" class="nav-link">
            <i class="nav-icon bi bi-grip-horizontal"></i>
            <p>佈局</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/color-mode.html" class="nav-link">
            <i class="nav-icon bi bi-star-half"></i>
            <p>色彩模式</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-ui-checks-grid"></i>
            <p>
              構件
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/docs/components/main-header.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Main Header</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/docs/components/main-sidebar.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Main Sidebar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-filetype-js"></i>
            <p>
              Javascript
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= ROOT_URL ?>dist/pages/docs/javascript/treeview.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Treeview</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/browser-support.html" class="nav-link">
            <i class="nav-icon bi bi-browser-edge"></i>
            <p>瀏覽器支援</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/how-to-contribute.html" class="nav-link">
            <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
            <p>如何貢獻</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/faq.html" class="nav-link">
            <i class="nav-icon bi bi-question-circle-fill"></i>
            <p>FAQ</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= ROOT_URL ?>dist/pages/docs/license.html" class="nav-link">
            <i class="nav-icon bi bi-patch-check-fill"></i>
            <p>憑證</p>
          </a>
        </li>
        <li class="nav-header">MULTI LEVEL EXAMPLE</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>Level 1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>
              Level 1
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Level 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>
                  Level 2
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-record-circle-fill"></i>
                    <p>Level 3</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-record-circle-fill"></i>
                    <p>Level 3</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-record-circle-fill"></i>
                    <p>Level 3</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Level 2</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle-fill"></i>
            <p>Level 1</p>
          </a>
        </li>
        <li class="nav-header">LABELS</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle text-danger"></i>
            <p class="text">Important</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle text-warning"></i>
            <p>Warning</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-circle text-info"></i>
            <p>Informational</p>
          </a>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>


<!--end::Sidebar-->
<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 start-0 p-3">
  <div id="privilegeToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header  bg-primary text-white">
      <strong class="me-auto">權限提示</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      您沒有權限訪問此頁面
    </div>
  </div>
</div>

<!-- 確認權限-->
<script>
  function checkPrivilege(requiredPrivilege, linkElement) {
    var managerPrivileges = "<?php echo $_SESSION['manager_privileges']; ?>".split(',');
    if (!managerPrivileges.includes(requiredPrivilege)) {
      event.preventDefault();
      var toast = new bootstrap.Toast(document.getElementById('privilegeToast'));
      toast.show();
      return false;
    }
    return true;
  }
</script>
<!-- sidebar JS -->

<!--begin::Third Party Plugin(OverlayScrollbars) 可自定義的覆蓋滾動條-->
<script
  src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
  integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
  crossorigin="anonymous"></script>
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Required Plugin(popperjs for Bootstrap 5) Bootstrap彈出元素"（如工具提示和彈出窗口）-->
<script
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
  crossorigin="anonymous"></script>
<!--end::Required Plugin(popperjs for Bootstrap 5)-->
<!--begin::Required Plugin(Bootstrap 5)-->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
  integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
  crossorigin="anonymous"></script>
<!--end::Required Plugin(Bootstrap 5)-->

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
  document.addEventListener('DOMContentLoaded', function() {
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