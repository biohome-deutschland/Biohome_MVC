<?php
$settings = $settings ?? [];
$menu_items = $menu_items ?? [];
$categories = $categories ?? [];
$footer_legal_links = $footer_legal_links ?? [];

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

$legal_links = $footer_legal_links;
if (empty($legal_links)) {
    $legal_links = [
        ['label' => 'Impressum', 'href' => '/impressum'],
        ['label' => 'Datenschutz', 'href' => '/datenschutz'],
    ];
}

$social_links = [
    'social_facebook' => ['icon' => 'ph-facebook-logo', 'label' => 'Facebook'],
    'social_instagram' => ['icon' => 'ph-instagram-logo', 'label' => 'Instagram'],
    'social_youtube' => ['icon' => 'ph-youtube-logo', 'label' => 'YouTube'],
    'social_linkedin' => ['icon' => 'ph-linkedin-logo', 'label' => 'LinkedIn'],
];
?>
    </main>
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
                                <li><a href="/produkte?category=<?php echo htmlspecialchars($category['slug']); ?>"><?php echo htmlspecialchars($category['name']); ?></a></li>
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
    <?php
    $matomo_url = '';
    $matomo_site_id = '';
    if (defined('MATOMO_URL')) {
        $matomo_url = rtrim((string) MATOMO_URL, '/') . '/';
    }
    if (defined('MATOMO_SITE_ID')) {
        $matomo_site_id = (string) MATOMO_SITE_ID;
    }
    ?>
    <?php if ($matomo_url !== '' && $matomo_site_id !== ''): ?>
        <script>
        var _paq = window._paq = window._paq || [];
        _paq.push(['disableCookies']);
        _paq.push(['setDoNotTrack', true]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = "<?php echo e($matomo_url); ?>";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', "<?php echo e($matomo_site_id); ?>"]);
            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true; g.src = u + 'matomo.js'; s.parentNode.insertBefore(g, s);
        })();
        </script>
        <noscript><p><img src="<?php echo e($matomo_url); ?>matomo.php?idsite=<?php echo e($matomo_site_id); ?>&rec=1" style="border:0;" alt=""></p></noscript>
    <?php endif; ?>
</div>
</body>
</html>
