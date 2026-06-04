
    <?php require_once '../config/db.php';
    require_once '../includes/header.php';

    $cart = $_SESSION['cart'] ?? [];
    $total = 0; ?>

    <h2 class="mb-4">Your Cart</h2>
    <?php if (empty($cart)): ?>
        <div class="alert alert-light text-center"> Your cart is empty.
            <a href="index.php">Browse shops</a>
        </div> <?php else: ?>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-borderless mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart as $id => $item): $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal; ?> <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end">$<?php echo number_format($subtotal, 2); ?></td>
                                <td class="text-end">
                                    <a href="removefromcart.php?id=
                                    <?php echo $id; ?>" class="text-danger small">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?> </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="2"><strong>Total</strong></td>
                            <td class="text-end"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a href="index.php" class="btn btn-outline-secondary">Continue Shopping</a>
            <a href="checkout.php" class="btn btn-dark">Proceed to Checkout &rarr;</a>
        </div>
    <?php endif; ?>
    <?php require_once '../includes/footer.php'; ?>
