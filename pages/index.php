<?php require_once '../config/db.php';
require_once '../config/session.php';
require_once '../includes/header.php';
$shops = $pdo->query("SELECT * FROM shops WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC); ?>
<section style="background: linear-gradient(135deg, #FFB4B4 0%, #FFEAA7 100%); padding: 60px 20px; border-radius: 20px; margin-bottom: 40px;">
    <div style="max-width: 600px;">
        <div style="font-size: 3.5rem; margin-bottom: 20px;">🎁</div>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #333; margin-bottom: 15px; line-height: 1.2;"> DISCOVER NEW TASTES </h1>
        <p style="font-size: 16px; color: #555; margin-bottom: 25px; line-height: 1.6;"> Send the perfect gift from our favorite local shops. Every order includes a custom sticker! </p>
        <a href="#shops" class="btn" style="background: #333; color: white; padding: 12px 30px; font-weight: 600; text-decoration: none; border-radius: 50px;"> EXPLORE NOW ↓ </a>
    </div>
</section>
<div style="display: flex; gap: 10px; justify-content: center; margin-bottom: 40px; flex-wrap: wrap;">
    <a href="#shops" class="btn btn-outline-dark">ALL</a>
    <a href="#" class="btn btn-outline-dark">CAFES</a>
    <a href="#" class="btn btn-outline-dark">GIFT SHOPS</a>
    <a href="#" class="btn btn-outline-dark">BAKERY</a>
</div>
<div id="shops">
    <h3 style="text-align: center; margin-bottom: 40px; font-size: 2rem; font-weight: 700;">Featured Shops</h3>
    <div class="row g-4">
        <?php foreach ($shops as $shop): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm overflow-hidden"
                    style="transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-10px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg,
                     #C4511A 0%, #FFB4B4 100%); 
                     height: 150px; display: flex; align-items: center; 
                     justify-content: center; font-size: 3rem;">
                        <?php $icons = ['cafe' => '☕', 'gift_shop' => '🎀', 'bakery' => '🧁'];
                        echo $icons[$shop['category']] ?? '🎁'; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            <?php echo htmlspecialchars($shop['name']); ?> </h5>
                        <p class="card-text text-muted small">
                            <?php echo htmlspecialchars($shop['description']); ?> </p>
                        <div style="display: flex; gap: 8px; margin-top: 12px;">
                            <span class="badge bg-light text-dark">
                                <?php echo ucfirst($shop['category']); ?>
                            </span>
                            <span class="badge bg-light text-dark">
                                <?php echo htmlspecialchars($shop['city']); ?> </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="shops.php?id=<?php echo $shop['id']; ?>" class="btn btn-dark w-100 fw-bold"> BROWSE PRODUCTS → </a>
                    </div>
                </div>
            </div> <?php endforeach; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>