<?php
// Global data that was originally provided by cms.php
$db = \Core\Model::getDB();
$site_name = $page['meta_title'] ?? $page['title'] ?? 'Biohome';
$page_title = $page['title'] ?? '';
$full_title = $site_name;
if ($page_title && $page_title !== $site_name) {
    $full_title = $page_title . ' | ' . $site_name;
}

// Fetch menus
$menu_items = $db->query("SELECT * FROM menu_items ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
$categories = $db->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$filter_types = $db->query("SELECT * FROM filter_types ORDER BY position ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch settings
$settingsRows = $db->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_ASSOC);
$settings = [];
foreach ($settingsRows as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$current_page = $_GET['page'] ?? '';
$is_products_context = strpos($_SERVER['REQUEST_URI'], '/produkte') !== false || strpos($_SERVER['REQUEST_URI'], '/produkt/') !== false;
$is_filters_context = strpos($_SERVER['REQUEST_URI'], '/filtertypen') !== false || strpos($_SERVER['REQUEST_URI'], '/filter/') !== false || strpos($_SERVER['REQUEST_URI'], '/filter-calculator') !== false;

function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

$css_version = file_exists(__DIR__ . '/../../../public/themes/Biohome-v3/style.css') ? (string) filemtime(__DIR__ . '/../../../public/themes/Biohome-v3/style.css') : (string) time();
$THEME_URL = '/themes/Biohome-v3/';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($full_title); ?></title>

    <?php
    // --- Canonical URL (ohne Query-String) ---
    $canonical_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $canonical_host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $canonical_path   = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $canonical_url    = $canonical_scheme . '://' . $canonical_host . $canonical_path;

    // --- Robots ---
    $is_admin_page = strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') !== false;
    $robots_content = $is_admin_page ? 'noindex, nofollow' : 'index, follow';

    // --- Meta-Description mit Fallback ---
    $meta_desc = trim($page['meta_description'] ?? '');
    if ($meta_desc === '' && !empty($page['content'])) {
        $meta_desc = mb_substr(strip_tags($page['content']), 0, 160);
    }
    ?>

    <?php if ($meta_desc !== ''): ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="robots" content="<?php echo htmlspecialchars($robots_content, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="<?php echo htmlspecialchars($full_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url"         content="<?php echo htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8'); ?>">
    <?php if ($meta_desc !== ''): ?>
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="<?php echo $THEME_URL; ?>style.css?v=<?php echo $css_version; ?>">
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
                                if ($href === $_SERVER['REQUEST_URI']) {
                                    $active_class = 'is-active';
                                } elseif (($href === 'index.php' || $href === './' || $href === '/') && $_SERVER['REQUEST_URI'] === '/') {
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
                                                <a href="/produkte?category=<?php echo e($category['slug']); ?>">
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
                                        <li><a class="dropdown-title" href="/filtertypen">Alle Filtertypen</a></li>
                                        <?php foreach ($filter_types as $type): ?>
                                            <li>
                                                <a href="/filtertypen?type=<?php echo e($type['slug']); ?>">
                                                    <?php echo e($type['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/' ? 'is-active' : ''; ?>" href="/">Startseite</a></li>
                        <li class="nav-item has-dropdown">
                            <a class="nav-link <?php echo $is_products_context ? 'is-active' : ''; ?>" href="/produkte">Produkte</a>
                            <button class="dropdown-toggle" type="button" data-dropdown-toggle aria-expanded="false" aria-controls="submenu-products">
                                <i class="ph ph-caret-down"></i>
                            </button>
                            <ul class="dropdown" id="submenu-products">
                                <li><a class="dropdown-title" href="/produkte">Alle Produkte</a></li>
                                <?php foreach ($categories as $category): ?>
                                    <li><a href="/produkte?category=<?php echo e($category['slug']); ?>"><?php echo e($category['name']); ?></a></li>
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
                                    <li><a href="/filtertypen?type=<?php echo e($type['slug']); ?>"><?php echo e($type['name']); ?></a></li>
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
        <?php 
            if (isset($content_view)) {
                require __DIR__ . '/../' . $content_view;
            } else {
                echo '<div class="container section"><article class="page-content">';
                echo $page['content'] ?? '';
                echo '</article></div>';
            }
        ?>
    </main>

<?php
// FOOTER LOGIC
$tagline = '';
if (array_key_exists('site_tagline', $settings)) {
    $tagline = (string) $settings['site_tagline'];
} else {
    $tagline = 'Biologische Filtermedien fuer klare, stabile Wasserwelten.';
}

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
$contact_address = array_key_exists('company_address', $settings) ? (string) $settings['company_address'] : '';

$footer_text = '';
if (array_key_exists('footer_text', $settings)) {
    $footer_text = (string) $settings['footer_text'];
}
if ($footer_text === '') {
    $footer_text = date('Y') . ' ' . $site_name . '. Alle Rechte vorbehalten.';
}
$footer_text = str_replace('{year}', date('Y'), $footer_text);

$footer_layout = $settings['footer_layout'] ?? 'standard';
$footer_align = $settings['footer_align'] ?? 'left';
$footer_spacing = $settings['footer_spacing'] ?? 'normal';

$allowed_layouts = ['standard', 'compact'];
$allowed_align = ['left', 'center'];
$allowed_spacing = ['normal', 'tight'];

if (!in_array($footer_layout, $allowed_layouts, true)) {
    $footer_layout = 'standard';
}
if (!in_array($footer_align, $allowed_align, true)) {
    $footer_align = 'left';
}
if (!in_array($footer_spacing, $allowed_spacing, true)) {
    $footer_spacing = 'normal';
}

$show_products = !array_key_exists('footer_show_products', $settings) || (string) $settings['footer_show_products'] !== '0';
$show_navigation = !array_key_exists('footer_show_navigation', $settings) || (string) $settings['footer_show_navigation'] !== '0';
$show_contact = !array_key_exists('footer_show_contact', $settings) || (string) $settings['footer_show_contact'] !== '0';
$show_social = !array_key_exists('footer_show_social', $settings) || (string) $settings['footer_show_social'] !== '0';

$footer_classes = 'site-footer footer-layout-' . $footer_layout . ' footer-align-' . $footer_align . ' footer-spacing-' . $footer_spacing;

$legal_links = [
    ['label' => 'Impressum', 'href' => '/impressum'],
    ['label' => 'Datenschutz', 'href' => '/datenschutz'],
];

$social_links = [
    'social_facebook' => ['icon' => 'ph-facebook-logo', 'label' => 'Facebook'],
    'social_instagram' => ['icon' => 'ph-instagram-logo', 'label' => 'Instagram'],
    'social_youtube' => ['icon' => 'ph-youtube-logo', 'label' => 'YouTube'],
    'social_linkedin' => ['icon' => 'ph-linkedin-logo', 'label' => 'LinkedIn'],
];
?>
    <footer class="<?php echo e($footer_classes); ?>">
        <div class="container footer-inner">
            <div class="footer-brand">
                <div class="brand">Bio<span>home</span></div>
                <?php if ($tagline !== ''): ?>
                    <p><?php echo e($tagline); ?></p>
                <?php endif; ?>
                <?php if ($show_social): ?>
                    <div class="social-links">
                        <?php foreach ($social_links as $key => $meta): ?>
                            <?php if (!empty($settings[$key])): ?>
                                <a href="<?php echo e($settings[$key]); ?>" target="_blank" rel="noopener">
                                    <i class="ph <?php echo e($meta['icon']); ?>"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer-grid">
                <?php if ($show_products): ?>
                    <div class="footer-col">
                        <h4>Produkte</h4>
                        <ul>
                            <?php foreach (array_slice($categories, 0, 6) as $category): ?>
                                <li><a href="/produkte?category=<?php echo e($category['slug']); ?>"><?php echo e($category['name']); ?></a></li>
                            <?php endforeach; ?>
                            <?php if (empty($categories)): ?>
                                <li><a href="/produkte">Zum Katalog</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($show_navigation): ?>
                    <div class="footer-col">
                        <h4>Rechtliches</h4>
                        <ul>
                            <?php foreach ($legal_links as $link): ?>
                                <li><a href="<?php echo e($link['href']); ?>"><?php echo e($link['label']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($show_contact): ?>
                    <div class="footer-col">
                        <h4>Kontakt</h4>
                        <ul>
                            <?php if ($contact_address !== ''): ?>
                                <li><?php echo e($contact_address); ?></li>
                            <?php endif; ?>
                            <?php if ($contact_email !== ''): ?>
                                <li><a href="mailto:<?php echo e($contact_email); ?>"><?php echo e($contact_email); ?></a></li>
                            <?php endif; ?>
                            <?php if ($contact_phone !== ''): ?>
                                <li><a href="tel:<?php echo e(preg_replace('/[^0-9\\+]/', '', $contact_phone)); ?>"><?php echo e($contact_phone); ?></a></li>
                            <?php endif; ?>
                            <li><a href="/kontakt">Kontakt aufnehmen</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer-bottom">
                <?php echo e($footer_text); ?>
            </div>
        </div>
    </footer>

    <div class="cookie-banner" data-cookie-banner aria-live="polite" aria-hidden="true">
        <div class="cookie-banner-inner">
            <div>
                <h4>Cookie-Hinweis</h4>
                <p>Wir verwenden Cookies, um unsere Website zu verbessern. Details findest du in der <a href="/datenschutz">Datenschutzerklaerung</a>.</p>
            </div>
            <div class="cookie-actions">
                <button class="btn btn-primary" type="button" data-cookie-accept>Akzeptieren</button>
                <button class="btn btn-outline" type="button" data-cookie-reject>Ablehnen</button>
            </div>
        </div>
    </div>

    <script>
    (() => {
        const getFaqParts = (target) => {
            if (!target) {
                return null;
            }
            const item = target.closest('.faq-item');
            if (!item) {
                return null;
            }
            const answer = item.querySelector('.faq-answer');
            if (!answer) {
                return null;
            }
            let question = item.querySelector('.faq-question');
            if (!question) {
                const first = item.firstElementChild;
                if (first && first !== answer) {
                    first.classList.add('faq-question');
                    question = first;
                }
            }
            if (!question) {
                return null;
            }
            return { item, question, answer };
        };

        const toggleFaqItem = (target) => {
            const parts = getFaqParts(target);
            if (!parts) {
                return;
            }
            const { item, question, answer } = parts;
            const isOpen = item.classList.contains('is-open');
            if (isOpen) {
                item.classList.remove('is-open');
                answer.style.maxHeight = '0px';
                question.setAttribute('aria-expanded', 'false');
                answer.setAttribute('aria-hidden', 'true');
            } else {
                item.classList.add('is-open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                question.setAttribute('aria-expanded', 'true');
                answer.setAttribute('aria-hidden', 'false');
            }
        };

        const initFaq = () => {
            const items = document.querySelectorAll('.faq-item');
            items.forEach((item) => {
                const answer = item.querySelector('.faq-answer');
                if (!answer) {
                    return;
                }
                let question = item.querySelector('.faq-question');
                if (!question) {
                    const first = item.firstElementChild;
                    if (first && first !== answer) {
                        first.classList.add('faq-question');
                        question = first;
                    }
                }
                if (!question) {
                    return;
                }
                if (!question.querySelector('.faq-icon')) {
                    const icon = document.createElement('span');
                    icon.className = 'faq-icon';
                    icon.textContent = '+';
                    question.appendChild(icon);
                }
                question.setAttribute('role', 'button');
                question.setAttribute('tabindex', '0');

                const isOpen = item.classList.contains('is-open');
                question.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                answer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
                answer.style.maxHeight = isOpen ? answer.scrollHeight + 'px' : '0px';
            });
        };

        window.toggleFaq = (question) => {
            toggleFaqItem(question);
        };

        initFaq();

        document.addEventListener('click', (event) => {
            const target = event.target;
            if (!(target instanceof Element)) {
                return;
            }
            const question = target.closest('.faq-question');
            if (!question) {
                return;
            }
            toggleFaqItem(question);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }
            const target = event.target;
            if (!(target instanceof Element)) {
                return;
            }
            const question = target.closest('.faq-question');
            if (!question) {
                return;
            }
            event.preventDefault();
            toggleFaqItem(question);
        });

        const cookieBanner = document.querySelector('[data-cookie-banner]');
        const cookieAccept = document.querySelector('[data-cookie-accept]');
        const cookieReject = document.querySelector('[data-cookie-reject]');
        const cookieName = 'biohome_cookie_consent';

        const getCookie = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) {
                return parts.pop().split(';').shift();
            }
            return '';
        };

        const setCookie = (name, value, days) => {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/; SameSite=Lax`;
        };

        if (cookieBanner && !getCookie(cookieName)) {
            cookieBanner.classList.add('is-visible');
            cookieBanner.setAttribute('aria-hidden', 'false');
        }

        const hideBanner = () => {
            if (!cookieBanner) {
                return;
            }
            cookieBanner.classList.remove('is-visible');
            cookieBanner.setAttribute('aria-hidden', 'true');
        };

        if (cookieAccept) {
            cookieAccept.addEventListener('click', () => {
                setCookie(cookieName, 'accepted', 365);
                hideBanner();
            });
        }

        if (cookieReject) {
            cookieReject.addEventListener('click', () => {
                setCookie(cookieName, 'rejected', 365);
                hideBanner();
            });
        }

        const body = document.body;
        const navToggle = document.querySelector('[data-nav-toggle]');
        const nav = document.querySelector('[data-nav]');

        if (navToggle && nav) {
            navToggle.addEventListener('click', () => {
                const isOpen = body.classList.toggle('nav-open');
                navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', (event) => {
                if (!body.classList.contains('nav-open')) {
                    return;
                }
                if (nav.contains(event.target) || navToggle.contains(event.target)) {
                    return;
                }
                body.classList.remove('nav-open');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        }

        document.querySelectorAll('[data-dropdown-toggle]').forEach((toggle) => {
            toggle.addEventListener('click', (event) => {
                const isMobile = window.matchMedia('(max-width: 899px)').matches;
                if (!isMobile) {
                    return;
                }
                event.preventDefault();
                const item = toggle.closest('.nav-item');
                if (!item) {
                    return;
                }
                const isOpen = item.classList.toggle('is-open');
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });

        window.addEventListener('resize', () => {
            const isMobile = window.matchMedia('(max-width: 899px)').matches;
            if (!isMobile && navToggle) {
                body.classList.remove('nav-open');
                navToggle.setAttribute('aria-expanded', 'false');
                document.querySelectorAll('.nav-item.is-open').forEach((item) => {
                    item.classList.remove('is-open');
                });
            }
        });

        const slider = document.querySelector('[data-slider]');
        if (!slider) {
            return;
        }

        const slides = Array.from(slider.querySelectorAll('.slide'));
        if (slides.length <= 1) {
            return;
        }

        const dots = Array.from(slider.querySelectorAll('[data-slide]'));
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let index = 0;
        let timerId = null;

        const show = (nextIndex) => {
            index = (nextIndex + slides.length) % slides.length;
            slides.forEach((slide, i) => {
                slide.classList.toggle('is-active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('is-active', i === index);
            });
        };

        const next = () => show(index + 1);
        const prev = () => show(index - 1);

        const start = () => {
            if (!prefersReducedMotion) {
                timerId = window.setInterval(next, 6000);
            }
        };

        const restart = () => {
            if (prefersReducedMotion) {
                return;
            }
            window.clearInterval(timerId);
            start();
        };

        slider.querySelector('[data-next]')?.addEventListener('click', () => {
            next();
            restart();
        });
        slider.querySelector('[data-prev]')?.addEventListener('click', () => {
            prev();
            restart();
        });
        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                show(Number(dot.dataset.slide));
                restart();
            });
        });

        show(0);
        start();
    })();
    </script>
</div>
</body>
</html>
