<?php
$filter = $filter ?? null;

$video_url = '';
$embed_url = '';
if ($filter) {
    $video_url = trim((string) ($filter['video_url'] ?? ''));
    if ($video_url !== '') {
        if (preg_match('~youtube\\.com/watch\\?v=([^&]+)~', $video_url, $matches) || preg_match('~youtu\\.be/([^?&]+)~', $video_url, $matches)) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('~vimeo\\.com/(\\d+)~', $video_url, $matches)) {
            $embed_url = 'https://player.vimeo.com/video/' . $matches[1];
        }
    }
}
?>

<?php if ($filter): ?>
    <section class="product-page">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Startseite</a> / <a href="?page=filtertypen">Filtertypen</a> / <?php echo e($filter['title']); ?>
            </div>
            <div class="product-layout">
                <div class="product-media">
                    <?php if (!empty($filter['image_url'])): ?>
                        <img src="<?php echo e($filter['image_url']); ?>" alt="<?php echo e($filter['title']); ?>">
                    <?php else: ?>
                        <div class="muted">Kein Bild verfuegbar</div>
                    <?php endif; ?>
                </div>
                <div class="product-details">
                    <div class="product-meta">
                        <?php if (!empty($filter['type_name'])): ?>
                            <span class="badge"><?php echo e($filter['type_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($filter['brand_name'])): ?>
                            <span class="badge"><?php echo e($filter['brand_name']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($filter['is_featured'])): ?>
                            <span class="badge badge--highlight">Highlight</span>
                        <?php endif; ?>
                    </div>
                    <h1><?php echo e($filter['title']); ?></h1>
                    <div class="rich-text">
                        <?php
                        $description = (string) ($filter['description'] ?? '');
                        if ($description !== '' && $description === strip_tags($description)) {
                            echo nl2br(e($description));
                        } else {
                            echo $description;
                        }
                        ?>
                    </div>

                    <?php if ($video_url !== ''): ?>
                        <div class="filter-video">
                            <h3>Video</h3>
                            <?php if ($embed_url !== ''): ?>
                                <iframe src="<?php echo e($embed_url); ?>" allowfullscreen loading="lazy"></iframe>
                            <?php else: ?>
                                <a href="<?php echo e($video_url); ?>" target="_blank" rel="noopener">Video ansehen</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="section">
        <div class="container">
            <div class="empty-state">
                <i class="ph ph-warning-circle"></i>
                <p class="muted">Filter nicht gefunden.</p>
            </div>
        </div>
    </section>
<?php endif; ?>
