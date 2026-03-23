<?php if ($action === 'list'): ?>
            <div class="header">
                <h1>Filter</h1>
                <a href="/admin/filters?action=edit" class="btn btn-primary">+ Neu</a>
            </div>
            <?php if ($msg): ?><div style="background:#dcfce7; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <?php if ($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

            <div class="card">
                <form method="post" action="/admin/filters?action=bulk">
                    <div style="padding:15px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; gap:10px;">
                        <select name="bulk_action" style="padding:5px; border:1px solid #cbd5e1; border-radius:4px;">
                            <option value="">Aktion wählen...</option>
                            <option value="set_online">Markierte online schalten</option>
                            <option value="set_offline">Markierte offline schalten</option>
                        </select>
                        <button type="submit" class="btn btn-sm" style="background:#e2e8f0; border:1px solid #cbd5e1; color:#334155;">Ausführen</button>
                    </div>
                <table>
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" id="selectAll"></th>
                            <th width="60">Bild</th>
                            <th>Titel</th>
                            <th>Filterart</th>
                            <th>Hersteller</th>
                            <th>Status</th>
                            <th style="text-align:right">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT f.*, t.name AS type_name, b.name AS brand_name
                                FROM filters f
                                LEFT JOIN filter_types t ON f.type_id = t.id
                                LEFT JOIN filter_brands b ON f.brand_id = b.id
                                ORDER BY f.id DESC";
                        foreach ($db->query($sql) as $row):
                        ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?php echo (int) $row['id']; ?>" class="rowCheckbox"></td>
                            <td>
                                <?php if (!empty($row['image_url'])): ?>
                                <img src="../<?php echo htmlspecialchars((string) $row['image_url'], ENT_QUOTES, 'UTF-8'); ?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars((string) $row['title'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td style="color:#64748b;"><?php echo htmlspecialchars((string) ($row['type_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td style="color:#64748b;"><?php echo htmlspecialchars((string) ($row['brand_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="/admin/filters?action=toggle_status&id=<?php echo (int) $row['id']; ?>" style="text-decoration:none;">
                                    <?php if(!isset($row['is_active']) || $row['is_active']): ?>
                                        <span style="background:#dcfce7; color:#166534; padding:2px 6px; border-radius:4px; font-size:0.8rem; display:inline-block;">Online</span>
                                    <?php else: ?>
                                        <span style="background:#fee2e2; color:#991b1b; padding:2px 6px; border-radius:4px; font-size:0.8rem; display:inline-block;">Offline</span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td align="right">
                                <a href="/admin/filter-calculator?filter_id=<?php echo (int) $row['id']; ?>" class="btn btn-sm" style="background:#dcfce7; color:#166534;">Kalkulator</a>
                                <a href="/admin/filters?action=edit&id=<?php echo (int) $row['id']; ?>" class="btn btn-sm" style="background:#e2e8f0;">Edit</a>
                                <a href="/admin/filters?action=delete&id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Loeschen?');">X</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </form>
            </div>
            <script>
                document.getElementById('selectAll')?.addEventListener('change', function(e) {
                    document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = e.target.checked);
                });
            </script>
        <?php else: ?>
            <div class="header">
                <h1><?php echo $filter ? 'Filter bearbeiten' : 'Filter anlegen'; ?></h1>
                <div style="display:flex; gap:10px; align-items:center;">
                    <?php if ($filter): ?>
                        <a href="/admin/filter-calculator?filter_id=<?php echo (int) $filter['id']; ?>" class="btn" style="background:#dcfce7; color:#166534;">Kalkulator</a>
                    <?php endif; ?>
                    <a href="/admin/filters" class="btn" style="background:#e2e8f0;">Zurueck</a>
                </div>
            </div>
            <?php if ($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <?php if ($tinymce_notice): ?><div style="background:#fff7ed; color:#9a3412; padding:15px; margin-bottom:20px; border:1px solid #fed7aa;"><?php echo htmlspecialchars($tinymce_notice, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <?php if ($msg): ?><div style="background:#dcfce7; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

            <div class="card" style="max-width:900px;">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php if ($filter): ?><input type="hidden" name="id" value="<?php echo (int) $filter['id']; ?>"><?php endif; ?>

                        <div class="form-group">
                            <label>Titel</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars((string) ($filter['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="form-group" style="background:#f8fafc; padding:15px; border:1px solid #e2e8f0; border-radius:6px;">
                            <label>Filterbild</label>
                            <?php if (!empty($filter['image_url'])): ?>
                                <div style="margin-bottom:10px;">
                                    <img src="../<?php echo htmlspecialchars((string) $filter['image_url'], ENT_QUOTES, 'UTF-8'); ?>" style="height:100px; border-radius:4px; border:1px solid #ddd;">
                                    <div style="font-size:0.8rem; color:#64748b;">Aktuell: <?php echo htmlspecialchars((string) $filter['image_url'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <input type="hidden" name="image_url_current" value="<?php echo htmlspecialchars((string) $filter['image_url'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            <?php endif; ?>

                            <div style="margin-bottom:10px;">
                                <strong>Neues Bild hochladen:</strong><br>
                                <input type="file" name="image_upload" accept="image/*" style="background:white; padding:5px;">
                            </div>
                            <details>
                                <summary style="font-size:0.8rem; cursor:pointer; color:#64748b;">Oder Pfad manuell eingeben</summary>
                                <input type="text" name="image_url_manual" placeholder="assets/images/filters/..." style="margin-top:5px;">
                            </details>
                        </div>

                        <div class="form-group">
                            <label>Filterart</label>
                            <select name="type_id">
                                <option value="">Keine Auswahl</option>
                                <?php foreach ($types as $type): ?>
                                    <?php $selected = ($filter && (int) $filter['type_id'] === (int) $type['id']); ?>
                                    <option value="<?php echo (int) $type['id']; ?>" <?php echo $selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars((string) $type['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Hersteller</label>
                            <select name="brand_id">
                                <option value="">Keine Auswahl</option>
                                <?php foreach ($brands as $brand): ?>
                                    <?php $selected = ($filter && (int) $filter['brand_id'] === (int) $brand['id']); ?>
                                    <option value="<?php echo (int) $brand['id']; ?>" <?php echo $selected ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars((string) $brand['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Video-Link (optional)</label>
                            <input type="text" name="video_url" value="<?php echo htmlspecialchars((string) ($filter['video_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://...">
                        </div>

                        <div class="form-group">
                            <label>Beschreibung</label>
                            <textarea name="description"><?php echo htmlspecialchars((string) ($filter['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_featured" value="1" <?php echo (!empty($filter['is_featured'])) ? 'checked' : ''; ?>>
                                Highlight markieren
                            </label>
                        </div>

                        <div class="form-group" style="margin-top:15px; margin-bottom: 20px;">
                            <label class="checkbox-label" style="font-weight:bold; color:#0f172a;">
                                <input type="checkbox" name="is_active" value="1" <?php echo (!isset($filter['is_active']) || $filter['is_active']) ? 'checked' : ''; ?>>
                                Online schalten (Im Frontend sichtbar)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
