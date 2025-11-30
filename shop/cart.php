<?php
include 'functions.php';
if (!isset($_SESSION["username"])){
    header("location:login.php");
}
if (isset($_POST['update'])&& !empty($_POST['qty'])) { //新加入的
    foreach ($_POST['qty'] as $id => $qty) {
        updateCartQty($id, (int)$qty);
    }
}
else if(isset($_POST['update'])){
    echo "<font color='red';font size='5px'> 沒東西 </font>"; //新加入的
}

if (isset($_GET['remove'])) {
    removeFromCart($_GET['remove']);
}

$cart = getCartItems();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>購物車</title>
<style>
body { font-family: "微軟正黑體"; margin: 40px; }
table { border-collapse: collapse; width: 60%; }
td, th { padding: 10px; border: 1px solid #aaa; text-align: center; }
button { padding: 5px 10px; }
</style>
</head>
<body>
<h2>🧺 我的購物車</h2>

<form method="post">
<table>
<tr><th>商品</th><th>價格</th><th>數量</th><th>小計</th><th>刪除</th></tr>
<?php $total = 0; foreach ($cart as $id => $item): ?>
<tr>
<td><?= htmlspecialchars($item['name']) ?></td>
<td>$<?= $item['price'] ?></td>
<td><input type="number" name="qty[<?= $id ?>]" value="<?= $item['qty'] ?>" min="1" style="width:60px"></td>
<td>$<?= $item['price'] * $item['qty'] ?></td>
<td><a href="?remove=<?= $id ?>">❌</a></td>
</tr>
<?php $total += $item['price'] * $item['qty']; endforeach; ?>
<tr>
<th colspan="3">總計</th>
<th colspan="2">$<?= $total ?></th>
</tr>
</table>
<p>

<button name="update">更新數量</button>
<a href="index.php">繼續購物</a> |
<a href="checkout.php">前往結帳</a>
</p>
</form>
</body>
</html>
