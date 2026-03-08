<?php if($action === 'list'): ?>
            <div class="header">
                <h1>Seitenübersicht</h1>
                <a href="/admin/pages?action=edit" class="btn btn-primary">+ Neue Seite</a>
            </div>

            <?php if($msg): ?><div style="background:#dcfce7; color:#166534; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #bbf7d0;"><?php echo $msg; ?></div><?php endif; ?>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>URL-Slug</th>
                            <th>Letzte Änderung</th>
                            <th style="text-align:right">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($db->query("SELECT * FROM pages ORDER BY title ASC") as $row): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#64748b;">/<?php echo htmlspecialchars($row['slug']); ?></code></td>
                            <td style="color:#64748b; font-size:0.9rem;"><?php echo $row['updated_at']; ?></td>
                            <td style="text-align:right">
                                <a href="/admin/pages?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Bearbeiten</a>
                                <?php if(!in_array($row['slug'], ['home', 'impressum', 'datenschutz'])): ?>
                                    <a href="/admin/pages?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Seite wirklich löschen?');">Löschen</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($action === 'edit'): ?>
            <div class="header">
                <h1><?php echo $page ? 'Seite bearbeiten: ' . htmlspecialchars($page['title']) : 'Neue Seite erstellen'; ?></h1>
                <a href="/admin/pages" class="btn" style="background:#e2e8f0; color:#334155;">Abbrechen</a>
            </div>

            <?php if($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;"><?php echo $error; ?></div><?php endif; ?>
            <?php if($tinymce_notice): ?><div style="background:#fff7ed; color:#9a3412; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #fed7aa;"><?php echo htmlspecialchars($tinymce_notice); ?></div><?php endif; ?>
            <?php if($msg): ?><div style="background:#dcfce7; color:#166534; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #bbf7d0;"><?php echo $msg; ?></div><?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post">
                        <?php if($page): ?><input type="hidden" name="id" value="<?php echo $page['id']; ?>"><?php endif; ?>

                        <div style="display:flex; gap:20px;">
                            <div class="form-group" style="flex:2;">
                                <label>Seitentitel</label>
                                <input type="text" name="title" value="<?php echo htmlspecialchars($page['title'] ?? ''); ?>" required placeholder="z.B. Über uns">
                            </div>
                            <div class="form-group" style="flex:1;">
                                <label>URL-Slug (eindeutig)</label>
                                <input type="text" name="slug" value="<?php echo htmlspecialchars($page['slug'] ?? ''); ?>" required placeholder="z.B. ueber-uns">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Inhalt</label>
                            <textarea name="content" id="page-editor"><?php echo htmlspecialchars($page['content'] ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
