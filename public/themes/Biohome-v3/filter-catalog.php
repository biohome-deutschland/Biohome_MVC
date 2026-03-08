<?php
$filter_types = $filter_types ?? [];
$filter_brands = $filter_brands ?? [];
$active_filter_type = $active_filter_type ?? null;
$active_filter_brand = $active_filter_brand ?? null;

$active_type_id = $active_filter_type['id'] ?? null;
$active_brand_id = $active_filter_brand['id'] ?? null;

$filters = [];
$available_brands = $filter_brands;

try {
    $sql = "SELECT f.*, t.name AS type_name, b.name AS brand_name
            FROM filters f
            LEFT JOIN filter_types t ON f.type_id = t.id
            LEFT JOIN filter_brands b ON f.brand_id = b.id";
    $where = [];
    $params = [];

    if ($active_type_id) {
        $where[] = "f.type_id = ?";
        $params[] = $active_type_id;
    }
    if ($active_brand_id) {
        $where[] = "f.brand_id = ?";
        $params[] = $active_brand_id;
    }
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY f.is_featured DESC, f.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $filters = $stmt->fetchAll();

    if ($active_type_id) {
        $stmt = $pdo->prepare(
            "SELECT DISTINCT b.*
             FROM filter_brands b
             JOIN filters f ON f.brand_id = b.id
             WHERE f.type_id = ?
             ORDER BY b.name ASC"
        );
        $stmt->execute([$active_type_id]);
        $available_brands = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $filters = [];
}

$type_title = $active_filter_type['name'] ?? 'Filtertypen';
$type_description = trim((string) ($active_filter_type['description'] ?? ''));
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Filterkatalog</p>
        <h1 class="page-title"><?php echo e($type_title); ?></h1>
        <?php if ($type_description !== ''): ?>
            <p class="page-subtitle"><?php echo e($type_description); ?></p>
        <?php else: ?>
            <p class="page-subtitle">Finden Sie den passenden Filter und die optimale Biohome-Bestueckung.</p>
        <?php endif; ?>

        <div class="filter-chip-group">
            <span class="chip-label">Filterart</span>
            <div class="filter-chips">
                <a class="chip <?php echo $active_type_id ? '' : 'is-active'; ?>" href="?page=filtertypen">Alle</a>
                <?php foreach ($filter_types as $type): ?>
                    <a class="chip <?php echo ($active_filter_type && $active_filter_type['id'] == $type['id']) ? 'is-active' : ''; ?>" href="?page=filtertypen&amp;type=<?php echo e($type['slug']); ?>">
                        <?php echo e($type['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($active_type_id && !empty($available_brands)): ?>
            <div class="filter-chip-group">
                <span class="chip-label">Hersteller</span>
                <div class="filter-chips">
                    <a class="chip <?php echo $active_brand_id ? '' : 'is-active'; ?>" href="?page=filtertypen&amp;type=<?php echo e($active_filter_type['slug']); ?>">Alle</a>
                    <?php foreach ($available_brands as $brand): ?>
                        <a class="chip <?php echo ($active_filter_brand && $active_filter_brand['id'] == $brand['id']) ? 'is-active' : ''; ?>" href="?page=filtertypen&amp;type=<?php echo e($active_filter_type['slug']); ?>&amp;brand=<?php echo e($brand['slug']); ?>">
                            <?php echo e($brand['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($filters)): ?>
            <div class="product-grid">
                <?php foreach ($filters as $filter): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if (!empty($filter['image_url'])): ?>
                                <img src="<?php echo e($filter['image_url']); ?>" alt="<?php echo e($filter['title']); ?>">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($filter['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content">
                            <div class="filter-tags">
                                <?php if (!empty($filter['type_name'])): ?>
                                    <span class="badge"><?php echo e($filter['type_name']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($filter['brand_name'])): ?>
                                    <span class="badge"><?php echo e($filter['brand_name']); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="product-title"><?php echo e($filter['title']); ?></h3>
                            <p class="product-desc"><?php echo e(text_excerpt($filter['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="?filter=<?php echo (int) $filter['id']; ?>">Details ansehen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-magnifying-glass"></i>
                <p class="muted">Aktuell sind keine Filter in dieser Auswahl vorhanden.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
