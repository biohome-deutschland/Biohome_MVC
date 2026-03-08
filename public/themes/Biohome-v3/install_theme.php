<?php
header('Content-Type: text/html; charset=utf-8');

$files = [];
$files['style.css'] = <<<'BIOHOME_FILE_0'
/* Theme Name: Biohome V3 (Rebuild) */
:root {
    --brand: #1d8b5b;
    --brand-dark: #146844;
    --brand-soft: #def5e8;
    --accent: #f59e0b;
    --ink: #0b1f1a;
    --slate: #41534c;
    --muted: #6b7c75;
    --bg: #f4f8f5;
    --surface: #ffffff;
    --border: #d7e4dd;
    --shadow: 0 18px 40px rgba(11, 31, 26, 0.12);
    --radius: 18px;
    --radius-sm: 12px;
    --container: 1200px;
    --header-h: 72px;
    --font-body: "Work Sans", sans-serif;
    --font-display: "Space Grotesk", sans-serif;
}

* {
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    font-family: var(--font-body);
    color: var(--ink);
    background-color: var(--bg);
    background-image:
        radial-gradient(circle at 1px 1px, rgba(20, 104, 68, 0.08) 1px, transparent 0),
        linear-gradient(180deg, #f9fbf9 0%, #eff5f1 55%, #f9fbf9 100%);
    background-size: 26px 26px, 100% 100%;
    min-height: 100vh;
}

img {
    max-width: 100%;
    display: block;
}

a {
    color: inherit;
    text-decoration: none;
}

ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.container {
    width: 100%;
    max-width: var(--container);
    margin: 0 auto;
    padding: 0 20px;
}

.site {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.site-main {
    flex: 1 0 auto;
}

.skip-link {
    position: absolute;
    left: -999px;
    top: auto;
    width: 1px;
    height: 1px;
    overflow: hidden;
}

.skip-link:focus {
    position: fixed;
    left: 20px;
    top: 20px;
    width: auto;
    height: auto;
    padding: 10px 16px;
    background: #fff;
    border-radius: 999px;
    z-index: 2000;
    box-shadow: var(--shadow);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 22px;
    border-radius: 999px;
    border: 1px solid transparent;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
}

.btn:active {
    transform: translateY(1px);
}

.btn-primary {
    background: var(--brand);
    color: #fff;
    box-shadow: 0 8px 18px rgba(29, 139, 91, 0.25);
}

.btn-primary:hover {
    background: var(--brand-dark);
}

.btn-outline {
    background: transparent;
    color: var(--brand-dark);
    border-color: var(--brand);
}

.btn-outline:hover {
    background: var(--brand);
    color: #fff;
}

.btn-ghost {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border-color: rgba(255, 255, 255, 0.4);
}

.btn-ghost:hover {
    background: rgba(255, 255, 255, 0.28);
}

.btn-block {
    width: 100%;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    background: var(--brand-soft);
    color: var(--brand-dark);
}

.badge--highlight {
    background: #fef3c7;
    color: #92400e;
}

.eyebrow {
    text-transform: uppercase;
    letter-spacing: 0.12em;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--brand-dark);
    margin: 0 0 10px 0;
}

.section {
    padding: 64px 0;
}

.section-heading {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 28px;
}

.section-title {
    font-family: var(--font-display);
    font-size: 2rem;
    margin: 0;
}

.section-subtitle {
    color: var(--muted);
    margin: 0;
    max-width: 640px;
}

.section-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.muted {
    color: var(--muted);
}

.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    border-bottom: 1px solid var(--border);
    backdrop-filter: blur(10px);
}

.header-inner {
    min-height: var(--header-h);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.brand {
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 1.3rem;
    letter-spacing: -0.02em;
    display: inline-flex;
    align-items: baseline;
    gap: 0;
}

.brand span {
    color: var(--brand);
}

.nav-toggle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.nav-toggle i {
    font-size: 1.3rem;
}

.main-nav {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--surface);
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transform: translateY(-6px);
    transition: max-height 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
    box-shadow: var(--shadow);
    border-bottom: 1px solid var(--border);
}

body.nav-open .main-nav {
    max-height: 80vh;
    opacity: 1;
    transform: translateY(0);
}

.nav-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 16px 20px 20px;
}

.nav-item {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    border-radius: var(--radius-sm);
}

.nav-link {
    flex: 1 1 auto;
    padding: 10px 12px;
    font-weight: 600;
    border-radius: 12px;
}

.nav-link:hover,
.nav-link.is-active {
    background: var(--brand-soft);
    color: var(--brand-dark);
}

.dropdown-toggle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid var(--border);
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 6px;
    cursor: pointer;
}

.dropdown-toggle i {
    font-size: 1rem;
}

.dropdown {
    width: 100%;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.25s ease;
    padding-left: 12px;
}

.nav-item.is-open .dropdown {
    max-height: 500px;
    margin-bottom: 8px;
}

.dropdown a {
    display: block;
    padding: 8px 12px;
    color: var(--slate);
    border-radius: 10px;
}

.dropdown a:hover {
    background: rgba(29, 139, 91, 0.1);
    color: var(--brand-dark);
}

.dropdown .dropdown-title {
    font-weight: 700;
    color: var(--ink);
}

.header-cta {
    display: none;
}

.nav-cta {
    margin-top: 12px;
}

.hero {
    padding: 36px 0 0;
}

.hero-slider {
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    min-height: 340px;
    box-shadow: var(--shadow);
}

.slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 0.8s ease;
    display: flex;
    align-items: center;
}

.slide.is-active {
    opacity: 1;
}

.slide::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(110deg, rgba(11, 31, 26, 0.82) 0%, rgba(11, 31, 26, 0.3) 50%, rgba(11, 31, 26, 0.55) 100%);
}

.slide-fallback {
    background-image: linear-gradient(135deg, #14532d, #1d8b5b);
}

.slide-content {
    position: relative;
    z-index: 2;
    padding: 48px;
    max-width: 600px;
    color: #fff;
}

.slide-title {
    font-family: var(--font-display);
    font-size: 2.6rem;
    margin: 0 0 12px 0;
}

.slide-text {
    margin: 0 0 24px 0;
    color: rgba(255, 255, 255, 0.88);
}

.slider-controls {
    position: absolute;
    left: 20px;
    bottom: 20px;
    display: flex;
    gap: 10px;
    z-index: 3;
}

.slider-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.4);
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.slider-btn:hover {
    background: rgba(255, 255, 255, 0.35);
}

