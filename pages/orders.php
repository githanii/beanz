<?php require_once '../config/db.php';
require_once '../config/session.php';
require_once '../includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">My Orders</h2>
<?php if (empty($orders)): ?>
    <div class="alert alert-light text-center py-5">
        <div style="font-size:3rem;margin-bottom:1rem;">📦</div>
        <p>You haven't placed any orders yet.</p>
        <a href="index.php" class="btn btn-dark mt-3">Start Shopping</a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($orders as $order): ?>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-title mb-1"> Order #<?php echo $order['id']; ?> </h6>
                                <p class="text-muted small mb-0"> <?php echo date('M d, Y', strtotime($order['created_at'])); ?> </p>
                            </div>
                            <?php $statusColors = ['pending' => 'warning text-dark', 'confirmed' => 'info', 'delivered' => 'success'];
                            $color = $statusColors[$order['status']] ?? 'secondary'; ?> <span class="badge bg-<?php echo $color; ?>">
                                <?php echo ucfirst($order['status']); ?> </span>
                        </div>
                        <div class="border-top pt-3">
                            <p class="small mb-2">
                                <strong>Sending to:</strong>
                                <?php echo htmlspecialchars($order['recipient_name']); ?>
                            </p>
                            <p class="small mb-3 text-muted">
                                <?php echo htmlspecialchars($order['address']); ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total</span> <span class="fs-5 fw-bold text-dark">
                                    $<?php echo number_format($order['total'], 2); ?> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php require_once '../includes/footer.php'; ?>