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
    <section class="product-page">
        <div class="container">
            <div class="breadcrumb">
                <a href="/">Startseite</a> / <a href="/produkte">Produkte</a> / <?php echo htmlspecialchars($product['title']); ?>
            </div>
            <div class="product-layout">
                <div class="product-media">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="/<?php echo ltrim(htmlspecialchars($product['image_url']), '/'); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" loading="eager">
                    <?php else: ?>
                        <div class="muted">Kein Bild verfuegbar</div>
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
                        if ($description !== '' && $description === strip_tags($description)) {
                            echo nl2br(htmlspecialchars($description));
                        } else {
                            echo $description; // WYSIWYG Content
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