.slider-dots {
    position: absolute;
    right: 24px;
    bottom: 26px;
    display: flex;
    gap: 8px;
    z-index: 3;
}

.slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.35);
    cursor: pointer;
}

.slider-dot.is-active {
    background: #fff;
}

.category-grid {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
}

.category-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
    min-height: 160px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.category-card:hover {
    transform: translateY(-4px);
    border-color: var(--brand);
    box-shadow: 0 14px 30px rgba(29, 139, 91, 0.12);
}

.category-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--brand-soft);
    color: var(--brand-dark);
    font-size: 1.5rem;
}

.category-card h3 {
    margin: 0;
    font-size: 1.1rem;
}

.product-grid {
    display: grid;
    gap: 24px;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
}

.product-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow);
}

.product-image {
    position: relative;
    padding-top: 66%;
    background: #edf3ef;
}

.placeholder-icon {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #9fb3aa;
}

.product-image img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image .badge {
    position: absolute;
    top: 14px;
    right: 14px;
}

.product-content {
    padding: 18px 20px 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1 1 auto;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.product-title {
    font-size: 1.1rem;
    margin: 0;
}

.product-desc {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0;
    flex: 1;
}

.product-meta {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.page-hero {
    padding: 60px 0 30px;
}

.page-title {
    font-family: var(--font-display);
    font-size: 2.6rem;
    margin: 0 0 12px 0;
}

.page-subtitle {
    color: var(--muted);
    margin: 0;
    max-width: 640px;
}

.breadcrumb {
    font-size: 0.9rem;
    color: var(--muted);
    margin-bottom: 16px;
}

.filter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
}

.filter-chip-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 18px;
}

.filter-chip-group .chip-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--muted);
    font-weight: 600;
}

.chip {
    padding: 8px 14px;
    border-radius: 999px;
    border: 1px solid var(--border);
    font-weight: 600;
    font-size: 0.85rem;
    background: #fff;
    color: var(--slate);
}

.chip.is-active {
    background: var(--brand);
    color: #fff;
    border-color: var(--brand);
}

.product-page {
    padding: 30px 0 80px;
}

.product-layout {
    display: grid;
    gap: 32px;
}

.product-media {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 320px;
    align-self: start;
}

.product-media img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: calc(var(--radius) - 6px);
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.product-details h1 {
    margin: 0;
    font-family: var(--font-display);
    font-size: 2.2rem;
}

.filter-video {
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.filter-video iframe {
    width: 100%;
    aspect-ratio: 16 / 9;
    border: 0;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow);
    background: #000;
}

.filter-video a {
    color: var(--brand-dark);
    text-decoration: underline;
    font-weight: 600;
}

.specs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.specs-table th,
.specs-table td {
    text-align: left;
    padding: 10px 0;
    border-bottom: 1px solid var(--border);
    color: var(--slate);
}

.info-card {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 16px;
    color: var(--slate);
}

.info-card h3 {
    margin-top: 0;
}

.form-message {
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 16px;
    border: 1px solid transparent;
    font-size: 0.95rem;
}

.form-message--success {
    background: #dcfce7;
    border-color: #bbf7d0;
    color: #166534;
}

.form-message--error {
    background: #fee2e2;
    border-color: #fecaca;
    color: #b91c1c;
}

.rich-text {
    color: var(--slate);
    line-height: 1.7;
}

.rich-text h2,
.rich-text h3 {
    font-family: var(--font-display);
    color: var(--ink);
}

.rich-text p {
    margin: 0 0 16px 0;
}

.rich-text ul {
    padding-left: 18px;
    list-style: disc;
}

.rich-text a {
    color: var(--brand-dark);
    text-decoration: underline;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    border: 1px dashed var(--border);
    border-radius: var(--radius);
    background: rgba(255, 255, 255, 0.7);
}

.empty-state i {
    font-size: 2.4rem;
    color: #9fb3aa;
    margin-bottom: 12px;
}

.form-grid {
    display: grid;
    gap: 20px;
}

.contact-grid {
    display: grid;
    gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}

.form-field {
    display: grid;
    gap: 8px;
}

.form-control {
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-family: var(--font-body);
    font-size: 1rem;
}

.form-control:focus {
    outline: 2px solid rgba(29, 139, 91, 0.2);
    border-color: var(--brand);
}

.honeypot {
    position: absolute;
    left: -9999px;
    top: auto;
    width: 1px;
    height: 1px;
    overflow: hidden;
}

