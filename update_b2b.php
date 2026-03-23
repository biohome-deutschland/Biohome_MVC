<?php
// Biohome_New_App/update_b2b.php

$host = 'db';
// $host = '127.0.0.1';
$db   = 'biohome_db';
$user = 'root';
$pass = 'secret';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$html = <<<HTML
<section class="page-hero">
    <div class="container" style="max-width: 900px; text-align: center;">
        <p class="eyebrow" style="color: #3b82f6;">Für Händler & Industrie</p>
        <h1 class="page-title" style="font-size: 3.5rem; color: #0f172a; margin-bottom: 24px;">Biohome für Business-Kunden</h1>
        <p class="page-subtitle" style="font-size: 1.25rem; color: #475569; max-width: 700px; margin: 0 auto;">
            Maximale biologische Leistung, extreme Haltbarkeit und geringer Wartungsaufwand – 
            Biohome ist die Wahl für anspruchsvolle Anwendungen in der Aquakultur, Industrie und dem Fachhandel.
        </p>
    </div>
</section>

<section class="section" style="padding-bottom: 5rem; background: #fff;">
    <div class="container" style="max-width: 1100px;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
            <div>
                <div style="width: 60px; height: 60px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <i class="ph ph-factory" style="font-size: 2rem; color: #3b82f6;"></i>
                </div>
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #0f172a;">Industrie & Aquakultur</h3>
                <p style="color: #475569; line-height: 1.6; margin-bottom: 1.5rem;">
                    In der industriellen Wasseraufbereitung und Groß-Aquakultur ist der ROI entscheidend. 
                    Standardmedien "verstopfen", erfordern häufige Wartung oder bauen nur aerob ab. 
                    Biohome schließt den Stickstoffkreislauf und reduziert Toxizität und Betriebskosten drastisch.
                </p>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>Vollständige Nitrifikation & Denitrifikation</span></li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>Stapeldichte für Industriefilter</span></li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>Chemisch inert & extrem formstabil</span></li>
                </ul>
            </div>
            
            <div>
                <div style="width: 60px; height: 60px; background: #f0fdf4; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <i class="ph ph-storefront" style="font-size: 2rem; color: #16a34a;"></i>
                </div>
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #0f172a;">Für den Fachhandel</h3>
                <p style="color: #475569; line-height: 1.6; margin-bottom: 1.5rem;">
                    Bieten Sie Ihren Kunden das Premium-Filtermedium, nach dem Profis verlangen. 
                    Wir beliefern Zoofachgeschäfte, Teichbauer und Aquarienbauer mit attraktiven Margen 
                    und umfassender Verkaufsunterstützung.
                </p>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>Attraktive Händler-Konditionen</span></li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>Dropshipping & Bulk-Versand möglich</span></li>
                    <li style="display: flex; align-items: center; gap: 0.5rem; color: #475569;"><i class="ph ph-check-circle" style="color: #16a34a;"></i> <span>POS-Material & Mustersets</span></li>
                </ul>
            </div>
        </div>

        <div style="background: #0f172a; border-radius: 16px; padding: 4rem; text-align: center;">
            <h2 style="color: #fff; font-size: 2.5rem; margin-bottom: 1.5rem;">Key Account Kontakt</h2>
            <p style="color: #94a3b8; font-size: 1.25rem; max-width: 600px; margin: 0 auto 3rem; line-height: 1.6;">
                Sie planen ein Großprojekt oder möchten Biohome in Ihr Sortiment aufnehmen? 
                Unser Key Account Management berät Sie gerne unverbindlich.
            </p>
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem;">
                <a href="mailto:info@biohome-filter-material.de" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2rem; background: #3b82f6; border: none;"><i class="ph ph-envelope-simple" style="margin-right: 0.5rem;"></i> E-Mail an Vertrieb</a>
                <a href="/downloads" class="btn btn-outline" style="font-size: 1.1rem; padding: 1rem 2rem; color: #fff; border-color: #334155;"><i class="ph ph-file-pdf" style="margin-right: 0.5rem;"></i> Studienergebnisse (NTUA)</a>
            </div>
        </div>

    </div>
</section>
HTML;

try {
    // Check if page exists
    $stmt = $pdo->prepare("SELECT id FROM cms_pages WHERE slug = 'b2b'");
    $stmt->execute();
    $page = $stmt->fetch();

    if ($page) {
        $stmt = $pdo->prepare("UPDATE cms_pages SET title = 'B2B Geschäftskunden', content = :content, updated_at = NOW() WHERE slug = 'b2b'");
        $stmt->execute(['content' => $html]);
        echo "Updated cms_pages table with B2B content.\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO cms_pages (title, slug, content, created_at, updated_at) VALUES ('B2B Geschäftskunden', 'b2b', :content, NOW(), NOW())");
        $stmt->execute(['content' => $html]);
        echo "Inserted B2B page into cms_pages table.\n";
    }
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
