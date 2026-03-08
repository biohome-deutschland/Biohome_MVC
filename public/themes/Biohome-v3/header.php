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
            <a href="/" class="brand">Bio<span>home</span></a>

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
                            // Clean URL generation from legacy DB values
                            if ($href === '?page=produkte' || $href === 'produkte') $href = '/produkte';
                            if ($href === '?page=filtertypen' || $href === 'filtertypen') $href = '/filtertypen';
                            if ($href === '?page=kontakt' || $href === 'kontakt') $href = '/kontakt';
                            if ($href === '?page=haendler' || $href === 'haendler') $href = '/haendler';
                            if ($href === 'index.php') $href = '/';
                            if (strpos($href, '?page=') === 0) {
                                $href = '/' . substr($href, 6);
                            }
                            
                            if ($label_lower === 'kaufen' || strpos($href_lower, 'kaufen') !== false) {
                                continue;
                            }
                            $is_products_menu = ($label_lower === 'produkte' || strpos($href_lower, 'produkte') !== false);
                            $is_filters_menu = ($label_lower === 'filtertypen' || strpos($href_lower, 'filtertypen') !== false);

                            $active_class = '';
                            if ($is_products_menu && $is_products_context) {
                                $active_class = 'is-active';
                            } elseif ($is_filters_menu && $is_filters_context) {
                                $active_class = 'is-active';
                            } else {
                                $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                                if ($href === $current_path) {
                                    $active_class = 'is-active';
                                } elseif ($href === '/' && $current_path === '/') {
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
                                        <li><a class="dropdown-title" href="/produkte">Alle Produkte</a></li>
                                        <?php foreach ($categories as $category): ?>
                                            <li>
                                                <a href="/produkte?category=<?php echo htmlspecialchars($category['slug']); ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php elseif ($is_filters_menu): ?>
                                    <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-filters">
                                        <i class="ph ph-caret-down"></i>
                                    </button>
                                    <ul class="dropdown" id="submenu-filters">
                                        <li><a class="dropdown-title" href="/filtertypen">Alle Filtertypen</a></li>
                                        <?php foreach ($filter_types as $type): ?>
                                            <li>
                                                <a href="/filtertypen?type=<?php echo htmlspecialchars($type['slug']); ?>">
                                                    <?php echo htmlspecialchars($type['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?php echo $current_page === '' ? 'is-active' : ''; ?>" href="/">Startseite</a></li>
                        <li class="nav-item has-dropdown">
                            <a class="nav-link <?php echo $is_products_context ? 'is-active' : ''; ?>" href="/produkte">Produkte</a>
                            <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-products">
                                <i class="ph ph-caret-down"></i>
                            </button>
                            <ul class="dropdown" id="submenu-products">
                                <li><a class="dropdown-title" href="/produkte">Alle Produkte</a></li>
                                <?php foreach ($categories as $category): ?>
                                    <li><a href="/produkte?category=<?php echo htmlspecialchars($category['slug']); ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item has-dropdown">
                            <a class="nav-link <?php echo $is_filters_context ? 'is-active' : ''; ?>" href="/filtertypen">Filtertypen</a>
                            <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-filters">
                                <i class="ph ph-caret-down"></i>
                            </button>
                            <ul class="dropdown" id="submenu-filters">
                                <li><a class="dropdown-title" href="/filtertypen">Alle Filtertypen</a></li>
                                <?php foreach ($filter_types as $type): ?>
                                    <li><a href="/filtertypen?type=<?php echo htmlspecialchars($type['slug']); ?>"><?php echo htmlspecialchars($type['name']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="/kontakt">Kontakt</a></li>
                    <?php endif; ?>
                    <li class="nav-item nav-cta">
                        <a class="btn btn-primary btn-block" href="/haendler">H&auml;ndler finden</a>
                    </li>
                </ul>
            </nav>

            <a href="/haendler" class="btn btn-primary header-cta">H&auml;ndler finden</a>
        </div>
    </header>
    <main class="site-main" id="content">
