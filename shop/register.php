<!DOCTYPE html>
<html>
<head><title>Ex06</title></head>
<body>
<?php
session_start();
// 取得表單欄位值
$name = $_POST["Name"];
$username = $_POST["UserName"];
$pass1 = $_POST["Pass1"];
$pass2 = $_POST["Pass2"];

// 檢查帳號欄位是否有輸入資料
if (empty($username)) {
 // 欄位沒填
 $error = "帳號欄位空白<br/>";
 echo "<font color='red'> $error </font>";
 header("Refresh: 3; url=./register.html");//新加入的
}
else {
 // 檢查兩次密碼是否相同
 if ($pass1 != $pass2) {
 // 密碼錯誤
 $error = "密碼輸入不相同<br/>";
 echo $error;//新加入的
 header("Refresh: 3; url=./register.html");//新加入的
 } else {
 // 表單處理, 顯示欄位輸入的資料
 $msg = "註冊成功 <br/>";
 $msg .= "姓名: ".$name."<br/>";
 $msg .= "帳號: ".$username."<br/>";
 $hashedPass = md5($pass1);//MD5
 $msg .= "密碼(MD5): ".$hashedPass."<br/>";
 
$_SESSION["database1"]=$name;
 $_SESSION["database2"]=$username;
 $_SESSION["database3"]=$hashedPass;
 echo $msg;
 header("Refresh: 3; url=./login.php"); //新加入的
 }

}
?>
</body>
</html>
