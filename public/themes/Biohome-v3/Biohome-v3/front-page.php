<?php
$slides = [];
try {
    $slides = $pdo->query("SELECT * FROM slides ORDER BY position ASC")->fetchAll();
} catch (PDOException $e) {
    $slides = [];
}

$featured_products = [];
try {
    $featured_products = $pdo->query("SELECT * FROM products WHERE is_featured = 1 ORDER BY id DESC LIMIT 6")->fetchAll();
    if (empty($featured_products)) {
        $featured_products = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 6")->fetchAll();
    }
} catch (PDOException $e) {
    $featured_products = [];
}

$home_page = null;
$home_content = '';
try {
    $stmt = $pdo->prepare("SELECT title, content FROM pages WHERE slug = ?");
    $stmt->execute(['home']);
    $home_page = $stmt->fetch();
    $home_content = trim((string) ($home_page['content'] ?? ''));
} catch (PDOException $e) {
    $home_page = null;
    $home_content = '';
}

$fallback_images = [
    'assets/images/Banner/1-biohome-maxi-ultimate-2-800x800-2x.jpg',
    'assets/images/Banner/6-biohome-closeup-1-800x800-2x.jpg',
    'assets/images/Banner/3-biohome-bioballs-800x800-2x.jpg',
    'assets/images/Banner/4-biohome-ultimate-marine-4-800x800-2x.jpg',
];

function resolve_slide_image(string $image_url, int $index, array $fallback_images): string {
    $image_url = trim($image_url);
    if ($image_url !== '' && preg_match('/^https?:\\/\\//i', $image_url)) {
        return $image_url;
    }

    $relative = ltrim($image_url, '/');
    if ($relative !== '') {
        $root_path = dirname(__DIR__, 2);
        $file_path = $root_path . '/' . $relative;
        if (file_exists($file_path)) {
            return $relative;
        }
    }

    if (!empty($fallback_images)) {
        return $fallback_images[$index % count($fallback_images)];
    }
    return $image_url;
}
?>

<section class="hero">
    <div class="container">
        <div class="hero-slider" data-slider>
            <?php if (!empty($slides)): ?>
                <?php foreach ($slides as $index => $slide): ?>
                    <?php $slide_image = resolve_slide_image((string) ($slide['image_url'] ?? ''), $index, $fallback_images); ?>
                    <div class="slide <?php echo $index === 0 ? 'is-active' : ''; ?>" style="background-image: url('<?php echo e($slide_image); ?>');">
                        <div class="slide-content">
                            <p class="eyebrow">Biohome</p>
                            <h1 class="slide-title"><?php echo e($slide['title']); ?></h1>
                            <?php if (!empty($slide['subtitle'])): ?>
                                <p class="slide-text"><?php echo e($slide['subtitle']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($slide['btn_text'])): ?>
                                <a class="btn btn-ghost" href="<?php echo e($slide['btn_link']); ?>"><?php echo e($slide['btn_text']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $fallback_image = $fallback_images[0] ?? ''; ?>
                <div class="slide slide-fallback is-active" <?php echo $fallback_image !== '' ? 'style="background-image: url(\'' . e($fallback_image) . '\');"' : ''; ?>>
                    <div class="slide-content">
                        <p class="eyebrow">Biohome</p>
                        <h1 class="slide-title">Filtermedien, die Wasser sichtbar besser machen.</h1>
                        <p class="slide-text">Bitte pflegen Sie die Slider-Inhalte im Admin-Bereich.</p>
                        <a class="btn btn-ghost" href="?page=produkte">Zum Katalog</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($slides) > 1): ?>
                <div class="slider-controls">
                    <button class="slider-btn" type="button" data-prev aria-label="Vorherige Folie">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button class="slider-btn" type="button" data-next aria-label="Nächste Folie">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>
                <div class="slider-dots">
                    <?php foreach ($slides as $index => $slide): ?>
                        <button class="slider-dot <?php echo $index === 0 ? 'is-active' : ''; ?>" type="button" data-slide="<?php echo (int) $index; ?>" aria-label="Folie <?php echo (int) ($index + 1); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($home_content !== ''): ?>
<section class="section">
    <div class="container">
        <div class="rich-text">
            <?php echo $home_content; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Anwendungen</p>
                <h2 class="section-title">Filtermedien f&uuml;r jede Umgebung</h2>
                <p class="section-subtitle">W&auml;hlen Sie die passende Kategorie f&uuml;r S&uuml;&szlig;wasser, Meerwasser oder Profi-Anwendungen.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="?page=produkte">Zum Katalog</a>
            </div>
        </div>
        <?php if (!empty($categories)): ?>
            <div class="category-grid">
                <?php foreach ($categories as $category): ?>
                    <a class="category-card" href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>">
                        <div class="category-icon"><i class="ph <?php echo e(category_icon($category['slug'])); ?>"></i></div>
                        <h3><?php echo e($category['name']); ?></h3>
                        <span class="muted">Produkte ansehen</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-squares-four"></i>
                <p class="muted">Noch keine Kategorien angelegt.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Highlights</p>
                <h2 class="section-title">Ausgew&auml;hlte Biohome Produkte</h2>
                <p class="section-subtitle">Unsere beliebtesten Filtermedien, sofort verf&uuml;gbar im Produktkatalog.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="?page=produkte">Alle Produkte</a>
            </div>
        </div>
        <?php if (!empty($featured_products)): ?>
            <div class="product-grid">
                <?php foreach ($featured_products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo e($product['image_url']); ?>" alt="<?php echo e($product['title']); ?>">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($product['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content">
                            <h3 class="product-title"><?php echo e($product['title']); ?></h3>
                            <p class="product-desc"><?php echo e(text_excerpt($product['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="?product=<?php echo (int) $product['id']; ?>">Details ansehen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-cube"></i>
                <p class="muted">Aktuell sind keine Produkte hinterlegt.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
