<?php
$slides = $slides ?? [];
$categories = $categories ?? [];
$featured_products = $featured_products ?? [];
?>
<!-- Slider -->
<section class="hero-slider" id="homeSlider" data-slider>
    <?php if($slides): $i=0; foreach($slides as $s): $act=($i===0)?'is-active':''; ?>
    <div class="slide <?php echo $act; ?>" style="background-image: url('/<?php echo ltrim(htmlspecialchars($s['image_url']), '/'); ?>');" <?php echo $i === 0 ? 'loading="eager"' : ''; ?>>
        <div class="slide-content">
            <h1 class="slide-title"><?php echo htmlspecialchars($s['title']); ?></h1>
            <?php if($s['subtitle']): ?><p class="slide-text"><?php echo htmlspecialchars($s['subtitle']); ?></p><?php endif; ?>
            <?php if($s['btn_text']): ?><a href="<?php echo htmlspecialchars($s['btn_link']); ?>" class="btn"><?php echo htmlspecialchars($s['btn_text']); ?></a><?php endif; ?>
        </div>
    </div>
    <?php if($i === 0): ?>
    <script>
        var link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = '/<?php echo ltrim(htmlspecialchars($s['image_url']), '/'); ?>';
        document.head.appendChild(link);
    </script>
    <?php endif; ?>
    <?php $i++; endforeach; else: ?>
    <div class="slide is-active" style="background:#0f172a;"><div class="slide-content"><h1>Willkommen</h1><p>Bitte Slider im Admin anlegen.</p></div></div>
    <?php endif; ?>
    <div class="arrow prev" data-prev><i class="ph ph-caret-left"></i></div>
    <div class="arrow next" data-next><i class="ph ph-caret-right"></i></div>
</section>

<!-- Kategorien -->
<section class="container">
    <div style="text-align:center; margin-bottom:40px;">
        <h2>Für jeden Bereich das Optimum</h2>
        <p style="color:var(--gray);">Wählen Sie Ihren Anwendungsbereich</p>
    </div>
    <div class="category-grid">
        <?php foreach($categories as $cat): 
            $icon = 'ph-squares-four';
            if(strpos($cat['slug'],'suess')!==false) $icon='ph-fish-simple';
            if(strpos($cat['slug'],'meer')!==false) $icon='ph-drop';
            if(strpos($cat['slug'],'teich')!==false) $icon='ph-waves';
        ?>
        <a href="/produkte?category=<?php echo $cat['slug']; ?>" class="cat-card">
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
        <?php foreach($featured_products as $p): ?>
            <div class="cat-card" style="text-align:left; padding:0; overflow:hidden; display:flex; flex-direction:column; border:1px solid #e2e8f0;">
                <div style="height:220px; background:#f8fafc; display:flex; align-items:center; justify-content:center; position:relative; border-bottom:1px solid #e2e8f0;">
                    <?php if(!empty($p['image_url'])): ?>
                        <img src="/<?php echo ltrim(htmlspecialchars($p['image_url']), '/'); ?>" style="height:100%; width:100%; object-fit:cover;" loading="lazy">
                    <?php else: ?>
                        <i class="ph ph-cube" style="font-size:4rem; color:#cbd5e1;"></i>
                    <?php endif; ?>
                    <?php if(isset($p['is_featured']) && $p['is_featured']): ?>
                        <span style="position:absolute; top:10px; right:10px; background:#fbbf24; color:#78350f; font-size:0.7rem; font-weight:bold; padding:2px 8px; border-radius:10px;">TOP</span>
                    <?php endif; ?>
                </div>
                <div style="padding:20px; flex:1; display:flex; flex-direction:column;">
                    <h4 style="font-size:1.1rem; margin-bottom:10px; color:#0f172a;"><?php echo htmlspecialchars($p['title']); ?></h4>
                    <a href="/produkt/<?php echo $p['id']; ?>" class="btn-outline" style="border:1px solid #16a34a; border-radius:6px; text-align:center; padding:8px; display:block; margin-top:auto;">Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
