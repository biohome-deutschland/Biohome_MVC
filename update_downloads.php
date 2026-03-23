<?php
// Biohome_New_App/update_downloads.php

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
    <div class="container">
        <p class="eyebrow">Ressourcen</p>
        <h1 class="page-title">Download-Center</h1>
        <p class="page-subtitle">Wissenschaftliche Studien, Produktbroschüren und technische Datenblätter für Experten und Fachhändler.</p>
    </div>
</section>

<section class="section" style="padding-bottom: 5rem; background: #f8fafc;">
    <div class="container" style="max-width: 1000px;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            
            <!-- Kategorie 1: Wissenschaft & Studien -->
            <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #3b82f6;">
                <h3 style="color: #0f172a; font-size: 1.3rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-flask" style="color: #3b82f6; font-size: 1.5rem;"></i> Wissenschaft &amp; Studien
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">NTUA Studie - Extremfiltration (Athen)</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Pilotstudie zum Einsatz von Biohome in Industrieabwasser (pH 3.0, 10% NaCl, Schwermetalle).</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #3b82f6; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (1.2 MB)</a>
                        </div>
                    </li>
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">Vollständiger Stickstoffkreislauf</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Analyse der Denitrifikationsleistung in den anaeroben Zonen von Sinterglas-Medien.</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #3b82f6; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (0.8 MB)</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Kategorie 2: Technische Daten -->
            <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #10b981;">
                <h3 style="color: #0f172a; font-size: 1.3rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-table" style="color: #10b981; font-size: 1.5rem;"></i> Technische Datenblätter (TDS)
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-text" style="font-size: 2rem; color: #475569;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">TDS: Biohome Standard & Ultimate</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Spezifische Oberfläche, Packdichte, pH-Inertheit und Dimensionen.</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #10b981; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (250 KB)</a>
                        </div>
                    </li>
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-text" style="font-size: 2rem; color: #475569;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">TDS: Biohome Maxi & SuperGravel</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Technische Spezifikationen für große Riesel- und Kammerfilter.</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #10b981; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (260 KB)</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Kategorie 3: Broschüren & Anleitungen -->
            <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #f59e0b;">
                <h3 style="color: #0f172a; font-size: 1.3rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="ph ph-book-open-text" style="color: #f59e0b; font-size: 1.5rem;"></i> Broschüren &amp; Anleitungen
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">Produktkatalog 2026</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Übersicht aller verfügbaren Biohome Medien inkl. Bestückungsempfehlungen.</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #f59e0b; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (5.5 MB)</a>
                        </div>
                    </li>
                    <li style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display: flex; align-items: start; gap: 1rem; transition: background 0.2s;">
                        <i class="ph ph-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: #0f172a;">Anleitung: Richtiger Filteraufbau</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;">Schritt-für-Schritt Anleitung zur Kombination von mechanischer und biologischer Filterung.</p>
                            <a href="#" style="font-size: 0.9rem; font-weight: 500; color: #f59e0b; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;"><i class="ph ph-download-simple"></i> Download PDF (1.1 MB)</a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>
HTML;

try {
    // Check if page exists
    $stmt = $pdo->prepare("SELECT id FROM cms_pages WHERE slug = 'downloads'");
    $stmt->execute();
    $page = $stmt->fetch();

    if ($page) {
        $stmt = $pdo->prepare("UPDATE cms_pages SET title = 'Downloads', content = :content, updated_at = NOW() WHERE slug = 'downloads'");
        $stmt->execute(['content' => $html]);
        echo "Updated cms_pages table with Downloads content.\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO cms_pages (title, slug, content, created_at, updated_at) VALUES ('Downloads', 'downloads', :content, NOW(), NOW())");
        $stmt->execute(['content' => $html]);
        echo "Inserted Downloads page into cms_pages table.\n";
    }
} catch (\PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
