<?php
$page = $page ?? ['title' => '', 'content' => ''];
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Startseite</a>
            <?php if (!empty($page['title'])): ?>
                / <?php echo e($page['title']); ?>
            <?php endif; ?>
        </div>
        <h1 class="page-title"><?php echo e($page['title'] ?? ''); ?></h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="rich-text">
            <?php echo $page['content'] ?? ''; ?>
        </div>
    </div>
</section>
