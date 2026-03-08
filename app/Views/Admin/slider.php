<?php if($action === 'list'): ?>
            <div class="header"><h1>Slider</h1><a href="/admin/slider?action=edit" class="btn btn-primary">+ Neuer Slide</a></div>
            <div class="card">
                <table>
                    <thead><tr><th>Bild</th><th>Inhalt</th><th>Pos.</th><th align="right">Aktion</th></tr></thead>
                    <tbody>
                        <?php foreach($db->query("SELECT * FROM slides ORDER BY position ASC") as $row): ?>
                        <tr>
                            <td>
                                <?php if($row['image_url']): ?>
                                    <img src="../<?php echo htmlspecialchars($row['image_url']); ?>" style="height:60px; object-fit:cover; border-radius:4px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <span style="color:#64748b;"><?php echo htmlspecialchars($row['subtitle']); ?></span>
                            </td>
                            <td><?php echo $row['position']; ?></td>
                            <td align="right">
                                <a href="/admin/slider?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm" style="background:#e2e8f0;">Edit</a>
                                <a href="/admin/slider?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Löschen?');">X</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif($action === 'edit'): ?>
            <div class="header"><h1>Slide bearbeiten</h1><a href="/admin/slider" class="btn" style="background:#e2e8f0;">Zurück</a></div>
            <div class="card" style="max-width:700px;">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php if($slide): ?><input type="hidden" name="id" value="<?php echo $slide['id']; ?>"><?php endif; ?>
                        
                        <div class="form-group" style="background:#f8fafc; padding:15px; border:1px solid #e2e8f0;">
                            <label>Hintergrundbild</label>
                            <?php if(!empty($slide['image_url'])): ?>
                                <img src="../<?php echo htmlspecialchars($slide['image_url']); ?>" style="height:100px; display:block; margin-bottom:10px; border:1px solid #ddd;">
                                <input type="hidden" name="image_url_current" value="<?php echo htmlspecialchars($slide['image_url']); ?>">
                            <?php endif; ?>
                            <input type="file" name="image_upload" accept="image/*">
                        </div>
                        
                        <div class="form-group"><label>Titel</label><input type="text" name="title" value="<?php echo htmlspecialchars($slide['title']??''); ?>" required></div>
                        <div class="form-group"><label>Untertitel</label><input type="text" name="subtitle" value="<?php echo htmlspecialchars($slide['subtitle']??''); ?>"></div>
                        
                        <div style="display:flex; gap:20px;">
                            <div class="form-group" style="flex:1;"><label>Button Text</label><input type="text" name="btn_text" value="<?php echo htmlspecialchars($slide['btn_text']??''); ?>"></div>
                            <div class="form-group" style="flex:1;"><label>Button Link</label><input type="text" name="btn_link" value="<?php echo htmlspecialchars($slide['btn_link']??''); ?>"></div>
                        </div>
                        
                        <div class="form-group"><label>Position</label><input type="number" name="position" value="<?php echo $slide['position']??1; ?>" style="width:100px;"></div>
                        
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
