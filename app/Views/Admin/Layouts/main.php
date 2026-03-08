<?php
$admin_page = $admin_page ?? '';
$sidebar_items = [
    ['file' => 'admin', 'label' => 'Dashboard'],
    ['file' => 'admin/pages', 'label' => 'Seiten'],
    ['file' => 'admin/menus', 'label' => 'Navigation'],
    ['file' => 'admin/slider', 'label' => 'Slider'],
    ['file' => 'admin/media', 'label' => 'Medien'],
    ['file' => 'admin/products', 'label' => 'Produkte'],
    ['file' => 'admin/categories', 'label' => 'Kategorien'],
    ['file' => 'admin/filters', 'label' => 'Filter'],
    ['file' => 'admin/filter-calculator', 'label' => 'Filter-Kalkulator'],
    ['file' => 'admin/filter-types', 'label' => 'Filterarten'],
    ['file' => 'admin/filter-brands', 'label' => 'Filter-Hersteller'],
    ['file' => 'admin/settings', 'label' => 'Einstellungen'],
    ['file' => 'admin/migration', 'label' => 'Migration'],
    ['file' => 'admin/theme-import', 'label' => 'Theme Import'],
    ['file' => 'admin/export', 'label' => 'Export (SQL)'],
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard') ?> | Biohome</title>
    <link rel="stylesheet" href="/admin.css">
</head>
<body>

    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <div class="brand">Bio<span>home</span></div>
        <ul class="nav">
            <?php foreach ($sidebar_items as $nav_item): ?>
                <?php $is_active = $admin_page === $nav_item['file']; ?>
                <li>
                    <a href="/<?= htmlspecialchars($nav_item['file'], ENT_QUOTES, 'UTF-8'); ?>" class="<?= $is_active ? 'active' : ''; ?>">
                        <?= htmlspecialchars($nav_item['label'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="nav-footer">
            <a href="/admin/logout" style="color:var(--danger);">&larr; Abmelden</a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main">
        <?php if (!empty($content_view)) { include __DIR__ . '/../../' . $content_view; } ?>
    </main>

</body>
</html>
