<?php session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int) $_POST['product_id'];
    $name = htmlspecialchars($_POST['name']);
    $price = (float) $_POST['price'];
    $shop_id = (int) $_POST['shop_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id]
            = ['name' => $name, 'price' => $price, 'quantity' => 1, 'shop_id' => $shop_id];
    }
}
header('Location: shops.php?id=' . ($_POST['shop_id'] ?? 1));
exit;
