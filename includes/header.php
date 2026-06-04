<?php 
require_once '../config/session.php';
session_start();
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beanz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/finalphpproject/assests/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/finalphpproject/pages/index.php">Beanz</a>
            <div class="ms-auto d-flex gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/finalphpproject/pages/orders.php" class="btn btn-outline-secondary btn-sm">My Orders</a>
                    <a href="/finalphpproject/pages/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                <?php else: ?>
                    <a href="/finalphpproject/pages/login.php" class="btn btn-outline-dark btn-sm">Login</a>
                <?php endif; ?>
                <a href="/finalphpproject/pages/cart.php" class="btn btn-dark btn-sm">
                    Cart (<?php echo array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?>)
                </a>
            </div>
    </nav>
    <div class="container py-4">