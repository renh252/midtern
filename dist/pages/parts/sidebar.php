
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
<!--begin::Sidebar Brand-->
<div class="sidebar-brand">
  <!--begin::Brand Link-->
  <a href="<?= ROOT_URL ?>dist/pages/index.php" class="brand-link">
    <!--begin::Brand Image-->
    <img
      src="<?= ROOT_URL ?>dist/assets/img/AdminLTELogo.png"
      alt="AdminLTE Logo"
      class="brand-image opacity-75 shadow"
    />
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
      data-accordion="false"
    >
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
              <p>捐款明細</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= ROOT_URL ?>dist/pages/finance/incomes.php" class="nav-link" onclick="return checkPrivilege('donation', this)">
              <i class="nav-icon bi bi-circle"></i>
              <p>收入表</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= ROOT_URL ?>dist/pages/finance/expenses.php" class="nav-link" onclick="return checkPrivilege('donation', this)">
              <i class="nav-icon bi bi-circle"></i>
              <p>支出表</p>
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
            <a href="<?= ROOT_URL ?>dist/pages/users/user.php" class="nav-link" onclick="return checkPrivilege('member', this)">
            <i class="nav-icon bi bi-people"></i>
            <p>會員列表</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= ROOT_URL ?>dist/pages/admin/admin.php" class="nav-link" onclick="return checkPrivilege('member', this)">
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


<!-- check Privilege-->
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
