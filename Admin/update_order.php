<?php require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';
$order_id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowed = ['pending', 'confirmed', 'delivered'];
    $status = in_array($_POST['status'], $allowed) ? $_POST['status'] : 'pending';
    $s = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $s->execute([$status, $order_id]);
    header('Location: orders.php');
    exit;
}
$stmt = $pdo->prepare("SELECT o.*, u.name AS customer FROM orders o JOIN users u ON o.user_id=u.id WHERE o.id=?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
$items = $pdo->prepare("SELECT oi.*, p.name AS product_name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=?");
$items->execute([$order_id]);
$items = $items->fetchAll(PDO::FETCH_ASSOC);
$sticker_stmt = $pdo->prepare("SELECT * FROM sticker_designs WHERE order_id = ?");
$sticker_stmt->execute([$order_id]);
$sticker = $sticker_stmt->fetch(PDO::FETCH_ASSOC);
?> <a href="orders.php" class="text-muted text-decoration-none">&larr; Back to Orders</a>
<h4 class="mt-3 mb-4">Order #<?php echo $order_id; ?></h4>
<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 mb-3">
            <h6>Order Details</h6>
            <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer']); ?></p>
            <p><strong>Recipient:</strong> <?php echo htmlspecialchars($order['recipient_name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            <p><strong>Message:</strong> <?php echo htmlspecialchars($order['message']); ?></p>
            <hr>
            <h6>Items</h6> <?php foreach ($items as $item): ?> <div class="d-flex justify-content-between small"> <span><?php echo htmlspecialchars($item['product_name']); ?>
                        x<?php echo $item['quantity']; ?></span>
                    <span>$
                        <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between fw-bold"> <span>Total</span> <span>$<?php echo number_format($order['total'], 2); ?></span> </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4 mb-3">
            <h6>Update Status</h6>
            <form method="POST"> <select name="status" class="form-select mb-3">
                    <?php foreach (['pending', 'confirmed', 'delivered'] as $st): ?>
                        <option value="<?php echo $st; ?>" <?php echo $order['status'] === $st ? 'selected' : ''; ?>>
                            <?php echo ucfirst($st); ?> </option> <?php endforeach; ?>
                </select>
                <button class="btn btn-dark w-100">Save Status</button>
            </form>
        </div>
        <?php if ($sticker): ?> <div class="card p-4 text-center">
                <h6>Custom Sticker</h6>
                <div style="width:120px;height:120px;border-radius:50%;margin:0 auto; overflow:hidden;border:3px dashed #ccc;background:#fff8f0; display:flex;flex-direction:column;align-items:center;justify-content:center;">
                    <img src="<?php echo htmlspecialchars($sticker['preview_img']); ?>" style="width:50px;height:50px;object-fit:contain;">
                    <p style="font-size:10px;font-weight:600;margin-top:5px;padding:0 6px;"> <?php echo htmlspecialchars($sticker['custom_text']); ?> </p>
                </div>
                <small class="text-muted mt-2 d-block">Print and attach to gift</small>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>