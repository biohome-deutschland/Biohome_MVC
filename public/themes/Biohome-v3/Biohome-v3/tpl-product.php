<?php $p = $data['product']; ?>
<div class="container" style="margin-top:40px; margin-bottom:80px;">
    <div style="font-size:0.9rem; color:var(--gray); margin-bottom:20px;">
        <a href="index.php">Home</a> / <a href="?page=produkte">Produkte</a> / <?php echo htmlspecialchars($p['title']); ?>
    </div>
    
    <div class="product-layout">
        <div class="product-gallery">
            <?php if($p['image_url']): ?>
                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" style="max-height:400px; width:auto;">
            <?php else: ?>
                <div style="padding:100px; color:#ccc;">Kein Bild</div>
            <?php endif; ?>
        </div>
        <div class="product-info">
            <?php if(isset($data['cats'])) foreach($data['cats'] as $c): ?>
                <span class="badge"><?php echo htmlspecialchars($c); ?></span>
            <?php endforeach; ?>
            
            <h1 style="margin-top:10px;"><?php echo htmlspecialchars($p['title']); ?></h1>
            <div style="margin:20px 0; line-height:1.6; color:#334155;">
                <?php echo nl2br(htmlspecialchars($p['description'])); ?>
            </div>
            
            <div style="background:#f8fafc; padding:20px; border-radius:8px; border:1px solid var(--border); margin-top:20px;">
                <strong>Verfügbarkeit:</strong><br>
                Dieses Produkt ist bei unseren Fachhändlern erhältlich.
            </div>
            <a href="?page=haendler" class="btn" style="margin-top:20px; width:100%; justify-content:center;">Händler finden</a>
        </div>
    </div>
</div>