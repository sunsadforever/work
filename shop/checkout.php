<?php
include 'functions.php';
$cart = getCartItems();
if (empty($cart)) {
    echo "<p>購物車是空的，請先選購商品。</p><a href='index.php'>返回首頁</a>";
    exit;
}
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}
clearCart();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>結帳完成</title>
</head>
<body>
<h2>✅ 感謝您的購買！</h2>
<p>本次消費金額：<b>$<?= $total ?></b></p>
<p>您的訂單已成功送出。</p>
<a href="index.php">返回首頁</a>
</body>
</html>
