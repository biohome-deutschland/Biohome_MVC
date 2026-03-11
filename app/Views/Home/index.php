<?php
$slides = $slides ?? [];
$categories = $categories ?? [];
$featured_products = $featured_products ?? [];
$home_page = $home_page ?? ['content' => ''];
$home_content = trim($home_page['content'] ?? '');

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
        return '/' . $relative;
    }
    if (!empty($fallback_images)) {
        return '/' . $fallback_images[$index % count($fallback_images)];
    }
    return '';
}
?>

<section class="hero">
    <div class="container">
        <div class="hero-slider" data-slider>
            <?php if (!empty($slides)): ?>
                <?php foreach ($slides as $index => $slide): ?>
                    <?php $slide_image = resolve_slide_image((string) ($slide['image_url'] ?? ''), $index, $fallback_images); ?>
                    <div class="slide <?php echo $index === 0 ? 'is-active' : ''; ?>" style="background-image: url('<?php echo htmlspecialchars($slide_image); ?>');" <?php echo $index === 0 ? 'loading="eager"' : ''; ?>>
                        <div class="slide-content">
                            <p class="eyebrow">Biohome</p>
                            <h1 class="slide-title"><?php echo htmlspecialchars($slide['title']); ?></h1>
                            <?php if (!empty($slide['subtitle'])): ?>
                                <p class="slide-text"><?php echo htmlspecialchars($slide['subtitle']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($slide['btn_text'])): ?>
                                <a class="btn btn-ghost" href="<?php echo htmlspecialchars($slide['btn_link']); ?>"><?php echo htmlspecialchars($slide['btn_text']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $fallback_image = $fallback_images[0] ?? ''; ?>
                <div class="slide slide-fallback is-active" <?php echo $fallback_image !== '' ? 'style="background-image: url(\'/' . htmlspecialchars($fallback_image) . '\');"' : ''; ?>>
                    <div class="slide-content">
                        <p class="eyebrow">Biohome</p>
                        <h1 class="slide-title">Filtermedien, die Wasser sichtbar besser machen.</h1>
                        <p class="slide-text">Bitte pflegen Sie die Slider-Inhalte im Admin-Bereich.</p>
                        <a class="btn btn-ghost" href="/produkte">Zum Katalog</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($slides) > 1): ?>
                <div class="slider-controls">
                    <button class="slider-btn" type="button" data-prev aria-label="Vorherige Folie">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button class="slider-btn" type="button" data-next aria-label="Nächste Folie">
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

