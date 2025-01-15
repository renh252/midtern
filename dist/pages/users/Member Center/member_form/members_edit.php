<?php
// 設定資料庫連接參數
$host = "127.0.0.1";
$db_username = "root";
$db_password = "P@ssw0rd";
$database = "pet_proj";

// 建立資料庫連接
$link = mysqli_connect($host, $db_username, $db_password, $database);

// 檢查連接是否成功
if (!$link) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 設置編碼，防止中文亂碼
mysqli_query($link, "SET NAMES utf8");

// 獲取會員ID
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // 取得該會員的資料
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($link, $sql);
    $user = mysqli_fetch_assoc($result);

    // 檢查表單是否提交
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_email = $_POST['user_email'];
        $user_name = $_POST['user_name'];
        $user_number = $_POST['user_number'];
        $user_address = $_POST['user_address'];
        $user_birthday = $_POST['user_birthday'];
        $user_level = $_POST['user_level'];

        // 更新會員資料的 SQL 語句
        $update_sql = "UPDATE users SET 
                       user_email='$user_email', 
                       user_name='$user_name',
                       user_number='$user_number',
                       user_address='$user_address',
                       user_birthday='$user_birthday',
                       user_level='$user_level',
                       WHERE user_id=$user_id";

        if (mysqli_query($link, $update_sql)) {
            echo "<script>alert('會員資料更新成功'); window.location.href='members_list.php';</script>";
        } else {
            echo "更新失敗: " . mysqli_error($link);
        }
    }
} else {
    echo "無效的會員ID";
    exit;
}
?>

<?php
// 先載入初始化檔案
require __DIR__ . '/../../../parts/init.php';

// 設定標題和頁面名稱
$title = "會員列表";
$pageName = "demo";

// 啟動 Session
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
ob_start();

// 檢查是否已登入
if (!isset($_SESSION['login_session']) || $_SESSION['login_session'] !== true) {
    header("Location: ../../Member Center/mager_login/login.php");  // 如果未登入，跳轉回登入頁面
    exit;
}
?>


<?php include ROOT_PATH . 'dist/pages/parts/head.php' ?>
<!--begin::Body-->
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
        }
        .back-link:hover {
            color: #333;
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
                            <h3 class="mb-0">會員資料編輯</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">breadcrumb</li>
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
                    <h1>歡迎來到管理頁面！</h1>
                    <a href="logout.php" class="btn btn-danger">登出</a>
                    <div class="container">
    <h1>編輯會員資料</h1>

    <form action="members_edit.php?user_id=<?php echo $user['user_id']; ?>" method="POST">
        <label for="user_email">會員Email:</label>
        <input type="email" name="user_email" id="user_email" value="<?php echo $user['user_email']; ?>" required>

        <label for="user_name">姓名:</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo $user['user_name']; ?>" required>

        <label for="user_number">電話:</label>
        <input type="text" name="user_number" id="user_number" value="<?php echo $user['user_number']; ?>" required>

        <label for="user_address">地址:</label>
        <input type="text" name="user_address" id="user_address" value="<?php echo $user['user_address']; ?>" required>

        <label for="user_birthday">生日:</label>
        <input type="date" name="user_birthday" id="user_birthday" value="<?php echo $user['user_birthday']; ?>" required>

        <label for="user_level">等級:</label>
        <input type="text" name="user_level" id="user_level" value="<?php echo $user['user_level']; ?>" required>

        <input type="submit" value="更新資料">
    </form>

    <a href="members_list.php" class="back-link">返回會員列表</a>
</div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <!--begin::Footer-->
        <?php include ROOT_PATH . 'dist/pages/parts/footer.php' ?>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>/dist/js/adminlte.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true,
                    },
                });
            }
        });
    </script>
    <!--end::Script-->
</body>
<!--end::Body-->

</html>


<!--
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯會員</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #4CAF50;
        }
        .back-link:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>編輯會員資料</h1>

    <form action="members_edit.php?user_id=<?php echo $user['user_id']; ?>" method="POST">
        <label for="user_email">會員Email:</label>
        <input type="email" name="user_email" id="user_email" value="<?php echo $user['user_email']; ?>" required>

        <label for="user_name">姓名:</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo $user['user_name']; ?>" required>

        <label for="user_number">電話:</label>
        <input type="text" name="user_number" id="user_number" value="<?php echo $user['user_number']; ?>" required>

        <label for="user_address">地址:</label>
        <input type="text" name="user_address" id="user_address" value="<?php echo $user['user_address']; ?>" required>

        <label for="user_birthday">生日:</label>
        <input type="date" name="user_birthday" id="user_birthday" value="<?php echo $user['user_birthday']; ?>" required>

        <label for="user_level">等級:</label>
        <input type="text" name="user_level" id="user_level" value="<?php echo $user['user_level']; ?>" required>

        <input type="submit" value="更新資料">
    </form>

    <a href="members_list.php" class="back-link">返回會員列表</a>
</div>

</body>
</html>
!-->