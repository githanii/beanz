<?php require_once '../config/db.php';
require_once '../includes/header.php'; 
 $shop_id = (int) ($_GET['id'] ?? 0);
  if ($shop_id === 0) 
    { header('Location: index.php');
   exit; }
  $stmt = $pdo->prepare("SELECT * FROM shops WHERE id = ? AND is_active = 1"); 
  $stmt->execute([$shop_id]); 
  $shop = $stmt->fetch(PDO::FETCH_ASSOC); 
 if (!$shop) 
    { header('Location: index.php'); 
 exit; }
  $stmt2 = $pdo->prepare("SELECT * FROM products WHERE shop_id = ?");
   $stmt2->execute([$shop_id]); $products = $stmt2->fetchAll(PDO::FETCH_ASSOC); 
?> 
<div class="mb-4"> <a href="index.php" class="text-muted text-decoration-none">&larr; Back to shops</a>
    <h2 class="mt-2"><?php echo htmlspecialchars($shop['name']); ?></h2>
    <p class="text-muted"><?php echo htmlspecialchars($shop['description']); ?></p>
</div> 
<h5 class="mb-3">Products</h5>
<div class="row g-4"> <?php foreach ($products as $product): ?>
     <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title"> <?php echo htmlspecialchars($product['name']); ?> </h6>
                    <p class="card-text text-muted small"> <?php echo htmlspecialchars($product['description']); ?> </p>
                    <p class="fw-bold"> $<?php echo number_format($product['price'], 2); ?> </p>
                </div>
                <div class="card-footer bg-white border-0"> 
                    <form action="addtocart.php" method="POST">
                         <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>"> 
                         <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>"> 
                         <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                          <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>"> 
                          <button type="submit" class="btn btn-dark btn-sm w-100">Add to Cart</button>
                         </form>
                </div>
            </div>
        </div> 
        <?php endforeach; ?> </div> <?php require_once '../includes/footer.php'; ?>