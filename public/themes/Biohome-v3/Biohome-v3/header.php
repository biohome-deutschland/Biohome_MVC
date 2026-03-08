<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}
$site_name = $site_name ?? 'Biohome';
$page_title = $page_title ?? '';
$full_title = $site_name;
if ($page_title && $page_title !== $site_name) {
    $full_title = $page_title . ' | ' . $site_name;
}
$menu_items = $menu_items ?? [];
$categories = $categories ?? [];
$filter_types = $filter_types ?? [];
$current_page = $current_page ?? '';
$is_products_context = $is_products_context ?? false;
$is_filters_context = $is_filters_context ?? false;

$css_version = file_exists(__DIR__ . '/style.css') ? (string) filemtime(__DIR__ . '/style.css') : (string) time();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($full_title); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="<?php echo THEME_URL; ?>style.css?v=<?php echo $css_version; ?>">
</head>
<body>
<a class="skip-link" href="#content">Zum Inhalt springen</a>
<div class="site">
    <header class="site-header">
        <div class="container header-inner">
            <a href="index.php" class="brand">Bio<span>home</span></a>

            <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="siteNav">
                <i class="ph ph-list"></i>
            </button>

            <nav class="main-nav" id="siteNav" data-nav>
                <ul class="nav-list">
                    <?php if (!empty($menu_items)): ?>
                        <?php foreach ($menu_items as $item): ?>
                            <?php
                            $label = $item['label'] ?? '';
                            $href = $item['link'] ?? '#';
                            $label_lower = strtolower(trim($label));
                            $href_lower = strtolower($href);
                            if ($label_lower === 'kaufen' || strpos($href_lower, 'kaufen') !== false) {
                                continue;
                            }
                            $is_products_menu = ($label_lower === 'produkte' || strpos($href_lower, 'produkte') !== false);
                            $is_filters_menu = ($label_lower === 'filtertypen' || strpos($href_lower, 'filtertypen') !== false);
                            if ($is_products_menu) {
                                $href = '?page=produkte';
                            }
                            if ($is_filters_menu) {
                                $href = '?page=filtertypen';
                            }

                            $active_class = '';
                            if ($is_products_menu && $is_products_context) {
                                $active_class = 'is-active';
                            } elseif ($is_filters_menu && $is_filters_context) {
                                $active_class = 'is-active';
                            } else {
                                $parts = parse_url($href);
                                $params = [];
                                if (!empty($parts['query'])) {
                                    parse_str($parts['query'], $params);
                                }
                                if (isset($params['page']) && $params['page'] === $current_page) {
                                    $active_class = 'is-active';
                                } elseif (($href === 'index.php' || $href === './' || $href === '/') && $current_page === '') {
                                    $active_class = 'is-active';
                                }
                            }
                            ?>
                            <li class="nav-item <?php echo ($is_products_menu || $is_filters_menu) ? 'has-dropdown' : ''; ?>">
                                <a class="nav-link <?php echo $active_class; ?>" href="<?php echo e($href); ?>">
                                    <?php echo e($label); ?>
                                </a>
                                <?php if ($is_products_menu): ?>
                                    <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-products">
                                        <i class="ph ph-caret-down"></i>
                                    </button>
                                    <ul class="dropdown" id="submenu-products">
                                        <li><a class="dropdown-title" href="?page=produkte">Alle Produkte</a></li>
                                        <?php foreach ($categories as $category): ?>
                                            <li>
                                                <a href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>">
                                                    <?php echo e($category['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php elseif ($is_filters_menu): ?>
                                    <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-filters">
                                        <i class="ph ph-caret-down"></i>
                                    </button>
                                    <ul class="dropdown" id="submenu-filters">
                                        <li><a class="dropdown-title" href="?page=filtertypen">Alle Filtertypen</a></li>
                                        <?php foreach ($filter_types as $type): ?>
                                            <li>
                                                <a href="?page=filtertypen&amp;type=<?php echo e($type['slug']); ?>">
                                                    <?php echo e($type['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?php echo $current_page === '' ? 'is-active' : ''; ?>" href="index.php">Startseite</a></li>
                        <li class="nav-item has-dropdown">
                            <a class="nav-link <?php echo $is_products_context ? 'is-active' : ''; ?>" href="?page=produkte">Produkte</a>
                            <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-products">
                                <i class="ph ph-caret-down"></i>
                            </button>
                            <ul class="dropdown" id="submenu-products">
                                <li><a class="dropdown-title" href="?page=produkte">Alle Produkte</a></li>
                                <?php foreach ($categories as $category): ?>
                                    <li><a href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>"><?php echo e($category['name']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item has-dropdown">
                            <a class="nav-link <?php echo $is_filters_context ? 'is-active' : ''; ?>" href="?page=filtertypen">Filtertypen</a>
                            <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-filters">
                                <i class="ph ph-caret-down"></i>
                            </button>
                            <ul class="dropdown" id="submenu-filters">
                                <li><a class="dropdown-title" href="?page=filtertypen">Alle Filtertypen</a></li>
                                <?php foreach ($filter_types as $type): ?>
                                    <li><a href="?page=filtertypen&amp;type=<?php echo e($type['slug']); ?>"><?php echo e($type['name']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="?page=kontakt">Kontakt</a></li>
                    <?php endif; ?>
                    <li class="nav-item nav-cta">
                        <a class="btn btn-primary btn-block" href="?page=haendler">H&auml;ndler finden</a>
                    </li>
                </ul>
            </nav>

            <a href="?page=haendler" class="btn btn-primary header-cta">H&auml;ndler finden</a>
        </div>
    </header>
    <main class="site-main" id="content">
