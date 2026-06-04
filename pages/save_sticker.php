<?php require_once '../config/db.php';
session_start();
if (!isset($_SESSION['sticker_order_id'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_SESSION['sticker_order_id'];
    $template = trim($_POST['template']);
    $custom_text = trim($_POST['custom_text']);
    $allowed = ['birthday', 'thankyou', 'love', 'celebration'];
    if (!in_array($template, $allowed)) {
        $template = 'birthday';
    }
    $preview_img = '/finalphpproject/assets/images/stickers/' . $template . '.png';
    $stmt = $pdo->prepare(" INSERT INTO sticker_designs (order_id, template, custom_text, preview_img) VALUES (?, ?, ?, ?) ");
    $stmt->execute([$order_id, $template, $custom_text, $preview_img]);
    unset($_SESSION['sticker_order_id']);
    header('Location: confirmation.php?order_id=' . $order_id);
    exit;
}
