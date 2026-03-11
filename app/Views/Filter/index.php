<?php
$filter_types = $filter_types ?? [];
$filter_brands = $available_brands ?? [];
$active_filter_type = $active_filter_type ?? null;
$active_filter_brand = $active_filter_brand ?? null;

$active_type_id = $active_filter_type['id'] ?? null;
$active_brand_id = $active_filter_brand['id'] ?? null;
$filters = $filters ?? [];

function text_excerpt($text, $length = 120) {
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr(strip_tags($text), 0, $length) . '...';
}

$type_title = $active_filter_type['name'] ?? 'Filtertypen';
$type_description = trim((string) ($active_filter_type['description'] ?? ''));
?>

<section class="page-hero">
    <div class="container">
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/" itemprop="item"><span itemprop="name">Startseite</span></a>
                    <meta itemprop="position" content="1">
                </li>
                <?php if ($active_filter_type): ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="/filtertypen" itemprop="item"><span itemprop="name">Filtertypen</span></a>
                    <meta itemprop="position" content="2">
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php echo htmlspecialchars($active_filter_type['name']); ?></span>
                    <meta itemprop="position" content="3">
                </li>
                <?php else: ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name">Filtertypen</span>
                    <meta itemprop="position" content="2">
                </li>
                <?php endif; ?>
            </ol>
        </nav>
        <p class="eyebrow">Filterkatalog</p>
        <h1 class="page-title"><?php echo htmlspecialchars($type_title); ?></h1>
        <?php if ($type_description !== ''): ?>
            <p class="page-subtitle"><?php echo htmlspecialchars($type_description); ?></p>
        <?php else: ?>
            <p class="page-subtitle">Finden Sie den passenden Filter und die optimale Biohome-Bestueckung.</p>
        <?php endif; ?>

        <div class="filter-chip-group">
            <span class="chip-label">Filterart</span>
            <div class="filter-chips">
                <a class="chip <?php echo $active_type_id ? '' : 'is-active'; ?>" href="/filtertypen">Alle</a>
                <?php foreach ($filter_types as $type): ?>
                    <a class="chip <?php echo ($active_filter_type && $active_filter_type['id'] == $type['id']) ? 'is-active' : ''; ?>" href="/filtertypen?type=<?php echo htmlspecialchars($type['slug']); ?>">
                        <?php echo htmlspecialchars($type['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($active_type_id && !empty($filter_brands)): ?>
            <div class="filter-chip-group">
                <span class="chip-label">Hersteller</span>
                <div class="filter-chips">
                    <a class="chip <?php echo $active_brand_id ? '' : 'is-active'; ?>" href="/filtertypen?type=<?php echo htmlspecialchars($active_filter_type['slug']); ?>">Alle</a>
                    <?php foreach ($filter_brands as $brand): ?>
                        <a class="chip <?php echo ($active_filter_brand && $active_filter_brand['id'] == $brand['id']) ? 'is-active' : ''; ?>" href="/filtertypen?type=<?php echo htmlspecialchars($active_filter_type['slug']); ?>&amp;brand=<?php echo htmlspecialchars($brand['slug']); ?>">
                            <?php echo htmlspecialchars($brand['name']); ?>
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
                    <article class="product-card" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px; height: 100%; display: flex; flex-direction: column;">
                        <div class="product-image">
                            <?php if (!empty($filter['image_url'])): ?>
                                <img src="/<?php echo ltrim(htmlspecialchars($filter['image_url']), '/'); ?>" alt="<?php echo htmlspecialchars($filter['title']); ?>" loading="lazy" style="border-radius: 12px 12px 0 0; object-fit: cover; aspect-ratio: 4/3; width: 100%;">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($filter['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content" style="flex: 1; display: flex; flex-direction: column;">
                            <div class="filter-tags">
                                <?php if (!empty($filter['type_name'])): ?>
                                    <span class="badge"><?php echo htmlspecialchars($filter['type_name']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($filter['brand_name'])): ?>
                                    <span class="badge"><?php echo htmlspecialchars($filter['brand_name']); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="product-title"><?php echo htmlspecialchars($filter['title']); ?></h3>
                            <p class="product-desc" style="flex: 1;"><?php echo htmlspecialchars(text_excerpt($filter['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="/filter/<?php echo (int) $filter['id']; ?>" style="border-radius: 9999px; width: 100%; text-align: center; margin-top: auto;">Details ansehen</a>
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
