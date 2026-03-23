<?php
require_once __DIR__ . '/../public/index.php';

$db = \Core\Model::getDB();

echo "--- cms_pages slugs ---\n";
$stmt = $db->query('SELECT slug, title FROM cms_pages');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['slug'] . ": " . $row['title'] . "\n";
}

echo "\n--- pages slugs ---\n";
$stmt = $db->query('SELECT slug, title FROM pages');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['slug'] . ": " . $row['title'] . "\n";
}
