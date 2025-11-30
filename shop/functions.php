<?php
session_start();
$date = strtotime("+10 days", time());
function addToCart($id, $name, $price, $qty = 1) {
    
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$id] = ['name' => $name, 'price' => $price, 'qty' => $qty];
    }
}

function removeFromCart($id) {
    if (isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
}

function updateCartQty($id, $qty) {
    if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['qty'] = $qty;
}

function getCartItems() {
    return $_SESSION['cart'] ?? [];
}

function clearCart() {
    unset($_SESSION['cart']);
}
?>