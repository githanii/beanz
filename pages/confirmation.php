<?php require_once '../config/db.php';
require_once '../includes/header.php';
$order_id = (int) ($_GET['order_id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$order) {
    header('Location: index.php');
    exit;
} ?> <div class="text-center py-5">
    <div class="mb-3" style="font-size:3rem">🎁</div>
    <h3>Order Placed!</h3>
    <p class="text-muted">Your gift is on its way to <strong><?php echo htmlspecialchars($order['recipient_name']); ?></strong> </p>
    <div class="card d-inline-block text-start mt-3 px-4 py-3">
        <p class="mb-1"><strong>Order #</strong>
            <?php echo $order['id']; ?></p>
        <p class="mb-1"><strong>Total:</strong>
            $<?php echo number_format($order['total'], 2); ?></p>
        <p class="mb-1"><strong>Deliver to:</strong>
            <?php echo htmlspecialchars($order['address']); ?></p>
        <p class="mb-0"><strong>Status:</strong>
            <span class="badge bg-warning text-dark">Pending</span>
        </p>
    </div>
    <div class="mt-4">
        <a href="orders.php" class="btn btn-outline-dark me-2">View My Orders</a>
        <a href="index.php" class="btn btn-dark">Continue Shopping</a>
    </div>
</div> <?php require_once '../includes/footer.php'; ?>