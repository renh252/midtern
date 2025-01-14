<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>login.php</title>
</head>
<body>
<?php
$servername = "172.23.53.156";    // 資料庫主機名
$username = "mfee59";           // MySQL 使用者名稱
$password = "12345";               // MySQL 密碼（預設是空）
$database = "membercenter"; //輸入指定的資料庫名稱
session_start();  // 啟用交談期
$name = "";  $password = "";
// 取得表單欄位值
if ( isset($_POST["manager_account"]) )
   $name = $_POST["manager_account"];
if ( isset($_POST["manager_password"]) )
   $password = $_POST["manager_password"];
// 檢查是否有表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 檢查是否有輸入使用者名稱和密碼
    if (isset($_POST['manager_account']) && isset($_POST['manager_password'])) {
        $manager_account = $_POST['manager_account'];
        $manager_password = $_POST['manager_password'];

        if ($manager_account != "" && $manager_password != "") {
            // 建立MySQL的資料庫連接 
            $link = mysqli_connect("172.23.53.156","mfee59", "12345","membercenter")
                or die("無法開啟MySQL資料庫連接!<br/>");

            // 送出UTF8編碼的MySQL指令
            mysqli_query($link, 'SET NAMES utf8'); 

            // 建立SQL指令字串
            $sql = "SELECT * FROM manager WHERE manager_password='" . $manager_password . "' AND manager_account='" . $manager_account . "'";

            // 執行SQL查詢
            $result = mysqli_query($link, $sql);
            $total_records = mysqli_num_rows($result);

            // 是否有查詢到使用者記錄
            if ($total_records > 0) {
                // 成功登入, 指定Session變數
                $_SESSION["login_session"] = true;
                header("Location: index.php");
            } else {  
                // 登入失敗
                echo "<center><font color='red'>使用者名稱或密碼錯誤!<br/></font></center>";
                $_SESSION["login_session"] = false;
            }
            mysqli_close($link);  // 關閉資料庫連接  
        }
    } else {
        echo "請輸入使用者名稱和密碼";
    }
}
?>
<form action="login.php" method="post" >
  <div align="center" style="background-color:#82FF82;padding:10px;margin-bottom:5px;">
    <br>
    <label for="name">帳號:</label>
    <input type="text" name="manager_account" id="manager_account" required autofocus/>
    <br>  
    <br> 
    <label for="password">密碼:</label>
    <input type="password" name="manager_password" id="manager_password" required/>
    <br>
    <br>
    <input type="submit" value="登入"/>
  </div>
</form>
<!--<form action="login.php" method="post">
    <label for="manager_account">使用者名稱:</label>
    <input type="text" name="manager_account" id="manager_account"><br>

    <label for="manager_password">密碼:</label>
    <input type="password" name="manager_password" id="manager_password"><br>

    <input type="submit" value="登入">
</form>!-->
</body>
</html>