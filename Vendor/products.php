<?php
require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

try {
    $shop = $pdo->prepare("SELECT id FROM shops WHERE owner_id = ?");
    $shop->execute([$user_id]);
    $shop = $shop->fetch(PDO::FETCH_ASSOC);

    if (!$shop) {
        header('Location: shop.php');
        exit;
    }

    $shop_id = $shop['id'];

    if (isset($_GET['delete'])) {
        $del = $pdo->prepare("DELETE FROM products WHERE id = ? AND shop_id = ?");
        $del->execute([(int)$_GET['delete'], $shop_id]);
        $success = 'Product deleted successfully.';
    }

    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name        = trim($_POST['name']);
        $price       = (float)$_POST['price'];
        $description = trim($_POST['description']);

        if (empty($name) || $price <= 0) {
            $error = 'Please fill in all fields correctly.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (shop_id, name, price, description) VALUES (?,?,?,?)");
            $stmt->execute([$shop_id, $name, $price, $description]);
            $success = 'Product added successfully.';
        }
    }

    $products = $pdo->prepare("SELECT * FROM products WHERE shop_id = ? ORDER BY id DESC");
    $products->execute([$shop_id]);
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Database error. Please try again.';
    error_log('Products error: ' . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Products</h4>
    <button class="btn btn-dark btn-sm" onclick="document.getElementById('addForm').classList.toggle('d-none')">
        + Add Product
    </button>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div id="addForm" class="card p-4 mb-4 d-none">
    <h6>Add New Product</h6>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Product name" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" min="0" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="description" class="form-control" placeholder="Description">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">Add</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td>$<?php echo number_format($p['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($p['description']); ?></td>
                    <td>
                        <a href="products.php?delete=<?php echo $p['id']; ?>"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>