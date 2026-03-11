<?php
// Biohome_New_App/update_datenschutz.php

$host = 'db';
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

$htmlFile = '/var/www/html/Biohome_New_App/live_datenschutz.html';
if (!file_exists($htmlFile)) {
    die("File not found: $htmlFile\n");
}

$content = file_get_contents($htmlFile);

// Extract content exactly within <main class="site-main" id="content"> ... </main>
if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $content, $matches)) {
    $html = trim($matches[1]);
    
    // Also remove the '<header class="site-header">...</header>' if it's there
    $html = preg_replace('/<header class="site-header">.*?<\/header>/is', '', $html);

    // Update cms_pages table
    $stmt = $pdo->prepare("UPDATE cms_pages SET content = :content WHERE slug = 'datenschutz'");
    $stmt->execute(['content' => $html]);

    echo "Updated cms_pages table with correct raw HTML for datenschutz.\n";
} else {
    echo "Could not find <main> tag in live_datenschutz.html.\n";
}
?>
