<?php
require_once __DIR__ . '/../public/index.php';

$db = \Core\Model::getDB();

echo "--- cms_pages FAQ content ---\n";
$stmt = $db->prepare('SELECT content FROM cms_pages WHERE slug = "faq"');
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo substr($row['content'], 0, 500) . "...\n";
} else {
    echo "Not found in cms_pages.\n";
}

echo "\n--- pages FAQ content ---\n";
$stmt = $db->prepare('SELECT content FROM pages WHERE slug = "faq"');
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo substr($row['content'], 0, 500) . "...\n";
} else {
    echo "Not found in pages.\n";
}
