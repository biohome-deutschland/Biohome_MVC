<div class="cat-card" style="text-align:left; padding:0; overflow:hidden; display:flex; flex-direction:column; border:1px solid #e2e8f0;">
    <div style="height:220px; background:#f8fafc; display:flex; align-items:center; justify-content:center; position:relative; border-bottom:1px solid #e2e8f0;">
        <?php if(!empty($p['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($p['image_url']); ?>" style="height:100%; width:100%; object-fit:cover;">
        <?php else: ?>
            <i class="ph ph-cube" style="font-size:4rem; color:#cbd5e1;"></i>
        <?php endif; ?>
        <?php if(isset($p['is_featured']) && $p['is_featured']): ?>
            <span style="position:absolute; top:10px; right:10px; background:#fbbf24; color:#78350f; font-size:0.7rem; font-weight:bold; padding:2px 8px; border-radius:10px;">TOP</span>
        <?php endif; ?>
    </div>
    <div style="padding:20px; flex:1; display:flex; flex-direction:column;">
        <h4 style="font-size:1.1rem; margin-bottom:10px; color:#0f172a;"><?php echo htmlspecialchars($p['title']); ?></h4>
        <a href="?product=<?php echo $p['id']; ?>" class="btn-outline" style="border:1px solid #16a34a; border-radius:6px; text-align:center; padding:8px; display:block; margin-top:auto;">Details</a>
    </div>
</div>