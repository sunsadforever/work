<!DOCTYPE html>
<html>
<head><title>會員登入</title></head>
<body>
<?php
session_start();
// 檢查是否是表單送回
$acc = "";
$pwd = "";
$log=False;
if (isset($_SESSION["database1"])){
    $db_name=$_SESSION["database1"];
    $db_username=$_SESSION["database2"];
    $db_password=$_SESSION["database3"];
    $log=True;
}
if (isset($_POST["login"]) && $log){

    $acc=$_POST["name"];
    $pwd=$_POST["pwd"];
    if ( ( strcmp($acc , $db_username) == 0 ) and
        ( strcmp(md5($pwd) , $db_password) == 0 )){           
            $_SESSION["name"]=$db_name;
            $_SESSION["username"]=$db_username;
            $_SESSION["password"]=$db_password;  
            print "<font color='gold';font bold=10px;> 登入成功</font>";
            header("Refresh: 3; url=./index.php");
        }
            
   else  print "帳密錯誤，請重新輸入!<br/>";
}
?>
<?php 
if ( !(( strcmp($acc , $db_username) == 0 ) and
        ( strcmp(md5($pwd) , $db_password) == 0 ))){
?>
<form action="login.php" method="post">
使用者姓名: <input type="text" name="name" size ="10"/><br/>
密碼: <input type="password" name="pwd" size="30"/><br/>
<br/><br/>
<input type="submit" name="login" value="登入"/>
</form>
<?php
}?>
</body>
</html>
