<?php
// Filter Logik (wird von index.php übergeben: $data['filter'])
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