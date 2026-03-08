<?php if($action === 'list'): ?>
            <!-- LISTE -->
            <div class="header">
                <h1>Hauptmenü verwalten</h1>
                <a href="/admin/menus?action=edit" class="btn btn-primary">+ Neuer Menüpunkt</a>
            </div>

            <?php if($msg): ?>
                <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #bbf7d0;">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th style="width:60px">Pos.</th>
                            <th>Anzeigetext</th>
                            <th>Link-Ziel</th>
                            <th style="text-align:right">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Sortiert nach Position
                        foreach($db->query("SELECT * FROM menu_items ORDER BY position ASC") as $row): 
                        ?>
                        <tr>
                            <td>
                                <span style="background:#f1f5f9; padding:2px 8px; border-radius:10px; font-weight:bold;">
                                    <?php echo $row['position']; ?>
                                </span>
                            </td>
                            <td><strong><?php echo htmlspecialchars($row['label']); ?></strong></td>
                            <td style="color:#64748b; font-family:monospace;">
                                <?php echo htmlspecialchars($row['link']); ?>
                            </td>
                            <td style="text-align:right">
                                <a href="/admin/menus?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Bearbeiten</a>
                                <a href="/admin/menus?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Menüpunkt wirklich löschen?');">Löschen</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="padding:15px; background:#f8fafc; border-top:1px solid #e2e8f0; color:#64748b; font-size:0.85rem;">
                    <strong>Hinweis:</strong> Links, die mit <code>#</code> beginnen (z.B. <code>#kontakt</code>), springen zu Abschnitten auf der Startseite.
                </div>
            </div>

        <?php elseif($action === 'edit'): ?>
            <!-- FORMULAR -->
            <div class="header">
                <h1><?php echo $item ? 'Menüpunkt bearbeiten' : 'Neuer Menüpunkt'; ?></h1>
                <a href="/admin/menus" class="btn" style="background:#e2e8f0; color:#334155;">Abbrechen</a>
            </div>

            <?php if($error): ?>
                <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="card" style="max-width:600px;">
                <div class="card-body">
                    <form method="post">
                        <?php if($item): ?>
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Anzeigetext (Label)</label>
                            <input type="text" name="label" value="<?php echo htmlspecialchars($item['label'] ?? ''); ?>" required placeholder="z.B. Über uns">
                        </div>

                        <div class="form-group">
                            <label>Link-Ziel</label>
                            <input type="text" name="link" value="<?php echo htmlspecialchars($item['link'] ?? ''); ?>" required placeholder="z.B. #kontakt oder pages.php?id=1">
                            <small style="color:#64748b; display:block; margin-top:5px;">
                                Interne Anker: <code>#abschnitt</code><br>
                                Externe Links: <code>https://google.de</code><br>
                                Eigene Seiten: <code>pages.php?slug=impressum</code>
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Position (Reihenfolge)</label>
                            <input type="number" name="position" value="<?php echo htmlspecialchars((string)($item['position'] ?? 10)); ?>" style="width:100px;">
                        </div>

                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
