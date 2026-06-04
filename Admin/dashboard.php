<?php
require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';
$total_shops = $pdo->query("SELECT COUNT(*) FROM shops")->fetchColumn();
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_revenue = $pdo->query("SELECT SUM(total) FROM orders")->fetchColumn() ?? 0;
?>
<h4 class="mb-4">Dashboard</h4>
<div class="row g-3 mb-5">
    <div class="col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2">🏪</div>
            <div class="fs-4 fw-bold"><?php echo $total_shops; ?></div>
            <div class="text-muted small">Shops</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2">🎁</div>
            <div class="fs-4 fw-bold"><?php echo $total_products; ?></div>
            <div class="text-muted small">Products</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2">📦</div>
            <div class="fs-4 fw-bold"><?php echo $total_orders; ?></div>
            <div class="text-muted small">Orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3">
            <div class="fs-2">💰</div>
            <div class="fs-4 fw-bold">$<?php echo number_format($total_revenue, 2); ?></div>
            <div class="text-muted small">Revenue</div>
        </div>
    </div>
</div>
<div class="d-flex gap-3"> <a href="shops.php" class="btn btn-dark">Manage Shops</a>
    <a href="orders.php" class="btn btn-outline-dark">View Orders</a>
</div> <?php require_once '../includes/footer.php'; ?>