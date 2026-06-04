<?php require_once '../config/db.php';
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $recipient_name = trim($_POST['recipient_name']);
    $address = trim($_POST['address']);
    $message = trim($_POST['message']);
    $cart = $_SESSION['cart'];
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    $stmt = $pdo->prepare(" INSERT INTO orders (user_id, recipient_name, address, message, total) VALUES (?, ?, ?, ?, ?) ");
    $stmt->execute([$user_id, $recipient_name, $address, $message, $total]);
    $order_id = $pdo->lastInsertId();
    $item_stmt = $pdo->prepare(" INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?) ");
    foreach ($cart as $product_id => $item) {
        $item_stmt->execute([$order_id, $product_id, $item['quantity'], $item['price']]);
    }

    if (!empty($_POST['add_sticker'])) {
        $_SESSION['sticker_order_id'] = $order_id;
        unset($_SESSION['cart']);
        header('Location: sticker.php');
        exit;
    }
    unset($_SESSION['cart']);
    header('Location: confirmation.php?order_id=' . $order_id);
    exit;
}
