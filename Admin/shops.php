<?php
require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';

$error = '';
$success = '';

try {
    if (isset($_GET['delete'])) {
        $s = $pdo->prepare("DELETE FROM shops WHERE id = ?");
        $s->execute([(int)$_GET['delete']]);
        $success = 'Shop deleted successfully.';
    }

    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name        = trim($_POST['name']);
        $category    = $_POST['category'];
        $city        = trim($_POST['city']);
        $description = trim($_POST['description']);

        if (empty($name) || empty($category)) {
            $error = 'Please fill in all required fields.';
        } else {
            $s = $pdo->prepare("INSERT INTO shops (name, category, city, description) VALUES (?,?,?,?)");
            $s->execute([$name, $category, $city, $description]);
            $success = 'Shop added successfully.';
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $name        = trim($_POST['name']);
        $category    = $_POST['category'];
        $city        = trim($_POST['city']);
        $description = trim($_POST['description']);
        $id          = (int)$_POST['id'];

        if (empty($name) || empty($category)) {
            $error = 'Please fill in all required fields.';
        } else {
            $s = $pdo->prepare("UPDATE shops SET name=?, category=?, city=?, description=? WHERE id=?");
            $s->execute([$name, $category, $city, $description, $id]);
            $success = 'Shop updated successfully.';
        }
    }

    $editing = null;
    if (isset($_GET['edit'])) {
        $s = $pdo->prepare("SELECT * FROM shops WHERE id = ?");
        $s->execute([(int)$_GET['edit']]);
        $editing = $s->fetch(PDO::FETCH_ASSOC);
    }

    $shops = $pdo->query("SELECT * FROM shops ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Database error. Please try again.';
    error_log('Admin shops error: ' . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Manage Shops</h4>
    <button class="btn btn-dark btn-sm" onclick="document.getElementById('addForm').classList.toggle('d-none')">
        + Add Shop
    </button>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div id="addForm" class="card p-4 mb-4 d-none">
    <h6><?php echo $editing ? 'Edit Shop' : 'Add New Shop'; ?></h6>
    <form method="POST">
        <input type="hidden" name="action" value="<?php echo $editing ? 'edit' : 'add'; ?>">
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?php echo $editing['id']; ?>">
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Shop name" required
                    value="<?php echo htmlspecialchars($editing['name'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="cafe" <?php echo ($editing['category'] ?? '') === 'cafe' ? 'selected' : ''; ?>>Cafe</option>
                    <option value="gift_shop" <?php echo ($editing['category'] ?? '') === 'gift_shop' ? 'selected' : ''; ?>>Gift Shop</option>
                    <option value="bakery" <?php echo ($editing['category'] ?? '') === 'bakery' ? 'selected' : ''; ?>>Bakery</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="city" class="form-control" placeholder="City"
                    value="<?php echo htmlspecialchars($editing['city'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="description" class="form-control" placeholder="Description"
                    value="<?php echo htmlspecialchars($editing['description'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100">
                    <?php echo $editing ? 'Save' : 'Add'; ?>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shops as $shop): ?>
                <tr>
                    <td><?php echo $shop['id']; ?></td>
                    <td><?php echo htmlspecialchars($shop['name']); ?></td>
                    <td><?php echo $shop['category']; ?></td>
                    <td><?php echo htmlspecialchars($shop['city']); ?></td>
                    <td>
                        <a href="shops.php?edit=<?php echo $shop['id']; ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                        <a href="shops.php?delete=<?php echo $shop['id']; ?>"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Delete this shop?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($editing): ?>
    <script>
        document.getElementById('addForm').classList.remove('d-none');
    </script>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>