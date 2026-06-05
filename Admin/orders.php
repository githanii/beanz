<?php require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';
$orders = $pdo->query(" SELECT o.*, u.name AS customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC ")->fetchAll(PDO::FETCH_ASSOC);
?> <h4 class="mb-4">All Orders</h4>
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Recipient</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($orders as $order): ?> <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['recipient_name']); ?></td>
                    <td>$<?php echo number_format($order['total'], 2); ?></td>
                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                    <td> <?php $badges = ['pending' => 'warning text-dark', 'confirmed' => 'primary', 'delivered' => 'success'];
                            $b = $badges[$order['status']] ?? 'secondary'; ?> 
                            <span class="badge bg-<?php echo $b; ?>">
                             <?php echo ucfirst($order['status']); ?>
                             </span> </td>
                    <td> <a href="update_order.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-dark">Update</a> </td>
                </tr> <?php endforeach; ?> </tbody>
    </table>
</div> <?php require_once '../includes/footer.php'; ?>