<?php require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';
$user_id = $_SESSION['user_id'];
$shop = $pdo->prepare("SELECT * FROM shops WHERE owner_id = ?");
$shop->execute([$user_id]);
$shop = $shop->fetch(PDO::FETCH_ASSOC);
?> <h4 class="mb-4">Welcome,
    <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h4>
<?php if (!$shop): ?>
    <div class="alert alert-info"> You don't have a shop yet.
        <a href="shop.php" class="alert-link">Create one now</a>
    </div> <?php else: ?>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card p-3">
                <h6>Your Shop</h6>
                <p class="fw-bold"><?php echo htmlspecialchars($shop['name']); ?></p>
                <p class="text-muted small"><?php echo htmlspecialchars($shop['description']); ?></p>
                <a href="shop.php" class="btn btn-sm btn-dark">Edit Details</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="products.php">Manage Products</a></li>
                    <li><a href="../pages/index.php">View Public Site</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require_once '../includes/footer.php'; ?>