.cookie-banner {
    position: fixed;
    left: 20px;
    right: 20px;
    bottom: 20px;
    background: rgba(15, 23, 42, 0.95);
    color: #fff;
    border-radius: 16px;
    padding: 16px 20px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.2);
    z-index: 999;
    opacity: 0;
    transform: translateY(20px);
    pointer-events: none;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.cookie-banner.is-visible {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

.cookie-banner-inner {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.cookie-banner h4 {
    margin: 0 0 6px 0;
    font-size: 1.05rem;
}

.cookie-banner p {
    margin: 0;
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.95rem;
}

.cookie-banner a {
    color: #fff;
    text-decoration: underline;
}

.cookie-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.cookie-banner .btn-outline {
    color: #fff;
    border-color: rgba(255, 255, 255, 0.7);
}

.cookie-banner .btn-outline:hover {
    background: #fff;
    color: #0f172a;
}

@media (min-width: 700px) {
    .cookie-banner-inner {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
}

.faq-list {
    display: grid;
    gap: 14px;
}

.faq-item {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    overflow: hidden;
    padding: 0;
}

.faq-question {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 16px 20px;
    cursor: pointer;
    font-weight: 700;
    color: var(--ink);
}

.faq-question:focus {
    outline: 2px solid rgba(29, 139, 91, 0.25);
    outline-offset: 2px;
}

.faq-icon {
    font-size: 1.4rem;
    color: var(--brand);
    transition: transform 0.2s ease;
}

.faq-answer {
    background: #f8fafc;
    max-height: 0;
    overflow: hidden;
    padding: 0 20px;
    transition: max-height 0.25s ease;
}

.faq-answer-inner {
    padding: 16px 0;
}

.faq-item.is-open .faq-icon {
    transform: rotate(45deg);
}

.faq-item.is-open .faq-answer {
    border-top: 1px solid var(--border);
}

.faq-item h3 {
    margin: 0 0 8px 0;
    font-size: 1.05rem;
}

.faq-item p {
    margin: 0;
    color: var(--muted);
}

.site-footer {
    background: #0b1f1a;
    color: #b6c6bf;
    padding: 70px 0 30px;
    margin-top: 60px;
    position: relative;
}

.site-footer::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 0%, rgba(29, 139, 91, 0.35) 0%, transparent 55%);
    opacity: 0.8;
    pointer-events: none;
}

.site-footer.footer-spacing-tight {
    padding: 50px 0 24px;
    margin-top: 40px;
}

.site-footer.footer-align-center {
    text-align: center;
}

.site-footer.footer-align-center .footer-inner {
    text-align: center;
}

.site-footer.footer-align-center .footer-grid {
    justify-items: center;
}

.site-footer.footer-align-center .footer-col ul {
    justify-items: center;
}

.site-footer.footer-align-center .social-links {
    justify-content: center;
}

.site-footer.footer-layout-compact .footer-inner {
    gap: 24px;
}

.site-footer.footer-layout-compact .footer-grid {
    grid-template-columns: 1fr;
}

.footer-inner {
    position: relative;
    display: grid;
    gap: 32px;
}

.footer-brand {
    display: grid;
    gap: 12px;
}

.footer-brand .brand {
    color: #fff;
}

.footer-grid {
    display: grid;
    gap: 24px;
}

.footer-col h4 {
    color: #fff;
    margin: 0 0 16px 0;
    font-size: 1rem;
}

.footer-col ul {
    display: grid;
    gap: 8px;
}

.footer-col a {
    color: #b6c6bf;
}

.footer-col a:hover {
    color: #fff;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-links a {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.social-links a:hover {
    background: var(--brand);
    border-color: var(--brand);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 30px;
    padding-top: 18px;
    text-align: center;
    font-size: 0.85rem;
}

@media (min-width: 900px) {
    .nav-toggle {
        display: none;
    }
    .section-heading {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-cta {
        display: inline-flex;
    }

    .nav-cta {
        display: none;
    }

    .main-nav {
        position: static;
        max-height: none;
        opacity: 1;
        transform: none;
        background: transparent;
        border-bottom: none;
        box-shadow: none;
    }

    .nav-list {
        flex-direction: row;
        align-items: center;
        padding: 0;
        gap: 6px;
    }

    .nav-item {
        position: relative;
    }

    .dropdown-toggle {
        display: none;
    }

    .dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        min-width: 230px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 8px;
        box-shadow: var(--shadow);
        opacity: 0;
        pointer-events: none;
        transform: translateY(10px);
        max-height: none;
        overflow: visible;
    }

    .nav-item:hover .dropdown,
    .nav-item:focus-within .dropdown {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }

    .dropdown a {
        padding: 10px 12px;
    }

    .hero-slider {
        min-height: 420px;
    }

    .slide-title {
        font-size: 3rem;
    }

    .product-layout {
        grid-template-columns: 1.1fr 1fr;
    }

    .product-media {
        position: sticky;
        top: 110px;
    }

    .footer-inner {
        grid-template-columns: 1.1fr 2fr;
        align-items: start;
    }

    .footer-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .site-footer.footer-layout-compact .footer-inner {
        grid-template-columns: 1fr;
    }

    .site-footer.footer-layout-compact .footer-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (min-width: 1100px) {
    .slide-title {
        font-size: 3.3rem;
    }
}

@media (prefers-reduced-motion: reduce) {
    * {
        scroll-behavior: auto;
    }

    .slide {
        transition: none;
    }

    .btn {
        transition: none;
    }
}
BIOHOME_FILE_0;

$files['header.php'] = <<<'BIOHOME_FILE_1'
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
BIOHOME_FILE_1;

$files['footer.php'] = <<<'BIOHOME_FILE_2'
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
        ['label' => 'Impressum', 'href' => '?page=impressum'],
        ['label' => 'Datenschutz', 'href' => '?page=datenschutz'],
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
                                <li><a href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>"><?php echo e($category['name']); ?></a></li>
                            <?php endforeach; ?>
                            <?php if (empty($categories)): ?>
                                <li><a href="?page=produkte">Zum Katalog</a></li>
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
                            <li><a href="?page=kontakt">Kontakt aufnehmen</a></li>
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
                <p>Wir verwenden Cookies, um unsere Website zu verbessern. Details findest du in der <a href="?page=datenschutz">Datenschutzerklaerung</a>.</p>
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
BIOHOME_FILE_2;

$files['index.php'] = <<<'BIOHOME_FILE_3'
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

$site_name = setting_value($settings, 'site_name', 'Biohome');

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
            'content' => '<p>Das angeforderte Produkt ist nicht verfÃ¼gbar.</p>',
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
BIOHOME_FILE_3;

$files['front-page.php'] = <<<'BIOHOME_FILE_4'
<?php
$slides = [];
try {
    $slides = $pdo->query("SELECT * FROM slides ORDER BY position ASC")->fetchAll();
} catch (PDOException $e) {
    $slides = [];
}

$featured_products = [];
try {
    $featured_products = $pdo->query("SELECT * FROM products WHERE is_featured = 1 ORDER BY id DESC LIMIT 6")->fetchAll();
    if (empty($featured_products)) {
        $featured_products = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 6")->fetchAll();
    }
} catch (PDOException $e) {
    $featured_products = [];
}

$home_page = null;
$home_content = '';
try {
    $stmt = $pdo->prepare("SELECT title, content FROM pages WHERE slug = ?");
    $stmt->execute(['home']);
    $home_page = $stmt->fetch();
    $home_content = trim((string) ($home_page['content'] ?? ''));
} catch (PDOException $e) {
    $home_page = null;
    $home_content = '';
}

$fallback_images = [
    'assets/images/Banner/1-biohome-maxi-ultimate-2-800x800-2x.jpg',
    'assets/images/Banner/6-biohome-closeup-1-800x800-2x.jpg',
    'assets/images/Banner/3-biohome-bioballs-800x800-2x.jpg',
    'assets/images/Banner/4-biohome-ultimate-marine-4-800x800-2x.jpg',
];

function resolve_slide_image(string $image_url, int $index, array $fallback_images): string {
    $image_url = trim($image_url);
    if ($image_url !== '' && preg_match('/^https?:\\/\\//i', $image_url)) {
        return $image_url;
    }

    $relative = ltrim($image_url, '/');
    if ($relative !== '') {
        $root_path = dirname(__DIR__, 2);
        $file_path = $root_path . '/' . $relative;
        if (file_exists($file_path)) {
            return $relative;
        }
    }

    if (!empty($fallback_images)) {
        return $fallback_images[$index % count($fallback_images)];
    }
    return $image_url;
}
?>

<section class="hero">
    <div class="container">
        <div class="hero-slider" data-slider>
            <?php if (!empty($slides)): ?>
                <?php foreach ($slides as $index => $slide): ?>
                    <?php $slide_image = resolve_slide_image((string) ($slide['image_url'] ?? ''), $index, $fallback_images); ?>
                    <div class="slide <?php echo $index === 0 ? 'is-active' : ''; ?>" style="background-image: url('<?php echo e($slide_image); ?>');">
                        <div class="slide-content">
                            <p class="eyebrow">Biohome</p>
                            <h1 class="slide-title"><?php echo e($slide['title']); ?></h1>
                            <?php if (!empty($slide['subtitle'])): ?>
                                <p class="slide-text"><?php echo e($slide['subtitle']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($slide['btn_text'])): ?>
                                <a class="btn btn-ghost" href="<?php echo e($slide['btn_link']); ?>"><?php echo e($slide['btn_text']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $fallback_image = $fallback_images[0] ?? ''; ?>
                <div class="slide slide-fallback is-active" <?php echo $fallback_image !== '' ? 'style="background-image: url(\'' . e($fallback_image) . '\');"' : ''; ?>>
                    <div class="slide-content">
                        <p class="eyebrow">Biohome</p>
                        <h1 class="slide-title">Filtermedien, die Wasser sichtbar besser machen.</h1>
                        <p class="slide-text">Bitte pflegen Sie die Slider-Inhalte im Admin-Bereich.</p>
                        <a class="btn btn-ghost" href="?page=produkte">Zum Katalog</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($slides) > 1): ?>
                <div class="slider-controls">
                    <button class="slider-btn" type="button" data-prev aria-label="Vorherige Folie">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button class="slider-btn" type="button" data-next aria-label="NÃ¤chste Folie">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>
                <div class="slider-dots">
                    <?php foreach ($slides as $index => $slide): ?>
                        <button class="slider-dot <?php echo $index === 0 ? 'is-active' : ''; ?>" type="button" data-slide="<?php echo (int) $index; ?>" aria-label="Folie <?php echo (int) ($index + 1); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($home_content !== ''): ?>
<section class="section">
    <div class="container">
        <div class="rich-text">
            <?php echo $home_content; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Anwendungen</p>
                <h2 class="section-title">Filtermedien f&uuml;r jede Umgebung</h2>
                <p class="section-subtitle">W&auml;hlen Sie die passende Kategorie f&uuml;r S&uuml;&szlig;wasser, Meerwasser oder Profi-Anwendungen.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="?page=produkte">Zum Katalog</a>
            </div>
        </div>
        <?php if (!empty($categories)): ?>
            <div class="category-grid">
                <?php foreach ($categories as $category): ?>
                    <a class="category-card" href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>">
                        <div class="category-icon"><i class="ph <?php echo e(category_icon($category['slug'])); ?>"></i></div>
                        <h3><?php echo e($category['name']); ?></h3>
                        <span class="muted">Produkte ansehen</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-squares-four"></i>
                <p class="muted">Noch keine Kategorien angelegt.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Highlights</p>
                <h2 class="section-title">Ausgew&auml;hlte Biohome Produkte</h2>
                <p class="section-subtitle">Unsere beliebtesten Filtermedien, sofort verf&uuml;gbar im Produktkatalog.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="?page=produkte">Alle Produkte</a>
            </div>
        </div>
        <?php if (!empty($featured_products)): ?>
            <div class="product-grid">
                <?php foreach ($featured_products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo e($product['image_url']); ?>" alt="<?php echo e($product['title']); ?>">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($product['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content">
                            <h3 class="product-title"><?php echo e($product['title']); ?></h3>
                            <p class="product-desc"><?php echo e(text_excerpt($product['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="?product=<?php echo (int) $product['id']; ?>">Details ansehen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-cube"></i>
                <p class="muted">Aktuell sind keine Produkte hinterlegt.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
BIOHOME_FILE_4;

$files['catalog.php'] = <<<'BIOHOME_FILE_5'
<?php
$active_category = $catalog_category ?? null;
$active_slug = $active_category['slug'] ?? '';
$active_name = $active_category['name'] ?? 'Alle Produkte';

$products = [];
try {
    if ($active_category) {
        $stmt = $pdo->prepare(
            "SELECT p.* FROM products p
             JOIN product_categories pc ON p.id = pc.product_id
             WHERE pc.category_id = ?
             ORDER BY p.is_featured DESC, p.id DESC"
        );
        $stmt->execute([(int) $active_category['id']]);
        $products = $stmt->fetchAll();
    } else {
        $products = $pdo->query("SELECT * FROM products ORDER BY is_featured DESC, id DESC")->fetchAll();
    }
} catch (PDOException $e) {
    $products = [];
}
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Produktkatalog</p>
        <h1 class="page-title"><?php echo e($active_name); ?></h1>
        <p class="page-subtitle">Entdecken Sie unsere Biohome Filtermedien und finden Sie das passende Produkt f&uuml;r Ihren Einsatz.</p>
        <div class="filter-chips">
            <a class="chip <?php echo $active_slug === '' ? 'is-active' : ''; ?>" href="?page=produkte">Alle</a>
            <?php foreach ($categories as $category): ?>
                <a class="chip <?php echo $active_slug === $category['slug'] ? 'is-active' : ''; ?>" href="?page=produkte&amp;category=<?php echo e($category['slug']); ?>">
                    <?php echo e($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?php echo e($product['image_url']); ?>" alt="<?php echo e($product['title']); ?>">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($product['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content">
                            <h3 class="product-title"><?php echo e($product['title']); ?></h3>
                            <p class="product-desc"><?php echo e(text_excerpt($product['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="?product=<?php echo (int) $product['id']; ?>">Details ansehen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-magnifying-glass"></i>
                <p class="muted">In dieser Kategorie sind aktuell keine Produkte vorhanden.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
BIOHOME_FILE_5;

$files['product.php'] = <<<'BIOHOME_FILE_6'
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
                <a href="index.php">Startseite</a> / <a href="?page=produkte">Produkte</a> / <?php echo e($product['title']); ?>
            </div>
            <div class="product-layout">
                <div class="product-media">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?php echo e($product['image_url']); ?>" alt="<?php echo e($product['title']); ?>">
                    <?php else: ?>
                        <div class="muted">Kein Bild verfuegbar</div>
                    <?php endif; ?>
                </div>
                <div class="product-details">
                    <div class="product-meta">
                        <?php foreach ($product_categories as $cat_name): ?>
                            <span class="badge"><?php echo e($cat_name); ?></span>
                    <?php endforeach; ?>
                    <?php if (!empty($product['is_featured'])): ?>
                        <span class="badge badge--highlight">Highlight</span>
                    <?php endif; ?>
                    </div>
                    <h1><?php echo e($product['title']); ?></h1>
                    <div class="rich-text">
                        <?php
                        $description = (string) ($product['description'] ?? '');
                        if ($description !== '' && $description === strip_tags($description)) {
                            echo nl2br(e($description));
                        } else {
                            echo $description;
                        }
                        ?>
                    </div>
                    <?php if ($contact_email !== '' || $contact_phone !== ''): ?>
                        <div class="info-card">
                            Fragen zum Produkt? Schreiben Sie uns an
                            <?php if ($contact_email !== ''): ?>
                                <a href="mailto:<?php echo e($contact_email); ?>"><?php echo e($contact_email); ?></a>
                            <?php else: ?>
                                unser Team
                            <?php endif; ?>
                            <?php if ($contact_phone !== ''): ?>
                                oder rufen Sie an unter <a href="tel:<?php echo e(preg_replace('/[^0-9\\+]/', '', $contact_phone)); ?>"><?php echo e($contact_phone); ?></a>
                            <?php endif; ?>.
                        </div>
                    <?php endif; ?>
                    <a class="btn btn-primary btn-block" href="?page=haendler">Haendler finden</a>
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
BIOHOME_FILE_6;

$files['page.php'] = <<<'BIOHOME_FILE_7'
<?php
$page = $page ?? ['title' => '', 'content' => ''];
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Startseite</a>
            <?php if (!empty($page['title'])): ?>
                / <?php echo e($page['title']); ?>
            <?php endif; ?>
        </div>
        <h1 class="page-title"><?php echo e($page['title'] ?? ''); ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="rich-text">
            <?php echo $page['content'] ?? ''; ?>
        </div>
    </div>
</section>
BIOHOME_FILE_7;

$files['contact.php'] = <<<'BIOHOME_FILE_8'
<?php
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
$contact_address = array_key_exists('company_address', $settings) ? (string) $settings['company_address'] : '';
$contact_name = $site_name ?? 'Biohome';

$submit_message = '';
$submit_error = '';
$form_name = '';
$form_email = '';
$form_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $honeypot = trim((string) ($_POST['website'] ?? ''));
    $form_name = trim((string) ($_POST['name'] ?? ''));
    $form_email = trim((string) ($_POST['email'] ?? ''));
    $form_message = trim((string) ($_POST['message'] ?? ''));

    if ($honeypot !== '') {
        $submit_message = 'Danke! Wir melden uns schnellstmoeglich.';
    } elseif ($form_name === '' || $form_email === '' || $form_message === '') {
        $submit_error = 'Bitte alle Felder ausfuellen.';
    } else {
        $submit_message = 'Danke! Wir melden uns schnellstmoeglich.';
    }
}
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Kontakt</p>
        <h1 class="page-title">Wie koennen wir helfen?</h1>
        <p class="page-subtitle">Schreiben Sie uns Ihre Frage oder Anfrage. Wir melden uns schnellstmoeglich zurueck.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div>
                <?php if ($submit_message): ?>
                    <div class="form-message form-message--success"><?php echo e($submit_message); ?></div>
                <?php endif; ?>
                <?php if ($submit_error): ?>
                    <div class="form-message form-message--error"><?php echo e($submit_error); ?></div>
                <?php endif; ?>
                <form action="?page=kontakt" method="post">
                    <div class="form-field">
                        <label for="contact-name">Name</label>
                        <input class="form-control" type="text" id="contact-name" name="name" placeholder="Ihr Name" value="<?php echo e($form_name); ?>">
                    </div>
                    <div class="form-field">
                        <label for="contact-email">E-Mail</label>
                        <input class="form-control" type="email" id="contact-email" name="email" placeholder="name@beispiel.de" value="<?php echo e($form_email); ?>">
                    </div>
                    <div class="form-field">
                        <label for="contact-message">Nachricht</label>
                        <textarea class="form-control" id="contact-message" name="message" rows="6" placeholder="Wie koennen wir helfen?"><?php echo e($form_message); ?></textarea>
                    </div>
                    <div class="form-field honeypot" aria-hidden="true">
                        <label for="contact-website">Website</label>
                        <input class="form-control" type="text" id="contact-website" name="website" autocomplete="off" tabindex="-1">
                    </div>
                    <button class="btn btn-primary" type="submit">Nachricht senden</button>
                </form>
            </div>
            <div class="info-card">
                <h3><?php echo e($contact_name); ?></h3>
                <?php if ($contact_address !== ''): ?>
                    <p><?php echo e($contact_address); ?></p>
                <?php endif; ?>
                <?php if ($contact_email !== ''): ?>
                    <p><a href="mailto:<?php echo e($contact_email); ?>"><?php echo e($contact_email); ?></a></p>
                <?php endif; ?>
                <?php if ($contact_phone !== ''): ?>
                    <p><a href="tel:<?php echo e(preg_replace('/[^0-9\\+]/', '', $contact_phone)); ?>"><?php echo e($contact_phone); ?></a></p>
                <?php endif; ?>
                <p class="muted">Sie moechten Haendler werden? <a href="?page=haendler">Jetzt anfragen</a>.</p>
            </div>
        </div>
    </div>
</section>
BIOHOME_FILE_8;

$files['faq.php'] = <<<'BIOHOME_FILE_9'
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">FAQ</p>
        <h1 class="page-title">HÃ¤ufige Fragen zu Biohome</h1>
        <p class="page-subtitle">Antworten auf die wichtigsten Fragen rund um unsere Filtermedien.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="faq-list">
            <div class="faq-item">
                <h3>Wie viel Biohome benÃ¶tige ich?</h3>
                <p>Als Faustregel empfehlen wir ca. 1 kg pro 100 Liter Wasser bei normalem Besatz.</p>
            </div>
            <div class="faq-item">
                <h3>Muss ich das Filtermedium austauschen?</h3>
                <p>Biohome ist sehr langlebig. In vielen FÃ¤llen reicht das AusspÃ¼len und die regelmÃ¤ÃŸige Wartung.</p>
            </div>
            <div class="faq-item">
                <h3>Ist Biohome fÃ¼r Meerwasser geeignet?</h3>
                <p>Ja, Biohome wird sowohl im SÃ¼ÃŸ- als auch im Meerwasser erfolgreich eingesetzt.</p>
            </div>
        </div>
    </div>
</section>
BIOHOME_FILE_9;

$files['filter-catalog.php'] = <<<'BIOHOME_FILE_10'
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
BIOHOME_FILE_10;

$files['filter.php'] = <<<'BIOHOME_FILE_11'
<?php
$filter = $filter ?? null;

$video_url = '';
$embed_url = '';
if ($filter) {
    $video_url = trim((string) ($filter['video_url'] ?? ''));
    if ($video_url !== '') {
        if (preg_match('~youtube\\.com/watch\\?v=([^&]+)~', $video_url, $matches) || preg_match('~youtu\\.be/([^?&]+)~', $video_url, $matches)) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('~vimeo\\.com/(\\d+)~', $video_url, $matches)) {
            $embed_url = 'https://player.vimeo.com/video/' . $matches[1];
        }
    }
}
?>

<?php if ($filter): ?>
    <section class="product-page">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Startseite</a> / <a href="?page=filtertypen">Filtertypen</a> / <?php echo e($filter['title']); ?>
            </div>
            <div class="product-layout">
                <div class="product-media">
                    <?php if (!empty($filter['image_url'])): ?>
                        <img src="<?php echo e($filter['image_url']); ?>" alt="<?php echo e($filter['title']); ?>">
                    <?php else: ?>
                        <div class="muted">Kein Bild verfuegbar</div>
                    <?php endif; ?>
                </div>
                <div class="product-details">
                    <div class="product-meta">
                        <?php if (!empty($filter['type_name'])): ?>
                            <span class="badge"><?php echo e($filter['type_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($filter['brand_name'])): ?>
                            <span class="badge"><?php echo e($filter['brand_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($filter['is_featured'])): ?>
                            <span class="badge badge--highlight">Highlight</span>
                        <?php endif; ?>
                    </div>
                    <h1><?php echo e($filter['title']); ?></h1>
                    <div class="rich-text">
                        <?php
                        $description = (string) ($filter['description'] ?? '');
                        if ($description !== '' && $description === strip_tags($description)) {
                            echo nl2br(e($description));
                        } else {
                            echo $description;
                        }
                        ?>
                    </div>

                    <?php if ($video_url !== ''): ?>
                        <div class="filter-video">
                            <h3>Video</h3>
                            <?php if ($embed_url !== ''): ?>
                                <iframe src="<?php echo e($embed_url); ?>" allowfullscreen loading="lazy"></iframe>
                            <?php else: ?>
                                <a href="<?php echo e($video_url); ?>" target="_blank" rel="noopener">Video ansehen</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="section">
        <div class="container">
            <div class="empty-state">
                <i class="ph ph-warning-circle"></i>
                <p class="muted">Filter nicht gefunden.</p>
            </div>
        </div>
    </section>
<?php endif; ?>
BIOHOME_FILE_11;

$files['tpl-card-product.php'] = <<<'BIOHOME_FILE_12'
<div class="cat-card" style="text-align:left; padding:0; overflow:hidden; display:flex; flex-direction:column; border:1px solid #e2e8f0;">
    <div style="height:220px; background:#f8fafc; display:flex; align-items:center; justify-content:center; position:relative; border-bottom:1px solid #e2e8f0;">
        <?php if(!empty($p['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($p['image_url']); ?>" style="height:100%; width:100%; object-fit:cover;">
        <?php else: ?>
            <i class="ph ph-cube" style="font-size:4rem; color:#cbd5e1;"></i>
        <?php endif; ?>
        <?php if(isset($p['is_featured']) && $p['is_featured']): ?>
            <span style="position:absolute; top:10px; right:10px; background:#fbbf24; color:#78350f; font-size:0.7rem; font-weight:bold; padding:2px 8px; border-radius:10px;">TOP</span>
        <?php endif; ?>
    </div>
    <div style="padding:20px; flex:1; display:flex; flex-direction:column;">
        <h4 style="font-size:1.1rem; margin-bottom:10px; color:#0f172a;"><?php echo htmlspecialchars($p['title']); ?></h4>
        <a href="?product=<?php echo $p['id']; ?>" class="btn-outline" style="border:1px solid #16a34a; border-radius:6px; text-align:center; padding:8px; display:block; margin-top:auto;">Details</a>
    </div>
</div>
BIOHOME_FILE_12;

$files['tpl-catalog.php'] = <<<'BIOHOME_FILE_13'
<?php
// Filter Logik (wird von index.php Ã¼bergeben: $data['filter'])
$filter = $data['filter'] ?? 'all';
$title = $data['title'] ?? 'Katalog';

// Produkte laden
if ($filter === 'all') {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT p.* FROM products p JOIN product_categories pc ON p.id=pc.product_id JOIN categories c ON pc.category_id=c.id WHERE c.slug = ? ORDER BY p.id DESC");
    $stmt->execute([$filter]);
    $products = $stmt->fetchAll();
}
?>
<div class="hero" style="padding:60px 0; margin-bottom:40px; background:var(--dark);">
    <div class="container">
        <h1 style="font-size:3rem; margin:0; color:white;"><?php echo htmlspecialchars($title); ?></h1>
    </div>
</div>

<div class="container" style="margin-bottom:80px;">
    <?php if ($products): ?>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:30px;">
        <?php foreach($products as $p) { include 'tpl-card-product.php'; } ?>
    </div>
    <?php else: ?>
        <div style="text-align:center; padding:50px; background:#f8fafc; border-radius:8px;">
            <p>Keine Produkte in dieser Kategorie gefunden.</p>
            <a href="?page=produkte" class="btn btn-sm" style="margin-top:10px;">Alle anzeigen</a>
        </div>
    <?php endif; ?>
</div>
BIOHOME_FILE_13;

$files['tpl-contact.php'] = <<<'BIOHOME_FILE_14'
<div class="container" style="padding-top:60px; padding-bottom:60px;">
    <div class="contact-grid">
        <div>
            <h1>Kontakt</h1>
            <p style="margin-bottom:30px;">Schreiben Sie uns eine Nachricht.</p>
            <form onsubmit="alert('Demo: Nachricht gesendet!'); return false;">
                <div class="form-group"><label>Name</label><input type="text" class="form-control" required></div>
                <div class="form-group"><label>E-Mail</label><input type="email" class="form-control" required></div>
                <div class="form-group"><label>Nachricht</label><textarea class="form-control" rows="5" required></textarea></div>
                <button class="btn">Senden</button>
            </form>
        </div>
        <div class="contact-info-card">
            <h3 style="color:white; border-bottom:1px solid #334155; padding-bottom:15px;">Daten</h3>
            <div class="contact-item"><i class="ph ph-envelope"></i><div>info@biohome-filter.de</div></div>
        </div>
    </div>
</div>
BIOHOME_FILE_14;

$files['tpl-faq.php'] = <<<'BIOHOME_FILE_15'
<div class="hero" style="padding:60px 0; background:var(--dark); margin-bottom:40px;">
    <div class="container"><h1 style="color:white; text-align:center;">FAQ</h1></div>
</div>
<div class="container faq-container">
    <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">Wie viel Biohome brauche ich?<i class="ph ph-plus faq-icon"></i></div>
        <div class="faq-answer"><div class="faq-answer-inner">Ca. 1kg pro 100 Liter bei normalem Besatz.</div></div>
    </div>
    <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">Muss ich es austauschen?<i class="ph ph-plus faq-icon"></i></div>
        <div class="faq-answer"><div class="faq-answer-inner">Nein, es ist extrem langlebiges Sinterglas.</div></div>
    </div>
</div>
BIOHOME_FILE_15;

$files['tpl-home.php'] = <<<'BIOHOME_FILE_16'
<?php
// Slider laden
$slides = $pdo->query("SELECT * FROM slides ORDER BY position ASC")->fetchAll();
?>
<!-- Slider -->
<section class="hero-slider" id="homeSlider">
    <?php if($slides): $i=0; foreach($slides as $s): $act=($i===0)?'active':''; ?>
    <div class="slide <?php echo $act; ?>" style="background-image: url('<?php echo htmlspecialchars($s['image_url']); ?>');">
        <div class="slide-content">
            <h1 class="slide-title"><?php echo htmlspecialchars($s['title']); ?></h1>
            <?php if($s['subtitle']): ?><p class="slide-text"><?php echo htmlspecialchars($s['subtitle']); ?></p><?php endif; ?>
            <?php if($s['btn_text']): ?><a href="<?php echo htmlspecialchars($s['btn_link']); ?>" class="btn"><?php echo htmlspecialchars($s['btn_text']); ?></a><?php endif; ?>
        </div>
    </div>
    <?php $i++; endforeach; else: ?>
    <div class="slide active" style="background:#0f172a;"><div class="slide-content"><h1>Willkommen</h1><p>Bitte Slider im Admin anlegen.</p></div></div>
    <?php endif; ?>
    <div class="arrow prev" onclick="moveSlide(-1)"><i class="ph ph-caret-left"></i></div>
    <div class="arrow next" onclick="moveSlide(1)"><i class="ph ph-caret-right"></i></div>
</section>

<!-- Kategorien -->
<section class="container">
    <div style="text-align:center; margin-bottom:40px;">
        <h2>FÃ¼r jeden Bereich das Optimum</h2>
        <p style="color:var(--gray);">WÃ¤hlen Sie Ihren Anwendungsbereich</p>
    </div>
    <div class="category-grid">
        <?php foreach($pdo->query("SELECT * FROM categories ORDER BY name ASC") as $cat): 
            $icon = 'ph-squares-four';
            if(strpos($cat['slug'],'suess')!==false) $icon='ph-fish-simple';
            if(strpos($cat['slug'],'meer')!==false) $icon='ph-drop';
            if(strpos($cat['slug'],'teich')!==false) $icon='ph-waves';
        ?>
        <a href="?page=<?php echo $cat['slug']; ?>" class="cat-card">
            <i class="ph <?php echo $icon; ?> cat-icon"></i>
            <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Highlights -->
<section class="container" style="margin:80px auto;">
    <h3 style="text-align:center; margin-bottom:40px;">Highlights</h3>
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:30px;">
        <?php foreach($pdo->query("SELECT * FROM products WHERE is_featured=1 LIMIT 4") as $p): ?>
            <?php include 'tpl-card-product.php'; // Helper fÃ¼r die Karte ?>
        <?php endforeach; ?>
    </div>
</section>
BIOHOME_FILE_16;

$files['tpl-page.php'] = <<<'BIOHOME_FILE_17'
<?php 
// Fallback fÃ¼r $data['page'] prÃ¼fen
$page_title = $data['page']['title'] ?? 'Seite';
$page_content = $data['page']['content'] ?? '<p>Inhalt folgt.</p>';
?>
<div class="hero" style="padding:60px 0; margin-bottom:40px; background:var(--dark);">
    <div class="container">
        <h1 style="font-size:3rem; margin:0; color:white; text-align:center;"><?php echo htmlspecialchars($page_title); ?></h1>
    </div>
</div>
<div class="container" style="padding-bottom:60px; max-width:900px;">
    <article class="typography">
        <?php echo $page_content; ?>
    </article>
</div>
BIOHOME_FILE_17;

$files['tpl-product.php'] = <<<'BIOHOME_FILE_18'
<?php $p = $data['product']; ?>
<div class="container" style="margin-top:40px; margin-bottom:80px;">
    <div style="font-size:0.9rem; color:var(--gray); margin-bottom:20px;">
        <a href="index.php">Home</a> / <a href="?page=produkte">Produkte</a> / <?php echo htmlspecialchars($p['title']); ?>
    </div>
    
    <div class="product-layout">
        <div class="product-gallery">
            <?php if($p['image_url']): ?>
                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" style="max-height:400px; width:auto;">
            <?php else: ?>
                <div style="padding:100px; color:#ccc;">Kein Bild</div>
            <?php endif; ?>
        </div>
        <div class="product-info">
            <?php if(isset($data['cats'])) foreach($data['cats'] as $c): ?>
                <span class="badge"><?php echo htmlspecialchars($c); ?></span>
            <?php endforeach; ?>
            
            <h1 style="margin-top:10px;"><?php echo htmlspecialchars($p['title']); ?></h1>
            <div style="margin:20px 0; line-height:1.6; color:#334155;">
                <?php echo nl2br(htmlspecialchars($p['description'])); ?>
            </div>
            
            <div style="background:#f8fafc; padding:20px; border-radius:8px; border:1px solid var(--border); margin-top:20px;">
                <strong>VerfÃ¼gbarkeit:</strong><br>
                Dieses Produkt ist bei unseren FachhÃ¤ndlern erhÃ¤ltlich.
            </div>
            <a href="?page=haendler" class="btn" style="margin-top:20px; width:100%; justify-content:center;">HÃ¤ndler finden</a>
        </div>
    </div>
</div>
BIOHOME_FILE_18;

$files['AGENTS.md'] = <<<'BIOHOME_FILE_19'
# AGENTS.md instructions for c:\Users\hherz\OneDrive\Dokumente\BiohomeWebseite\biohome_cms\biohome_cms\themes\Biohome-v3

<INSTRUCTIONS>
## Skills
These skills are discovered at startup from multiple local sources. Each entry includes a name, description, and file path so you can open the source for full instructions.
- skill-creator: Guide for creating effective skills. This skill should be used when users want to create a new skill (or update an existing skill) that extends Codex's capabilities with specialized knowledge, workflows, or tool integrations. (file: C:/Users/hherz/.codex/skills/.system/skill-creator/SKILL.md)
- skill-installer: Install Codex skills into $CODEX_HOME/skills from a curated list or a GitHub repo path. Use when a user asks to list installable skills, install a curated skill, or install a skill from another repo (including private repos). (file: C:/Users/hherz/.codex/skills/.system/skill-installer/SKILL.md)
- Discovery: Available skills are listed in project docs and may also appear in a runtime "## Skills" section (name + description + file path). These are the sources of truth; skill bodies live on disk at the listed paths.
- Trigger rules: If the user names a skill (with `$SkillName` or plain text) OR the task clearly matches a skill's description, you must use that skill for that turn. Multiple mentions mean use them all. Do not carry skills across turns unless re-mentioned.
- Missing/blocked: If a named skill isn't in the list or the path can't be read, say so briefly and continue with the best fallback.
- How to use a skill (progressive disclosure):
  1) After deciding to use a skill, open its `SKILL.md`. Read only enough to follow the workflow.
  2) If `SKILL.md` points to extra folders such as `references/`, load only the specific files needed for the request; don't bulk-load everything.
  3) If `scripts/` exist, prefer running or patching them instead of retyping large code blocks.
  4) If `assets/` or templates exist, reuse them instead of recreating from scratch.
- Description as trigger: The YAML `description` in `SKILL.md` is the primary trigger signal; rely on it to decide applicability. If unsure, ask a brief clarification before proceeding.
- Coordination and sequencing:
  - If multiple skills apply, choose the minimal set that covers the request and state the order you'll use them.
  - Announce which skill(s) you're using and why (one short line). If you skip an obvious skill, say why.
- Context hygiene:
  - Keep context small: summarize long sections instead of pasting them; only load extra files when needed.
  - Avoid deeply nested references; prefer one-hop files explicitly linked from `SKILL.md`.
  - When variants exist (frameworks, providers, domains), pick only the relevant reference file(s) and note that choice.
- Safety and fallback: If a skill can't be applied cleanly (missing files, unclear instructions), state the issue, pick the next-best approach, and continue.
</INSTRUCTIONS>
BIOHOME_FILE_19;

$results = [];
foreach ($files as $filename => $content) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . $filename;
    $written = file_put_contents($path, $content);
    $results[] = ['name' => $filename, 'ok' => ($written !== false)];
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biohome Theme Installer</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f8fafc; color: #0f172a; }
        .card { max-width: 720px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 28px; box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08); }
        h1 { margin-top: 0; }
        ul { list-style: none; padding: 0; }
        li { padding: 8px 0; }
        .ok { color: #15803d; }
        .fail { color: #b91c1c; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 16px; background: #1d8b5b; color: #fff; border-radius: 999px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Biohome Theme Installer</h1>
        <p>Die Theme-Dateien wurden aktualisiert:</p>
        <ul>
            <?php foreach ($results as $result): ?>
                <li class="<?php echo $result['ok'] ? 'ok' : 'fail'; ?>">
                    <?php echo $result['ok'] ? 'OK' : 'FEHLER'; ?> <?php echo htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8'); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p>Hinweis: Bitte <strong>install_theme.php</strong> nach dem Update loeschen.</p>
        <a class="btn" href="../../index.php">Zur Startseite</a>
    </div>
</body>
</html>