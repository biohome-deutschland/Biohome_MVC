<?php
$product = $product ?? null;
$product_categories = $product_categories ?? [];
$settings = $settings ?? [];

$contact_email = '';
if (array_key_exists('company_email', $settings)) {
    $contact_email = (string) $settings['company_email'];
} else {
    $contact_email = $settings['admin_email'] ?? '';
    if ($contact_email === '' && defined('ADMIN_USERNAME')) {
        $contact_email = ADMIN_USERNAME;
    }
}
$contact_phone = array_key_exists('company_phone', $settings) ? (string) $settings['company_phone'] : '';
?>

<?php if ($product): ?>
    <script type="application/ld+json">
    <?php
    $schema_desc = trim(strip_tags((string)($product['description'] ?? '')));
    if (mb_strlen($schema_desc) > 500) {
        $schema_desc = mb_substr($schema_desc, 0, 497) . '...';
    }
    $schema_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $schema_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $schema_image = !empty($product['image_url']) ? $schema_scheme . '://' . $schema_host . '/' . ltrim($product['image_url'], '/') : '';

    $schema_data = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product['title'] ?? '',
        'description' => $schema_desc,
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Biohome'
        ],
        'offers' => [
            '@type' => 'Offer',
            'availability' => 'https://schema.org/InStock',
            'priceCurrency' => 'EUR',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'Biohome Deutschland'
            ]
        ]
    ];
    if ($schema_image !== '') {
        $schema_data['image'] = $schema_image;
    }
    echo json_encode($schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    ?>
    </script>
    <section class="product-page">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/" itemprop="item"><span itemprop="name">Startseite</span></a>
                        <meta itemprop="position" content="1">
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="/produkte" itemprop="item"><span itemprop="name">Produkte</span></a>
                        <meta itemprop="position" content="2">
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name"><?php echo htmlspecialchars($product['title']); ?></span>
                        <meta itemprop="position" content="3">
                    </li>
                </ol>
            </nav>
            <div class="product-layout" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 3rem; align-items: start;">
                <div class="product-media">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="/<?php echo ltrim(htmlspecialchars($product['image_url']), '/'); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" loading="eager" style="border-radius: 12px; width: 100%; object-fit: cover; aspect-ratio: 1/1;">
                    <?php else: ?>
                        <div class="muted" style="border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; aspect-ratio: 1/1;">Kein Bild verfuegbar</div>
                    <?php endif; ?>
                </div>
                <div class="product-details">
                    <div class="product-meta">
                        <?php foreach ($product_categories as $cat): ?>
                            <span class="badge"><?php echo htmlspecialchars($cat['name'] ?? $cat); ?></span>
                    <?php endforeach; ?>
                    <?php if (!empty($product['is_featured'])): ?>
                        <span class="badge badge--highlight">Highlight</span>
                    <?php endif; ?>
                    </div>
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <div class="rich-text">
                        <?php
                        $description = (string) ($product['description'] ?? '');
                        
                        // Parse list items for Synergy Boxes
                        if (strpos($description, '<ul>') !== false && strpos($description, '<li>') !== false) {
                            $description = str_replace('<ul>', '<ul class="synergy-list" style="list-style: none; padding: 0; display: grid; gap: 1rem; margin-top: 1.5rem;">', $description);
                            $description = str_replace('<li>', '<li class="synergy-box" style="background-color: #f0fdf4; border-left: 4px solid var(--brand, #16a34a); padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; color: #1f2937;">', $description);
                        }

                        if ($description !== '' && $description === strip_tags($description)) {
                            echo nl2br(htmlspecialchars($description));
                        } else {
                            echo $description; // Original HTML output
                        }
                        ?>
                    </div>
                    <?php if ($contact_email !== '' || $contact_phone !== ''): ?>
                        <div class="info-card">
                            Fragen zum Produkt? Schreiben Sie uns an
                            <?php if ($contact_email !== ''): ?>
                                <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>"><?php echo htmlspecialchars($contact_email); ?></a>
                            <?php else: ?>
                                unser Team
                            <?php endif; ?>
                            <?php if ($contact_phone !== ''): ?>
                                oder rufen Sie an unter <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9\\+]/', '', $contact_phone)); ?>"><?php echo htmlspecialchars($contact_phone); ?></a>
                            <?php endif; ?>.
                        </div>
                    <?php endif; ?>
                    <a class="btn btn-primary btn-block" href="/haendler">Haendler finden</a>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="section">
        <div class="container">
            <div class="empty-state">
                <i class="ph ph-warning-circle"></i>
                <p class="muted">Produkt nicht gefunden.</p>
            </div>
        </div>
    </section>
<?php endif; ?>
