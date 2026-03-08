<div class="header">
            <h1>Einstellungen</h1>
            <a href="/admin/menus" class="btn" style="background:#e2e8f0; color:#334155;">Navigation bearbeiten</a>
        </div>

        <?php if ($msg): ?>
            <div style="background:#dcfce7; padding:15px; margin-bottom:20px; border-radius:5px; color:#166534; border:1px solid #bbf7d0;">
                <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>

        <div class="card" style="max-width:900px;">
            <div class="card-body">
                <form method="post">
                    <h3>Allgemein</h3>
                    <div class="form-group">
                        <label>Name der Webseite</label>
                        <input type="text" name="site_name" value="<?php echo htmlspecialchars($site_name); ?>">
                    </div>
                    <div class="form-group">
                        <label>Untertitel / Claim</label>
                        <input type="text" name="site_tagline" value="<?php echo htmlspecialchars($site_tagline); ?>" placeholder="Kurzbeschreibung fuer den Footer">
                    </div>
                    <div class="form-group">
                        <label>Admin E-Mail</label>
                        <input type="text" name="admin_email" value="<?php echo htmlspecialchars($admin_email); ?>">
                    </div>

                    <hr style="border:0; border-top:1px solid #e2e8f0; margin:30px 0;">

                    <h3>Kontaktinformationen</h3>
                    <div class="form-group">
                        <label>Kontakt E-Mail</label>
                        <input type="text" name="company_email" value="<?php echo htmlspecialchars($company_email); ?>" placeholder="info@biohome-filter.de">
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="text" name="company_phone" value="<?php echo htmlspecialchars($company_phone); ?>" placeholder="+49 123 456 789">
                    </div>
                    <div class="form-group">
                        <label>Adresse</label>
                        <textarea name="company_address" rows="3"><?php echo htmlspecialchars($company_address); ?></textarea>
                    </div>

                    <hr style="border:0; border-top:1px solid #e2e8f0; margin:30px 0;">

                    <h3>Footer</h3>
                    <div class="form-group">
                        <label>Footer Text (untere Zeile)</label>
                        <input type="text" name="footer_text" value="<?php echo htmlspecialchars($footer_text); ?>" placeholder="{year} Biohome. Alle Rechte vorbehalten.">
                        <small style="color:#64748b; display:block; margin-top:6px;">Platzhalter: {year}</small>
                    </div>
                    <div class="form-group">
                        <label>Layout</label>
                        <select name="footer_layout">
                            <option value="standard" <?php echo $footer_layout === 'standard' ? 'selected' : ''; ?>>Standard</option>
                            <option value="compact" <?php echo $footer_layout === 'compact' ? 'selected' : ''; ?>>Kompakt</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ausrichtung</label>
                        <select name="footer_align">
                            <option value="left" <?php echo $footer_align === 'left' ? 'selected' : ''; ?>>Linksbuendig</option>
                            <option value="center" <?php echo $footer_align === 'center' ? 'selected' : ''; ?>>Zentriert</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Abstand</label>
                        <select name="footer_spacing">
                            <option value="normal" <?php echo $footer_spacing === 'normal' ? 'selected' : ''; ?>>Normal</option>
                            <option value="tight" <?php echo $footer_spacing === 'tight' ? 'selected' : ''; ?>>Kompakt</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Footer Bereiche</label>
                        <div class="checkbox-grid">
                            <label class="checkbox-label">
                                <input type="checkbox" name="footer_show_products" value="1" <?php echo $footer_show_products === '1' ? 'checked' : ''; ?>>
                                Produkte
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="footer_show_navigation" value="1" <?php echo $footer_show_navigation === '1' ? 'checked' : ''; ?>>
                                Rechtliches
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="footer_show_contact" value="1" <?php echo $footer_show_contact === '1' ? 'checked' : ''; ?>>
                                Kontakt
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="footer_show_social" value="1" <?php echo $footer_show_social === '1' ? 'checked' : ''; ?>>
                                Social Icons
                            </label>
                        </div>
                    </div>

                    <hr style="border:0; border-top:1px solid #e2e8f0; margin:30px 0;">

                    <h3>Editor</h3>
                    <div class="form-group">
                        <label>TinyMCE API Key</label>
                        <input type="text" name="tinymce_api_key" value="<?php echo htmlspecialchars($tinymce_api_key); ?>" placeholder="TinyMCE API Key">
                        <small style="color:#64748b; display:block; margin-top:6px;">Wenn leer, wird der Demo-Key verwendet.</small>
                    </div>

                    <hr style="border:0; border-top:1px solid #e2e8f0; margin:30px 0;">

                    <h3>Social Media Links</h3>
                    <p style="font-size:0.9rem; color:#64748b;">Lassen Sie ein Feld leer, um das Icon im Footer auszublenden.</p>
                    <div class="form-group">
                        <label>Facebook URL</label>
                        <input type="text" name="social_facebook" value="<?php echo htmlspecialchars($social_fb); ?>" placeholder="https://facebook.com/...">
                    </div>
                    <div class="form-group">
                        <label>YouTube URL</label>
                        <input type="text" name="social_youtube" value="<?php echo htmlspecialchars($social_yt); ?>" placeholder="https://youtube.com/...">
                    </div>
                    <div class="form-group">
                        <label>Instagram URL</label>
                        <input type="text" name="social_instagram" value="<?php echo htmlspecialchars($social_insta); ?>" placeholder="https://instagram.com/...">
                    </div>

                    <hr style="border:0; border-top:1px solid #e2e8f0; margin:30px 0;">

                    <div class="form-group">
                        <label>Aktives Theme</label>
                        <select name="active_theme">
                            <?php foreach ($themes as $theme): ?>
                                <option value="<?php echo htmlspecialchars($theme); ?>" <?php echo ($theme === $active_theme) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($theme); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </form>
            </div>
        </div>
