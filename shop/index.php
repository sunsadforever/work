<?php
include 'functions.php';

$products = [
    1 => ['name' => 'T-Shirt', 'price' => 350],
    2 => ['name' => 'Jeans', 'price' => 800],
    3 => ['name' => 'Sneakers', 'price' => 1200],
];

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $product = $products[$id];
    addToCart($id, $product['name'], $product['price']);
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Noto+Serif+TC:wght@300;500;700&display=swap" rel="stylesheet">
<meta charset="UTF-8">
<title>商品列表</title>
<style>

table { border-collapse: collapse; width: 50%; }
td, th { padding: 10px; border: 1px solid #aaa; text-align: center; }
button { padding: 5px 10px; }

</style>
<link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
  <div class="header">
    <h1 style="text-align: center;">歡迎來到朝陽小商店</h1>
    <p style="text-align: center;"><a href="cart.php">查看購物車</a></p>
    
<?php
    if (!isset($_SESSION["username"])){
?>
        <p><a href="login.php">登入</a></p>
        <p><a href="register.html">註冊</a></p>
<?php     
}else{   
    ?>
        <p><a href="logout.php">登出</a></p>
        
<?php
    }
?>
</div>
  <div class="second"></div>
  <div class="center">
    <h2 style="text-align: center;text-shadow:10px 10px 50px pink">🛒 商品列表</h2>
    <table>
<tr><th>商品名稱</th><th>價格</th><th>操作</th></tr>
<?php
foreach ($products as $id => $p): ?>
<tr class="product-row product-<?= $id ?>">
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= $p['price']?></td>
<td>
<form method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <button name="add">加入購物車</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
  <div class="footer"></div>
</div>
    




</body>
</html>