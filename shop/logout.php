<!DOCTYPE html>
<html>
<head><title>會員登入</title></head>
<body>
<?php
session_start();
if (isset($_SESSION["username"])){
    unset($_SESSION["name"]);
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
}
header("location: index.php");
?>
</body>
</html>