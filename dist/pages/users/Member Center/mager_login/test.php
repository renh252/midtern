<?php
$servername = "172.23.53.156";    // 資料庫主機名
$username = "mfee59";           // MySQL 使用者名稱
$password = "12345";               // MySQL 密碼（預設是空）
$database = "membercenter"; //輸入指定的資料庫名稱

$con = mysqli_connect("$db_host", "$db_username", "$db_password", "$database");

if(!$con)
{
	die("連線失敗!!!!!");

	$ssql = "set names utf8";
	mysqli_query($con,$ssql);
}
?>