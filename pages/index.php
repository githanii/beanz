
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once '../config/db.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM shops WHERE is_active = 1");
$shops = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Browse Shops</h2>
<div class="row g-4"> <?php foreach ($shops as $shop): ?> <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-secondary mb-2">
                        <?php echo htmlspecialchars($shop['category']); ?>
                    </span>
                    <h5 class="card-title"> <?php echo htmlspecialchars($shop['name']); ?> </h5>
                    <p class="card-text text-muted"> <?php echo htmlspecialchars($shop['description']); ?> </p>
                    <p class="small text-muted"> <?php echo htmlspecialchars($shop['city']); ?> </p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="shops.php?id=<?php echo $shop['id']; ?>
                    "class="btn btn-dark btn-sm w-100">View Shop</a>
                </div>
            </div>
        </div> <?php endforeach; ?> </div> <?php require_once '../includes/footer.php'; ?>
    
</body>
</html>












