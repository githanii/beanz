<?php require_once 'guard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beanz Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container"> <a class="navbar-brand" href="dashboard.php">⚙️ Beanz Admin</a>
            <div class="d-flex gap-3 ms-auto">
                 <a href="dashboard.php" class="text-white text-decoration-none small">Dashboard</a> 
                 <a href="shops.php" class="text-white text-decoration-none small">Shops</a>
                  <a href="orders.php" class="text-white text-decoration-none small">Orders</a> 
                  <a href="../pages/logout.php" class="text-danger text-decoration-none small">Logout</a> 
                </div>
        </div>
    </nav>
    <div class="container py-4">