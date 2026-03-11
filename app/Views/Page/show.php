<?php 
$page_title = $page['title'] ?? 'Seite';
$page_content = $page['content'] ?? '<p>Inhalt folgt.</p>';
?>
<div class="container" style="padding: 40px 15px; max-width: 900px; margin: 0 auto;">
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" style="font-size: 0.85rem; color: #64748b; margin-bottom: 20px;">
        <ol style="list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap;">
            <li style="display: inline;"><a href="/" style="color: #64748b; text-decoration: none;">Startseite</a></li>
            <li style="display: inline; margin: 0 8px;">/</li>
            <li style="display: inline; color: #94a3b8;" aria-current="page"><?php echo htmlspecialchars($page_title); ?></li>
        </ol>
    </nav>
    
    <!-- Page Title -->
    <h1 style="font-size: 2.2rem; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 40px;">
        <?php echo htmlspecialchars($page_title); ?>
    </h1>

    <!-- Page Content -->
    <article class="typography">
        <?php echo $page_content; ?>
    </article>
</div>
