<?php
// Biohome V3 Theme Controller

if (!isset($pdo)) {
    echo '<div style="padding:40px;font-family:sans-serif;">Datenbankverbindung fehlt.</div>';
    return;
}

if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('setting_value')) {
    function setting_value(array $settings, string $key, string $fallback = ''): string {
        return isset($settings[$key]) && $settings[$key] !== '' ? (string) $settings[$key] : $fallback;
    }
}

if (!function_exists('text_excerpt')) {
    function text_excerpt(?string $text, int $limit = 120): string {
        $text = $text ?? '';
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = trim(strip_tags($text));
        if ($text === '') {
            return '';
        }
        if (function_exists('mb_strlen') && function_exists('mb_substr')) {
            if (mb_strlen($text) <= $limit) {
                return $text;
            }
            return rtrim(mb_substr($text, 0, $limit)) . '...';
        }
        if (strlen($text) <= $limit) {
            return $text;
        }
        return rtrim(substr($text, 0, $limit)) . '...';
    }
}

if (!function_exists('load_page_by_slug')) {
    function load_page_by_slug(PDO $pdo, string $slug): ?array {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
        $stmt->execute([$slug]);
        $page = $stmt->fetch();
        return $page ?: null;
    }
}

if (!function_exists('load_legacy_page_by_slug')) {
    function load_legacy_page_by_slug(PDO $pdo, string $slug): ?array {
        try {
            $stmt = $pdo->prepare("SELECT * FROM cms_pages WHERE slug = ?");
            $stmt->execute([$slug]);
            $page = $stmt->fetch();
            return $page ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }
}

if (!function_exists('category_icon')) {
    function category_icon(string $slug): string {
        $slug = strtolower($slug);
        if (strpos($slug, 'suess') !== false) {
            return 'ph-fish-simple';
        }
        if (strpos($slug, 'meer') !== false) {
            return 'ph-drop';
        }
        if (strpos($slug, 'teich') !== false) {
            return 'ph-waves';
        }
        if (strpos($slug, 'profi') !== false) {
            return 'ph-factory';
        }
        return 'ph-squares-four';
    }
}

$settings = [];
try {
    $settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $settings = [];
}

$site_name = setting_value($settings, 'site_name', 'Biohome Deutschland');

$menu_items = [];
try {
    $menu_items = $pdo->query("SELECT * FROM menu_items ORDER BY position ASC")->fetchAll();
} catch (PDOException $e) {
    $menu_items = [];
}

$footer_legal_links = [];
$legal_pages = [
    ['slug' => 'impressum', 'label' => 'Impressum'],
    ['slug' => 'agb', 'label' => 'AGB'],
    ['slug' => 'datenschutz', 'label' => 'Datenschutz'],
    ['slug' => 'dsgvo', 'label' => 'DSGVO'],
    ['slug' => 'cookie', 'label' => 'Cookie-Richtlinie'],
];
try {
    $rows = $pdo->query("SELECT slug, title FROM pages WHERE slug IN ('impressum','agb','datenschutz','dsgvo','cookie')")->fetchAll();
    $page_map = [];
    foreach ($rows as $row) {
        $slug = (string) ($row['slug'] ?? '');
        $title = trim((string) ($row['title'] ?? ''));
        if ($slug !== '') {
            $page_map[$slug] = $title;
        }
    }

    foreach ($legal_pages as $page) {
        $slug = $page['slug'];
        if (!isset($page_map[$slug])) {
            continue;
        }
        $label = $page_map[$slug] !== '' ? $page_map[$slug] : $page['label'];
        $footer_legal_links[] = [
            'label' => $label,
            'href' => '?page=' . $slug,
        ];
    }
} catch (PDOException $e) {
    $footer_legal_links = [];
}

$categories = [];
try {
    $categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

$filter_types = [];
try {
    $filter_types = $pdo->query("SELECT * FROM filter_types ORDER BY position ASC, name ASC")->fetchAll();
} catch (PDOException $e) {
    $filter_types = [];
}

$filter_brands = [];
try {
    $filter_brands = $pdo->query("SELECT * FROM filter_brands ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $filter_brands = [];
}

function find_category_by_slug(array $categories, string $slug): ?array {
    foreach ($categories as $category) {
        if (($category['slug'] ?? '') === $slug) {
            return $category;
        }
    }
    return null;
}

function find_filter_type_by_slug(array $types, string $slug): ?array {
    foreach ($types as $type) {
        if (($type['slug'] ?? '') === $slug) {
            return $type;
        }
    }
    return null;
}

function find_filter_brand_by_slug(array $brands, string $slug): ?array {
    foreach ($brands as $brand) {
        if (($brand['slug'] ?? '') === $slug) {
            return $brand;
        }
    }
    return null;
}

$current_page = isset($_GET['page']) ? trim($_GET['page']) : '';
$current_category_slug = isset($_GET['category']) ? trim($_GET['category']) : '';
$current_product_id = isset($_GET['product']) ? (int) $_GET['product'] : 0;
$current_filter_id = isset($_GET['filter']) ? (int) $_GET['filter'] : 0;
$current_filter_type_slug = isset($_GET['type']) ? trim($_GET['type']) : '';
$current_filter_brand_slug = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$is_haendler_page = false;
if ($current_page === 'kaufen') {
    $current_page = 'haendler';
}
if ($current_page === 'haendler') {
    $is_haendler_page = true;
}

$is_products_context = false;
$is_filters_context = false;
$page_title = '';
$view = __DIR__ . '/front-page.php';
$catalog_category = null;
$page = null;
$product = null;
$product_categories = [];
$filter = null;
$active_filter_type = $current_filter_type_slug !== '' ? find_filter_type_by_slug($filter_types, $current_filter_type_slug) : null;
$active_filter_brand = $current_filter_brand_slug !== '' ? find_filter_brand_by_slug($filter_brands, $current_filter_brand_slug) : null;

if ($current_filter_id > 0) {
    try {
        $stmt = $pdo->prepare(
            "SELECT f.*,
                    t.name AS type_name,
                    t.slug AS type_slug,
                    b.name AS brand_name,
                    b.slug AS brand_slug
             FROM filters f
             LEFT JOIN filter_types t ON f.type_id = t.id
             LEFT JOIN filter_brands b ON f.brand_id = b.id
             WHERE f.id = ?"
        );
        $stmt->execute([$current_filter_id]);
        $filter = $stmt->fetch();
    } catch (PDOException $e) {
        $filter = null;
    }

    if ($filter) {
        $is_filters_context = true;
        $page_title = $filter['title'] ?? '';
        $view = __DIR__ . '/filter.php';
    } else {
        $page_title = 'Filter nicht gefunden';
        $page = [
            'title' => $page_title,
            'content' => '<p>Der angeforderte Filter ist nicht verfuegbar.</p>',
        ];
        $view = __DIR__ . '/page.php';
    }
} elseif ($current_product_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$current_product_id]);
    $product = $stmt->fetch();

    if ($product) {
        $is_products_context = true;
        $page_title = $product['title'] ?? '';
        $view = __DIR__ . '/product.php';

        $stmt = $pdo->prepare("SELECT c.name FROM categories c JOIN product_categories pc ON c.id = pc.category_id WHERE pc.product_id = ? ORDER BY c.name ASC");
        $stmt->execute([$current_product_id]);
        $product_categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } else {
        $page_title = 'Produkt nicht gefunden';
        $page = [
            'title' => $page_title,
            'content' => '<p>Das angeforderte Produkt ist nicht verfügbar.</p>',
        ];
        $view = __DIR__ . '/page.php';
    }
} elseif ($current_page === 'filtertypen') {
    $is_filters_context = true;
    $page_title = $active_filter_type['name'] ?? 'Filtertypen';
    if ($active_filter_brand) {
        $page_title = $active_filter_brand['name'] . ' - ' . $page_title;
    }
    $view = __DIR__ . '/filter-catalog.php';
} elseif ($current_page === 'produkte' || $current_category_slug !== '') {
    $is_products_context = true;
    $page_title = 'Produkte';
    $view = __DIR__ . '/catalog.php';

    if ($current_category_slug !== '') {
        $catalog_category = find_category_by_slug($categories, $current_category_slug);
        if (!$catalog_category) {
            $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
            $stmt->execute([$current_category_slug]);
            $catalog_category = $stmt->fetch();
        }
    }
} elseif ($current_page !== '') {
    $catalog_category = find_category_by_slug($categories, $current_page);
    if ($catalog_category) {
        $is_products_context = true;
        $page_title = $catalog_category['name'] ?? 'Produkte';
        $view = __DIR__ . '/catalog.php';
    } else {
        if ($current_page === 'kontakt' && file_exists(__DIR__ . '/contact.php')) {
            $page_title = 'Kontakt';
            $view = __DIR__ . '/contact.php';
        } else {
            $page = load_page_by_slug($pdo, $current_page);

            if ($is_haendler_page) {
                $content_ok = $page && trim(strip_tags($page['content'] ?? '')) !== '';
                if (!$content_ok) {
                    $page = load_page_by_slug($pdo, 'kaufen');
                    if (!$page) {
                        $page = load_legacy_page_by_slug($pdo, 'kaufen');
                    }
                    if ($page) {
                        $page['title'] = 'Haendler finden';
                    }
                }
            }

            if ($page) {
                $page_title = $page['title'] ?? '';
                $view = __DIR__ . '/page.php';
            } else {
                $page_title = 'Seite nicht gefunden';
                $page = [
                    'title' => $page_title,
                    'content' => '<p>Die angeforderte Seite ist nicht vorhanden.</p>',
                ];
                $view = __DIR__ . '/page.php';
            }
        }
    }
}

if ($page_title === '') {
    $page_title = $site_name;
}

include __DIR__ . '/header.php';
include $view;
include __DIR__ . '/footer.php';
