<!DOCTYPE html>
<html>
<head><title>Ex07</title></head>
<body>
<?php
if ( isset($_POST["Reg"]) ) {
   $name = $_POST["name"];
   $email = $_POST["email"];
   print "姓名1 : " . $name . "<br/>";
   print "電子郵件地址 : " . $email . "<br/>";
   $pos = strpos($email, "@");
   $name1 = substr($email, 0, $pos);
   if ( strcmp($name , $name1) == 0 )
         print "輸入正確!<br/>";
   else  print "輸入錯誤!<br/>";
}
?>
<form action="Ex07.php" method="post">
使用者姓名: <input type="text" name="name" size ="10"/><br/>
電子郵件帳號: <input type="text" name="email" size="30"/><br/>
<br/><br/>
<input type="submit" name="Reg" value="登入"/>
</form>

</body>
</html>