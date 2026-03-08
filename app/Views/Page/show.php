<?php 
$page_title = $page['title'] ?? 'Seite';
$page_content = $page['content'] ?? '<p>Inhalt folgt.</p>';
?>
<div class="hero" style="padding:60px 0; margin-bottom:40px; background:#0f172a;">
    <div class="container">
        <h1 style="font-size:3rem; margin:0; color:white; text-align:center;"><?php echo htmlspecialchars($page_title); ?></h1>
    </div>
</div>
<div class="container" style="padding-bottom:60px; max-width:900px;">
    <article class="typography">
        <?php echo $page_content; ?>
    </article>
</div>
