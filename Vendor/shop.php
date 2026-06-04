<?php require_once 'guard.php';
require_once '../config/db.php';
require_once 'header.php';
$user_id = $_SESSION['user_id'];
$shop = $pdo->prepare("SELECT * FROM shops WHERE owner_id = ?");
$shop->execute([$user_id]);
$shop = $shop->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $city = trim($_POST['city']);
    $description = trim($_POST['description']);
    if ($shop) {
        $s = $pdo->prepare("UPDATE shops SET name=?, category=?, city=?, description=? WHERE owner_id=?");
        $s->execute([$name, $category, $city, $description, $user_id]);
    } else {
        $s = $pdo->prepare("INSERT INTO shops (owner_id, name, category, city, description) VALUES (?,?,?,?,?)");
        $s->execute([$user_id, $name, $category, $city, $description]);
        $shop = $pdo->prepare("SELECT * FROM shops WHERE owner_id = ?")->execute([$user_id]);
    }
    header('Location: dashboard.php');
    exit;
}
?> <h4 class="mb-4"><?php echo $shop ? 'Edit Shop' : 'Create Your Shop'; ?></h4>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <form method="POST">
                <div class="mb-3"> <label class="form-label">Shop Name</label> <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($shop['name'] ?? ''); ?>"> </div>
                <div class="mb-3"> <label class="form-label">Category</label> <select name="category" class="form-select">
                        <option value="cafe" <?php echo (($shop['category'] ?? '') === 'cafe') ? 'selected' : ''; ?>>Cafe</option>
                        <option value="gift_shop" <?php echo (($shop['category'] ?? '') === 'gift_shop') ? 'selected' : ''; ?>>Gift Shop</option>
                        <option value="bakery" <?php echo (($shop['category'] ?? '') === 'bakery') ? 'selected' : ''; ?>>Bakery</option>
                    </select> </div>
                <div class="mb-3"> <label class="form-label">City</label> <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($shop['city'] ?? ''); ?>"> </div>
                <div class="mb-3"> <label class="form-label">Description</label> <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($shop['description'] ?? ''); ?></textarea> 
            </div> 
            <button class="btn btn-dark w-100">
                 <?php echo $shop ? 'Save Changes' : 'Create Shop'; ?>
                 </button>
            </form>
        </div>
    </div>
</div> <?php require_once '../includes/footer.php'; ?>