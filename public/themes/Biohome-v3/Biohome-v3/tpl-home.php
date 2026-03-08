<?php
// Slider laden
$slides = $pdo->query("SELECT * FROM slides ORDER BY position ASC")->fetchAll();
?>
<!-- Slider -->
<section class="hero-slider" id="homeSlider">
    <?php if($slides): $i=0; foreach($slides as $s): $act=($i===0)?'active':''; ?>
    <div class="slide <?php echo $act; ?>" style="background-image: url('<?php echo htmlspecialchars($s['image_url']); ?>');">
        <div class="slide-content">
            <h1 class="slide-title"><?php echo htmlspecialchars($s['title']); ?></h1>
            <?php if($s['subtitle']): ?><p class="slide-text"><?php echo htmlspecialchars($s['subtitle']); ?></p><?php endif; ?>
            <?php if($s['btn_text']): ?><a href="<?php echo htmlspecialchars($s['btn_link']); ?>" class="btn"><?php echo htmlspecialchars($s['btn_text']); ?></a><?php endif; ?>
        </div>
    </div>
    <?php $i++; endforeach; else: ?>
    <div class="slide active" style="background:#0f172a;"><div class="slide-content"><h1>Willkommen</h1><p>Bitte Slider im Admin anlegen.</p></div></div>
    <?php endif; ?>
    <div class="arrow prev" onclick="moveSlide(-1)"><i class="ph ph-caret-left"></i></div>
    <div class="arrow next" onclick="moveSlide(1)"><i class="ph ph-caret-right"></i></div>
</section>

<!-- Kategorien -->
<section class="container">
    <div style="text-align:center; margin-bottom:40px;">
        <h2>Für jeden Bereich das Optimum</h2>
        <p style="color:var(--gray);">Wählen Sie Ihren Anwendungsbereich</p>
    </div>
    <div class="category-grid">
        <?php foreach($pdo->query("SELECT * FROM categories ORDER BY name ASC") as $cat): 
            $icon = 'ph-squares-four';
            if(strpos($cat['slug'],'suess')!==false) $icon='ph-fish-simple';
            if(strpos($cat['slug'],'meer')!==false) $icon='ph-drop';
            if(strpos($cat['slug'],'teich')!==false) $icon='ph-waves';
        ?>
        <a href="?page=<?php echo $cat['slug']; ?>" class="cat-card">
            <i class="ph <?php echo $icon; ?> cat-icon"></i>
            <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Highlights -->
<section class="container" style="margin:80px auto;">
    <h3 style="text-align:center; margin-bottom:40px;">Highlights</h3>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:30px;">
        <?php foreach($pdo->query("SELECT * FROM products WHERE is_featured=1 LIMIT 4") as $p): ?>
            <?php include 'tpl-card-product.php'; // Helper für die Karte ?>
        <?php endforeach; ?>
    </div>
</section>