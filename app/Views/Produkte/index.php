<?php
$active_category = $active_category ?? null;
$active_slug = $active_category['slug'] ?? '';
$active_name = $active_category['name'] ?? 'Alle Produkte';
$categories = $categories ?? [];
$products = $products ?? [];

function text_excerpt($text, $length = 120) {
    if (mb_strlen($text) <= $length) return $text;
    $text = html_entity_decode((string)$text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return mb_substr(strip_tags($text), 0, $length) . '...';
}
?>
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Produktkatalog</p>
        <h1 class="page-title"><?php echo htmlspecialchars($active_name); ?></h1>
        <p class="page-subtitle">Entdecken Sie unsere Biohome Filtermedien und finden Sie das passende Produkt f&uuml;r Ihren Einsatz.</p>
        <div class="filter-chips">
            <a class="chip <?php echo $active_slug === '' ? 'is-active' : ''; ?>" href="/produkte">Alle</a>
            <?php foreach ($categories as $category): ?>
                <a class="chip <?php echo $active_slug === $category['slug'] ? 'is-active' : ''; ?>" href="/produkte?category=<?php echo htmlspecialchars($category['slug']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($products)): ?>
            <div class="search-wrapper" style="margin-bottom: 2rem;">
                <input type="search" id="productSearch" placeholder="Produkt suchen..." class="search-input" aria-label="Produkte durchsuchen" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem;">
            </div>
            <div class="product-grid" id="productGrid">
                <?php foreach ($products as $product): ?>
                    <article class="product-card" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px; height: 100%; display: flex; flex-direction: column;">
                        <div class="product-image">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="/<?php echo ltrim(htmlspecialchars($product['image_url']), '/'); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" loading="lazy" style="border-radius: 12px 12px 0 0; object-fit: cover; aspect-ratio: 4/3; width: 100%;">
                            <?php else: ?>
                                <i class="ph ph-cube placeholder-icon"></i>
                            <?php endif; ?>
                            <?php if (!empty($product['is_featured'])): ?>
                                <span class="badge badge--highlight">Highlight</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-content" style="flex: 1; display: flex; flex-direction: column;">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h3>
                            <p class="product-desc" style="flex: 1;"><?php echo htmlspecialchars(text_excerpt($product['description'] ?? '', 120)); ?></p>
                            <a class="btn btn-primary" href="/produkt/<?php echo (int) $product['id']; ?>" style="border-radius: 9999px; width: 100%; text-align: center; margin-top: auto;">Details ansehen</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div id="noResults" class="empty-state" style="display: none; padding: 3rem 0; text-align: center;">
                <i class="ph ph-magnifying-glass" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <p class="muted">Keine Produkte für Ihre Suche gefunden.</p>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('productSearch');
                    const productCards = document.querySelectorAll('#productGrid .product-card');
                    const noResultsMessage = document.getElementById('noResults');

                    if (searchInput) {
                        searchInput.addEventListener('input', function(e) {
                            const searchTerm = e.target.value.toLowerCase().trim();
                            let visibleCount = 0;

                            productCards.forEach(card => {
                                const title = card.querySelector('.product-title').textContent.toLowerCase();
                                const desc = card.querySelector('.product-desc').textContent.toLowerCase();
                                
                                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                                    card.style.display = '';
                                    visibleCount++;
                                } else {
                                    card.style.display = 'none';
                                }
                            });

                            if (visibleCount === 0) {
                                noResultsMessage.style.display = 'block';
                            } else {
                                noResultsMessage.style.display = 'none';
                            }
                        });
                    }
                });
            </script>
        <?php else: ?>
            <div class="empty-state">
                <i class="ph ph-magnifying-glass"></i>
                <p class="muted">In dieser Kategorie sind aktuell keine Produkte vorhanden.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
