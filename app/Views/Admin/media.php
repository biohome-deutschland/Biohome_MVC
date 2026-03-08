<div class="header">
            <h1>Medienverwaltung</h1>
            <span style="font-size:0.9rem; color:#64748b;">Ordner: /assets/images/</span>
        </div>

        <?php if($folderError): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;">
                <?php echo $folderError; ?>
            </div>
        <?php endif; ?>

        <?php if($msg): ?>
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #bbf7d0;">
                <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- UPLOAD KARTE -->
        <div class="card" style="padding: 30px; text-align: center; border: 2px dashed #cbd5e1;">
            <h3 style="margin-top:0;">Bilder hochladen</h3>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="file_upload" id="file_upload" style="display:none;" onchange="this.form.submit()">
                <label for="file_upload" class="btn btn-primary">
                    Datei auswählen
                </label>
                <p style="margin-top:10px; font-size:0.85rem; color:#64748b;">
                    Dateien werden direkt in <code>/assets/images/</code> gespeichert.
                </p>
            </form>
        </div>

        <!-- BILDER LISTE -->
        <?php if(empty($files)): ?>
            <p style="text-align:center; color:#94a3b8; margin-top:40px;">
                Der Ordner <code>/assets/images/</code> ist leer oder wurde nicht gefunden.
            </p>
        <?php else: ?>
            <div class="media-grid">
                <?php foreach($files as $filePath): 
                    $fileName = basename($filePath);
                    // Der Pfad für das <img> Tag (geht eins hoch aus admin raus)
                    $previewPath = '../assets/images/' . $fileName;
                    // Der Pfad für die Datenbank (relativ zum Root)
                    $dbPath = 'assets/images/' . $fileName;
                    
                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                ?>
                <div class="media-item">
                    <div class="media-preview">
                        <?php if($isImage): ?>
                            <img src="<?php echo $previewPath; ?>" alt="<?php echo $fileName; ?>" loading="lazy">
                        <?php else: ?>
                            <div class="file-icon"><?php echo strtoupper($ext); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="media-details">
                        <span class="media-name" title="<?php echo $fileName; ?>"><?php echo $fileName; ?></span>
                        <div class="btn-group">
                            <button type="button" class="action-btn btn-copy" onclick="copyPath('<?php echo $dbPath; ?>')">
                                Pfad kopieren
                            </button>
                            <a href="/admin/media?delete=<?php echo $fileName; ?>" class="action-btn btn-del" onclick="return confirm('Datei wirklich löschen?');">
                                Löschen
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
