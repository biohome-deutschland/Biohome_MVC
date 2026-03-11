<?php
// update_legal.php
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
    die("DB Connection failed: " . $e->getMessage());
}

$pages = ['agb', 'impressum'];

foreach ($pages as $slug) {
    $htmlFile = "/var/www/html/Biohome_New_App/live_{$slug}.html";
    if (!file_exists($htmlFile)) {
        echo "File not found: $htmlFile\n";
        continue;
    }

    $content = file_get_contents($htmlFile);

    if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $content, $matches)) {
        $html = trim($matches[1]);
        $html = preg_replace('/<header class="site-header">.*?<\/header>/is', '', $html);

        $stmt = $pdo->prepare("UPDATE cms_pages SET content = :content WHERE slug = :slug");
        $stmt->execute(['content' => $html, 'slug' => $slug]);

        echo "Updated cms_pages table with raw HTML for {$slug}.\n";
    } else {
        echo "Could not find <main> tag for {$slug}.\n";
    }
}
?>
