<?php require_once '../config/db.php';
require_once '../includes/header.php';
if (!isset($_SESSION['sticker_order_id'])) {
    header('Location: index.php');
    exit;
}
$templates = ['birthday' => '🎂 Birthday', 'thankyou' => '🙏 Thank You', 'love' => '❤️ Love', 'celebration' => '🎉 Celebration',];
?>
<h2 class="mb-1">Design Your Sticker</h2>
<p class="text-muted mb-4"> This sticker will be printed and attached to your gift. </p>
<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4">
            <h6 class="mb-3">1. Pick a template</h6>
            <form action="save_sticker.php" method="POST" id="stickerForm">
                <div class="row g-2 mb-4">
                    <?php foreach ($templates as $key => $label): ?>
                        <div class="col-6 col-md-3">
                            <div class="template-option border rounded text-center p-2"
                                onclick="selectTemplate('<?php echo $key; ?>', this)"
                                style="cursor:pointer;">
                                <img src="/finalphpproject/assets/images/stickers/<?php echo $key; ?>.png" class="img-fluid rounded mb-1"
                                    style="height:70px;object-fit:cover;">
                                <div class="small">
                                    <?php echo $label; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="template" id="selectedTemplate" value="birthday" required>
                <h6 class="mb-2">2. Write your message</h6>
                <input type="text" name="custom_text" id="customText" class="form-control mb-4" maxlength="60" placeholder="Happy Birthday Sarah! 🎉" oninput="updatePreview()">
                <button type="submit" class="btn btn-dark w-100"> Save Sticker
                    &rarr;

                </button>
            </form> <a href="confirmation.php?order_id=<?php echo $_SESSION['sticker_order_id']; ?>" class="btn btn-link btn-sm w-100 mt-2 text-muted"> Skip sticker, go to confirmation </a>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4 text-center">
            <h6 class="mb-3">Live Preview</h6>
            <div id="stickerPreview" style=" width:180px; height:180px; margin:0 auto; border-radius:50%; border:3px dashed #ccc; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#fff8f0; position:relative; overflow:hidden;">
                <img id="previewImg" src="/finalphpproject/assets/images/stickers/birthday.png" style="width:80px;height:80px;object-fit:contain;">
                <p id="previewText" style="font-size:12px;font-weight:600;margin-top:8px; padding:0 12px;word-break:break-word;color:#333;"> Your message here </p>
            </div>
            <small class="text-muted mt-3 d-block"> This is how your sticker will look. </small>
        </div>
    </div>
</div>
<script>
    function selectTemplate(key, el) {
        document.querySelectorAll('.template-option').forEach(function(e) {
            e.style.border = '1px solid #dee2e6';
            e.style.background = '';
        });
        el.style.border = '2px solid #212529';
        el.style.background = '#f8f9fa';
        document.getElementById('selectedTemplate').value = key;
        document.getElementById('previewImg').src = '/finalphpproject/assets/images/stickers/' + key + '.png';
    }

    function updatePreview() {
        var text = document.getElementById('customText').value;
        document.getElementById('previewText').textContent = text || 'Your message here';
    }
</script>
<?php require_once '../includes/footer.php'; ?>