<section class="section" style="padding: 5rem 0 3rem; background: #fff;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto 4rem;">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; line-height: 1.2;">
                Perfektes Wasser durch <span style="color: var(--brand, #16a34a);">biologische Präzision</span>
            </h2>
            <p style="font-size: 1.15rem; color: #475569; line-height: 1.6;">
                Viele Filtermedien wurden ursprünglich für andere Zwecke entwickelt und nur "zweckentfremdet". Biohome ist anders. Es ist das erste Sinterglas-Medium, das von Grund auf spezifisch für die Wasserfiltration konstruiert wurde. Egal ob im Nano-Aquarium, im Koi-Teich, in RAS-Zuchtanlagen oder der industriellen Abwasserklärung: Biohome liefert reproduzierbare, biologische Höchstleistung.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
            <div>
                <h3 style="color: #dc2626; font-size: 1.5rem; margin-bottom: 1rem;">Das Limit herkömmlicher Medien</h3>
                <p style="color: #475569; line-height: 1.6;"><strong>Die "Nitrat-Sackgasse".</strong><br>Standard-Medien (Kunststoff, Schwamm, einfache Keramik) beherrschen meist nur den aeroben Abbau (Ammonium &rarr; Nitrit &rarr; Nitrat). Dort stoppt der Prozess. Nitrat reichert sich an. Im Aquarium führt das zu Algen, in der Fischzucht zu Wachstumsstörungen und in der Industrie zu Grenzwertüberschreitungen.</p>
            </div>
            <div>
                <h3 style="color: #16a34a; font-size: 1.5rem; margin-bottom: 1rem;">Die Biohome Lösung</h3>
                <p style="color: #475569; line-height: 1.6;"><strong>Full Cycle Filtration (Denitrifikation).</strong><br>Durch die einzigartige Sinterstruktur schafft Biohome sauerstoffarme Zonen im Kern des Materials &ndash; selbst bei starker Strömung. Hier siedeln Bakterien, die Nitrat eliminieren. Das Ergebnis: Ein geschlossener Stickstoffkreislauf, wie in der Natur.</p>
            </div>
        </div>

        <div style="background: #f8fafc; border-radius: 16px; padding: 3rem;">
            <h3 style="text-align: center; font-size: 1.8rem; margin-bottom: 2rem;">Warum Sinterglas überlegen ist</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h4 style="color: #0f172a; margin-bottom: 0.5rem;">Extreme Porosität (&gt;50%)</h4>
                    <p style="color: #475569; font-size: 0.95rem;">Biohome bietet durch seine offene Porenstruktur eine der höchsten effektiv nutzbaren Oberflächen am Markt. Wasser und Nährstoffe erreichen jeden Winkel des Mediums.</p>
                </div>
                <div>
                    <h4 style="color: #0f172a; margin-bottom: 0.5rem;">Industriestandard</h4>
                    <p style="color: #475569; font-size: 0.95rem;">Entwickelt, um höchsten Belastungen standzuhalten. Ob in riesigen Rieselfiltern (Bakki Showers) oder industriellen Klärbecken &ndash; Biohome zerbröselt nicht und behält seine Struktur.</p>
                </div>
                <div>
                    <h4 style="color: #0f172a; margin-bottom: 0.5rem;">Nachhaltigkeit</h4>
                    <p style="color: #475569; font-size: 0.95rem;">Biohome ist chemisch inert und gibt keine Stoffe ans Wasser ab. Es ist kein Wegwerfprodukt, sondern eine langfristige Investition in die Systemstabilität.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Anwendungen</p>
                <h2 class="section-title">Filtermedien für jede Umgebung</h2>
                <p class="section-subtitle">Wählen Sie die passende Kategorie für Süßwasser, Meerwasser oder Profi-Anwendungen.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="/produkte">Zum Katalog</a>
            </div>
        </div>
        <?php if (!empty($categories)): ?>
            <div class="category-grid">
                <?php foreach ($categories as $category): 
                    $icon = 'ph-squares-four';
                    $cat_desc = '';
                    $slug = $category['slug'] ?? '';
                    if(strpos($slug,'suess')!==false) { 
                        $icon='ph-fish-simple'; 
                        $cat_desc = 'Biohome‑Filtermedien bieten aerobe und anaerobe Bakterienflächen und halten Ammoniak, Nitrit und Nitrat im Gleichgewicht – so bleibt das Wasser glasklar.'; 
                    }
                    elseif(strpos($slug,'meer')!==false) { 
                        $icon='ph-drop'; 
                        $cat_desc = 'Die poröse Sinterglas‑Struktur bietet Aeroben und Anaeroben eine Heimat; so bleibt das Meerwasser stabil, Korallen wachsen und Nitrat wird abgebaut.'; 
                    }
                    elseif(strpos($slug,'teich')!==false) { 
                        $icon='ph-waves'; 
                        $cat_desc = 'Dank Biohome‑Filtermedien bleibt das Teichwasser klar, Nährstoffüberschüsse werden abgebaut und Sie benötigen weniger Platz als bei herkömmlichen Systemen.'; 
                    }
                    elseif(strpos($slug,'profi')!==false || strpos($slug,'industrie')!==false || strpos($slug,'klaerung')!==false) {
                        $icon='ph-factory';
                        $cat_desc = 'Die einzigartige poröse Struktur erzeugt maximale biologische Leistung in besonders kleinem Volumen – ideal für Industrie, Aquakultur und Großanlagen.';
                    }
                ?>
                    <a class="category-card" href="/produkte?category=<?php echo htmlspecialchars($slug); ?>" style="border: none; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border-radius: 16px; padding: 2.5rem 1.5rem; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 1rem; background: #fff; text-decoration: none;">
                        <div class="category-icon" style="font-size: 3rem; color: var(--brand, #16a34a); margin-bottom: 0.5rem;"><i class="ph <?php echo $icon; ?>"></i></div>
                        <h3 style="margin: 0; font-size: 1.2rem; color: #0f172a;"><?php echo htmlspecialchars($category['name']); ?></h3>
                        <?php if ($cat_desc): ?>
                            <p style="color: #475569; font-size: 0.95rem; line-height: 1.5; margin: 0; flex: 1;"><?php echo $cat_desc; ?></p>
                        <?php endif; ?>
                        <span class="btn btn-outline" style="margin-top: 1rem; border-radius: 9999px; width: 100%;">Entdecken</span>
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
                <h2 class="section-title">Ausgewählte Biohome Produkte</h2>
                <p class="section-subtitle">Unsere beliebtesten Filtermedien, sofort verfügbar im Produktkatalog.</p>
            </div>
            <div class="section-actions">
                <a class="btn btn-outline" href="/produkte">Alle Produkte</a>
            </div>
        </div>
        <?php if (!empty($featured_products)): ?>
            <div class="product-grid">
                <?php foreach ($featured_products as $product): ?>
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
                            <p class="product-desc" style="flex: 1;"><?php 
                                $desc = strip_tags($product['description'] ?? '');
                                echo htmlspecialchars(mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . '...' : $desc); 
                            ?></p>
                            <a class="btn btn-primary btn-block" href="/produkt/<?php echo (int) $product['id']; ?>" style="border-radius: 9999px; width: 100%; text-align: center; margin-top: auto;">Details ansehen</a>
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
