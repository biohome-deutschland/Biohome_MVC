<?php
$active_category = $catalog_category ?? null;
$active_slug = $active_category['slug'] ?? '';
$active_name = $active_category['name'] ?? 'Alle Produkte';

$products = [];
try {
    if ($active_category) {
        $stmt = $pdo->prepare(
            "SELECT p.* FROM products p
             JOIN product_categories pc ON p.id = pc.product_id
             WHERE pc.category_id = ?
             ORDER BY p.is_featured DESC, p.id DESC"
        );
        $stmt->execute([(int) $active_category['id']]);
        $products = $stmt->fetchAll();
    } else {
        $products = $pdo->query("SELECT * FROM products ORDER BY is_featured DESC, id DESC")->fetchAll();
    }
} catch (PDOException $e) {
    $products = [];
}
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Produktkatalog</p>
        <h1 class="page-title"><?php echo e($active_name); ?></h1>
        <p class="page-subtitle">Entdecken Sie unsere Biohome Filtermedien und finden Sie das passende Produkt f&uuml;r Ihren Einsatz.</p>
        <div class="filter-chips">
            <a class="chip <?php echo $active_slug === '' ? 'is-active' : ''; ?>" href="?page=produkte">Alle</a>
            <?php foreach ($categories as $category): ?>
                <a class="chip <?php echo $active_slug === $category['slug'] ? 'is-active' : ''; ?>" href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>">
                    <?php echo e($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
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
                <i class="ph ph-magnifying-glass"></i>
                <p class="muted">In dieser Kategorie sind aktuell keine Produkte vorhanden.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
