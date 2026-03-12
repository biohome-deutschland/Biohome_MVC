<?php
// Biohome_New_App/update_wissenschaft.php

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
<div class="science-content-wrapper" style="font-family: 'Outfit', sans-serif; color: #333; line-height: 1.7;"><!-- INTRO -->
<div style="text-align: center; margin-bottom: 50px; max-width: 900px; margin-left: auto; margin-right: auto;">
<h1 style="color: #0f172a; font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">Die Wissenschaft der <span style="color: #16a34a;">biologischen Pr&auml;zision</span></h1>
<p style="font-size: 1.1rem; color: #4b5563;">Biohome ist mehr als nur ein Tr&auml;germaterial. Es ist ein wissenschaftlich validiertes System zur Nachbildung des nat&uuml;rlichen Stickstoffkreislaufs &ndash; best&auml;tigt durch industrielle H&auml;rtetests.</p>
</div>
<!-- INHALTSVERZEICHNIS -->
<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 60px;"><strong style="display: block; margin-bottom: 10px; color: #16a34a; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px;">Themen&uuml;bersicht</strong>
<ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
<li><a href="#material" style="text-decoration: none; color: #333; font-weight: 500; border-bottom: 1px solid #ddd;">1. Struktur &amp; Poren</a></li>
<li><a href="#denitrifikation" style="text-decoration: none; color: #333; font-weight: 500; border-bottom: 1px solid #ddd;">2. Stickstoffkreislauf</a></li>
<li><a href="#studie" style="text-decoration: none; color: #333; font-weight: 500; border-bottom: 1px solid #ddd;">3. Studie &amp; Diagramme</a></li>
<li><a href="#chemie" style="text-decoration: none; color: #333; font-weight: 500; border-bottom: 1px solid #ddd;">4. Chemische Filterung</a></li>
<li><a href="#anordnung" style="text-decoration: none; color: #333; font-weight: 500; border-bottom: 1px solid #ddd;">5. Filter-Aufbau</a></li>
</ul>
</div>
<!-- 1. MATERIALWISSENSCHAFT -->
<section id="material" style="margin-bottom: 80px;">
<h2 style="color: #0f172a; border-left: 5px solid #16a34a; padding-left: 15px; margin-bottom: 30px;">1. Einzigartige Herstellung &amp; Struktur</h2>
<p>Biohome wird aus hochwertigem Sand und recyceltem Glas in einem speziellen Sinterprozess hergestellt. Anders als Keramik (Ton) entsteht hier eine echte <strong>3D-Netzwerkstruktur</strong>.</p>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
<div style="background: #f0fdf4; padding: 20px; border-radius: 8px; border: 1px solid #bbf7d0;">
<h4 style="color: #16a34a; margin-top: 0;">Makro-Poren</h4>
<p style="font-size: 0.95rem; margin-bottom: 0;">Sorgen f&uuml;r schnellen Wasserdurchfluss und verhindern Verstopfung ("Clogging").</p>
</div>
<div style="background: #f0fdf4; padding: 20px; border-radius: 8px; border: 1px solid #bbf7d0;">
<h4 style="color: #16a34a; margin-top: 0;">Meso-Poren</h4>
<p style="font-size: 0.95rem; margin-bottom: 0;">Transportieren Wasser durch Kapillarkraft tief ins Innere.</p>
</div>
<div style="background: #f0fdf4; padding: 20px; border-radius: 8px; border: 1px solid #bbf7d0;">
<h4 style="color: #16a34a; margin-top: 0;">Mikro-Poren</h4>
<p style="font-size: 0.95rem; margin-bottom: 0;">Sauerstoffarme Zonen im Kern &ndash; der Lebensraum f&uuml;r anaerobe Bakterien.</p>
</div>
</div>
</section>
<!-- 2. DER STICKSTOFFKREISLAUF -->
<section id="denitrifikation" style="margin-bottom: 80px;">
<h2 style="color: #0f172a; border-left: 5px solid #16a34a; padding-left: 15px; margin-bottom: 30px;">2. Der vollst&auml;ndige Stickstoffkreislauf</h2>
<p>Die meisten Filtermedien k&ouml;nnen nur Nitrifikation (aerob). Biohome schlie&szlig;t den Kreislauf.</p>
<div style="text-align: center; margin: 30px 0;"><!-- Hier dein bestehendes Bild einfügen --> <img style="max-width: 100%; height: auto; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);" src="assets/images/InfoBiohomeStruktur.png" alt="Grafik: Wirkungsweise von Biohome"></div>
<ul style="list-style: none; padding: 0;">
<li style="margin-bottom: 1rem; padding: 15px; border-left: 4px solid #3b82f6; background: #eff6ff;"><strong>Phase 1: Aerobe Zone (Au&szlig;en)</strong><br>Sauerstoffreiches Wasser. Bakterien wandeln Ammonium (NH4) und Nitrit (NO2) in Nitrat (NO3) um.</li>
<li style="margin-bottom: 1rem; padding: 15px; border-left: 4px solid #ef4444; background: #fef2f2;"><strong>Phase 2: Anaerobe Zone (Innen)</strong><br>Sauerstoffarm. Bakterien "knacken" das Nitrat-Molek&uuml;l (NO3), um Sauerstoff zu gewinnen. &Uuml;brig bleibt harmloser Stickstoff (N2), der entweicht.</li>
</ul>
</section>
<!-- 3. STUDIE ATHEN -->
<section id="studie" style="margin-bottom: 80px;">
<h2 style="color: #0f172a; border-left: 5px solid #16a34a; padding-left: 15px; margin-bottom: 30px;">3. Wissenschaftliche Validierung (Studie Athen)</h2>
<p>In einer Pilotstudie der <strong>National Technical University of Athens (NTUA)</strong> wurde Biohome Ultimate Marine unter extremsten Bedingungen getestet, um die Grenzen der biologischen Filterung auszuloten.</p>
<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
<h3 style="margin-top: 0; color: #16a34a;">Das Extrem-Szenario</h3>
<p>Ein Biofilm-Reaktor wurde mit Industrieabwasser beschickt. Die Parameter waren toxisch f&uuml;r normales Leben:</p>
<ul style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 30px;">
<li style="background: #f1f5f9; padding: 5px 10px; border-radius: 4px;">pH-Wert: <strong>3.0 (Sauer)</strong></li>
<li style="background: #f1f5f9; padding: 5px 10px; border-radius: 4px;">Salz: <strong>10% NaCl</strong></li>
<li style="background: #f1f5f9; padding: 5px 10px; border-radius: 4px;">Nitrat: <strong>5.750 mg/L</strong></li>
<li style="background: #f1f5f9; padding: 5px 10px; border-radius: 4px;">Metalle: <strong>Cu, Zn, Ni</strong></li>
</ul>
<h4 style="color: #0f172a;">Ergebnis A: Vollst&auml;ndiger Nitratabbau</h4>
<p>Die Studie zeigte, dass Biohome trotz der toxischen Umgebung eine robuste Bakterienpopulation st&uuml;tzte, die Nitrat exponentiell abbaute.</p>
<!-- SVG DIAGRAMM: NITRAT -->
<div style="margin: 30px 0; border: 1px solid #eee; padding: 20px; border-radius: 8px;">
<h5 style="text-align: center; margin-top: 0; margin-bottom: 20px;">Nitrat-Konzentration (mg/L) &uuml;ber Zeit</h5>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 250" width="100%" height="250">
    <style>
        .grid { stroke: #e2e8f0; stroke-width: 1; }
        .axis { stroke: #94a3b8; stroke-width: 2; }
        .label { fill: #475569; font-size: 12px; font-family: sans-serif; }
        .line { fill: none; stroke: #ef4444; stroke-width: 4; stroke-linecap: round; stroke-linejoin: round; }
        .point { fill: #ef4444; }
    </style>
    <line x1="40" y1="20" x2="580" y2="20" class="grid" stroke-dasharray="4" />
    <line x1="40" y1="120" x2="580" y2="120" class="grid" stroke-dasharray="4" />
    <line x1="40" y1="220" x2="580" y2="220" class="grid" />
    <text x="30" y="24" class="label" text-anchor="end">6000</text>
    <text x="30" y="124" class="label" text-anchor="end">3000</text>
    <text x="30" y="224" class="label" text-anchor="end">0</text>
    <text x="40" y="240" class="label" text-anchor="middle">0h</text>
    <text x="220" y="240" class="label" text-anchor="middle">2h</text>
    <text x="400" y="240" class="label" text-anchor="middle">4h</text>
    <text x="580" y="240" class="label" text-anchor="middle">6h</text>
    <path d="M40,28 C150,150 300,200 580,220" class="line" />
    <circle cx="40" cy="28" r="5" class="point" />
    <circle cx="580" cy="220" r="5" class="point" />
    <rect x="480" y="30" width="12" height="12" fill="#ef4444" rx="2" />
    <text x="500" y="40" class="label">Nitrat (NO3)</text>
</svg>
<p style="font-size: 0.8rem; text-align: center; color: #666; margin-top: 10px;">Adaptiert aus NTUA Studie: Reduktion von ~5750mg/L auf ~0mg/L in 6 Stunden.</p>
</div>
<h4 style="color: #0f172a;">Ergebnis B: Entfernung von Schwermetallen</h4>
<p>In den anaeroben Zonen wurde beobachtet, dass Bakterien Sulfate zu Sulfiden reduzieren. Diese reagieren mit gel&ouml;sten Metallen zu unl&ouml;slichen Metallsulfiden, die im Filter gebunden werden ("Biopr&auml;zipitation").</p>
<!-- SVG DIAGRAMM: METALLE -->
<div style="margin: 30px 0; border: 1px solid #eee; padding: 20px; border-radius: 8px;">
<h5 style="text-align: center; margin-top: 0; margin-bottom: 20px;">Metall-Entfernung (%)</h5>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 200" width="100%" height="200">
    <style>
        .bar-bg { fill: #f1f5f9; }
        .bar-cu { fill: #d97706; }
        .bar-zn { fill: #64748b; }
        .bar-ni { fill: #10b981; }
        .label { fill: #0f172a; font-size: 14px; font-family: sans-serif; font-weight: bold; }
        .val { fill: #ffffff; font-size: 12px; font-family: sans-serif; font-weight: bold; }
        .axis { stroke: #cbd5e1; stroke-width: 2; }
    </style>
    <rect x="100" y="30" width="400" height="30" class="bar-bg" rx="4" />
    <rect x="100" y="80" width="400" height="30" class="bar-bg" rx="4" />
    <rect x="100" y="130" width="400" height="30" class="bar-bg" rx="4" />
    <rect x="100" y="30" width="320" height="30" class="bar-cu" rx="4" />
    <rect x="100" y="80" width="280" height="30" class="bar-zn" rx="4" />
    <rect x="100" y="130" width="240" height="30" class="bar-ni" rx="4" />
    <text x="90" y="50" class="label" text-anchor="end">Kupfer</text>
    <text x="90" y="100" class="label" text-anchor="end">Zink</text>
    <text x="90" y="150" class="label" text-anchor="end">Nickel</text>
    <text x="410" y="50" class="val" text-anchor="end">-80%</text>
    <text x="370" y="100" class="val" text-anchor="end">-70%</text>
    <text x="330" y="150" class="val" text-anchor="end">-60%</text>
    <line x1="100" y1="20" x2="100" y2="170" class="axis" />
</svg>
<p style="font-size: 0.8rem; text-align: center; color: #666; margin-top: 10px;">Signifikante Reduktion gel&ouml;ster Metalle durch Biosorption und Ausf&auml;llung.</p>
</div>
</div>
</section>
<!-- 4. CHEMISCHE FILTERUNG -->
<section id="chemie" style="margin-bottom: 80px;">
<h2 style="color: #0f172a; border-left: 5px solid #16a34a; padding-left: 15px; margin-bottom: 30px;">4. Optionale Chemische Filterung (Do's &amp; Don'ts)</h2>
<p>Biohome bildet das biologische R&uuml;ckgrat. Manchmal ist jedoch eine chemische Erg&auml;nzung sinnvoll. Hier ist entscheidend, <strong>was</strong> Sie kombinieren.</p>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px;">
<h4 style="color: #16a34a; margin-top: 0;">✅ Empfohlen</h4>
<ul style="margin-bottom: 0;">
<li style="margin-bottom: 10px;"><strong>Aktivkohle:</strong> Entfernt Gelbstoffe, Nesselgifte und Medikamentenreste. Sie arbeitet rein adsorptiv und st&ouml;rt die Bakterien nicht.</li>
<li><strong>Phosphat-Adsorber (GFO):</strong> Eisenoxid-Basis. Da Biohome Nitrat (NO3) abbaut, aber Phosphat (PO4) nur bindet, kann ein Adsorber helfen, das Verh&auml;ltnis (Redfield-Ratio) perfekt zu halten.</li>
</ul>
</div>
<div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px;">
<h4 style="color: #dc2626; margin-top: 0;">❌ Bitte vermeiden</h4>
<ul style="margin-bottom: 0;">
<li style="margin-bottom: 10px;"><strong>Zeolith:</strong> Bindet Ammonium, <em>bevor</em> es die Bakterien erreicht. Das "hungert" Ihren Biofilter aus und verhindert eine stabile Biologie.</li>
<li><strong>Synthetische Harze (z.B. Purigen):</strong> Entfernen organische Vorstufen. In einem eingefahrenen Biohome-System kontraproduktiv, da sie den Bakterien die Nahrungsgrundlage entziehen.</li>
</ul>
</div>
</div>
</section>
<!-- 5. ANORDNUNG -->
<section id="anordnung" style="margin-bottom: 60px;">
<h2 style="color: #0f172a; border-left: 5px solid #16a34a; padding-left: 15px; margin-bottom: 30px;">5. Die richtige Filter-Anordnung</h2>
<p>Ein h&auml;ufiger Fehler ist die falsche Reihenfolge. Biohome muss gesch&uuml;tzt liegen.</p>
<div style="display: flex; gap: 20px; align-items: center; background: #fff; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
<div style="flex: 1; text-align: center;"><img style="max-width: 100%; border-radius: 4px;" src="assets/images/aussenfilter-prinzipieller-aufbau.png" alt="Filteraufbau"></div>
<div style="flex: 2;">
<ol style="margin: 0; padding-left: 20px;">
<li style="margin-bottom: 10px;"><strong>Mechanik (Vorfilter):</strong> Grobe Schw&auml;mme -&gt; Mittlere Schw&auml;mme. Schmutz muss hier gestoppt werden.</li>
<li style="margin-bottom: 10px;"><strong>Biologie (Hauptkammer):</strong> Biohome. Hier flie&szlig;t nur klares Wasser.</li>
<li style="color: #b91c1c;"><strong>Kein Vlies am Ende!</strong> Platzieren Sie kein Feinfiltervlies <em>nach</em> dem Biohome. Es verstopft schnell, bremst den Fluss und gef&auml;hrdet die Sauerstoffversorgung.</li>
</ol>
</div>
</div>
</section>
</div>
HTML;

$stmt = $pdo->prepare("UPDATE cms_pages SET content = :content WHERE slug = 'wissenschaft'");
$stmt->execute(['content' => $html]);

echo "Updated cms_pages table with correct raw HTML for wissenschaft.\n";

?>
