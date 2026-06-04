<?php require_once '../config/db.php';
require_once '../includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?> <h2 class="mb-4">Checkout</h2>
<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="mb-3">Gift Details</h5>
            <form action="placeorder.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Recipient Name</label>
                    <input type="text" name="recipient_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Delivery Address</label>
                    <textarea name="address" class="form-control" rows="2" required>
                          </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Personal Message <span class="text-muted">(optional)</span>
                    </label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Write a note to attach to the gift...">
                        </textarea>
                </div>
                <div class="mb-3 p-3 border rounded bg-light">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="add_sticker" id="add_sticker" value="1">
                        <label class="form-check-label" for="add_sticker">
                            🎨 Add a custom sticker to this order </label>
                    </div>
                    <small class="text-muted"> Design a personalised sticker that will be printed and attached to your gift. </small>
                </div>
                <button class="btn btn-dark w-100 mt-2"> Place Order — $<?php echo number_format($total, 2); ?>
                </button>
                
            </form>
        </div>
    </div> <!-- RIGHT: Order summary -->
    <div class="col-md-5">
        <div class="card p-4">
            <h5 class="mb-3">Order Summary</h5>
            <?php foreach ($cart as $item): ?>
                <div class="d-flex justify-content-between mb-2 small">
                    <span>
                        <?php echo htmlspecialchars($item['name']); ?>
                        <span class="text-muted">x<?php echo $item['quantity']; ?>
                        </span>
                    </span>
                    <span>$
                        <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                    </span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span> <span>$<?php echo number_format($total, 2); ?>
                </span>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
</body>

</html>