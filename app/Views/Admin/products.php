<?php if($action === 'list'): ?>
            <div class="header"><h1>Produkte</h1><a href="/admin/products?action=edit" class="btn btn-primary">+ Neu</a></div>
            <?php if($msg): ?><div style="background:#dcfce7; padding:15px; margin-bottom:20px;"><?php echo $msg; ?></div><?php endif; ?>
            <div class="card">
                <table>
                    <thead><tr><th width="60">Bild</th><th>Titel</th><th>Kategorien</th><th align="right">Aktion</th></tr></thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR ', ') as cnames FROM products p LEFT JOIN product_categories pc ON p.id=pc.product_id LEFT JOIN categories c ON pc.category_id=c.id GROUP BY p.id ORDER BY p.id DESC";
                        foreach($db->query($sql) as $row): 
                        ?>
                        <tr>
                            <td>
                                <?php if($row['image_url']): ?>
                                <img src="../<?php echo htmlspecialchars($row['image_url']); ?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td style="color:#64748b; font-size:0.9rem;"><?php echo htmlspecialchars($row['cnames']??''); ?></td>
                            <td align="right">
                                <a href="/admin/products?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm" style="background:#e2e8f0;">Edit</a>
                                <a href="/admin/products?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Löschen?');">X</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif($action === 'edit'): ?>
            <div class="header"><h1>Produkt bearbeiten</h1><a href="/admin/products" class="btn" style="background:#e2e8f0;">Zurück</a></div>
            <?php if($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; margin-bottom:20px;"><?php echo $error; ?></div><?php endif; ?>
            <?php if($tinymce_notice): ?><div style="background:#fff7ed; color:#9a3412; padding:15px; margin-bottom:20px; border:1px solid #fed7aa;"><?php echo htmlspecialchars($tinymce_notice); ?></div><?php endif; ?>
            
            <div class="card" style="max-width:800px;">
                <div class="card-body">
                    <!-- WICHTIG: enctype für Datei-Upload -->
                    <form method="post" enctype="multipart/form-data">
                        <?php if($product): ?><input type="hidden" name="id" value="<?php echo $product['id']; ?>"><?php endif; ?>
                        
                        <div class="form-group">
                            <label>Titel</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']??''); ?>" required>
                        </div>

                        <!-- BILD UPLOAD BEREICH -->
                        <div class="form-group" style="background:#f8fafc; padding:15px; border:1px solid #e2e8f0; border-radius:6px;">
                            <label>Produktbild</label>
                            
                            <!-- 1. Aktuelles Bild anzeigen -->
                            <?php if(!empty($product['image_url'])): ?>
                                <div style="margin-bottom:10px;">
                                    <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" style="height:100px; border-radius:4px; border:1px solid #ddd;">
                                    <div style="font-size:0.8rem; color:#64748b;">Aktuell: <?php echo htmlspecialchars($product['image_url']); ?></div>
                                    <input type="hidden" name="image_url_current" value="<?php echo htmlspecialchars($product['image_url']); ?>">
                                </div>
                            <?php endif; ?>

                            <!-- 2. Upload Feld -->
                            <div style="margin-bottom:10px;">
                                <strong>Neues Bild hochladen:</strong><br>
                                <input type="file" name="image_upload" accept="image/*" style="background:white; padding:5px;">
                            </div>
                            
                            <!-- 3. Fallback Textfeld -->
                            <details>
                                <summary style="font-size:0.8rem; cursor:pointer; color:#64748b;">Oder Pfad manuell eingeben (für Profis)</summary>
                                <input type="text" name="image_url_manual" placeholder="assets/images/..." style="margin-top:5px;">
                            </details>
                        </div>

                        <div class="form-group">
                            <label>Kategorien</label>
                            <div class="checkbox-grid">
                                <?php foreach($allCats as $cat): ?>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="categories[]" value="<?php echo $cat['id']; ?>" <?php echo in_array($cat['id'], $activeCats)?'checked':''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Beschreibung</label>
                            <textarea name="description"><?php echo htmlspecialchars($product['description']??''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
