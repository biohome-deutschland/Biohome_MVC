<?php if ($action === 'list'): ?>
            <div class="header">
                <h1>Filterarten</h1>
                <a href="/admin/filter-types?action=edit" class="btn btn-primary">+ Neue Filterart</a>
            </div>

            <?php if ($msg): ?><div style="background:#dcfce7; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <?php if ($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Filter</th>
                            <th style="text-align:right">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($types as $row): ?>
                            <tr>
                                <td style="color:#94a3b8;"><?php echo (int) $row['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars((string) $row['name'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#64748b;"><?php echo htmlspecialchars((string) $row['slug'], ENT_QUOTES, 'UTF-8'); ?></code></td>
                                <td style="color:#64748b;"><?php echo (int) ($row['filter_count'] ?? 0); ?></td>
                                <td style="text-align:right">
                                    <a href="/admin/filter-types?action=edit&id=<?php echo (int) $row['id']; ?>" class="btn btn-sm" style="background:#e2e8f0;">Edit</a>
                                    <a href="/admin/filter-types?action=delete&id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Filterart wirklich loeschen?');">X</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="header">
                <h1><?php echo $type ? 'Filterart bearbeiten' : 'Neue Filterart'; ?></h1>
                <a href="/admin/filter-types" class="btn" style="background:#e2e8f0;">Zurueck</a>
            </div>

            <?php if ($error): ?><div style="background:#fee2e2; color:#b91c1c; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <?php if ($msg): ?><div style="background:#dcfce7; padding:15px; margin-bottom:20px;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

            <div class="card" style="max-width:800px;">
                <div class="card-body">
                    <form method="post">
                        <?php if ($type): ?><input type="hidden" name="id" value="<?php echo (int) $type['id']; ?>"><?php endif; ?>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars((string) ($type['name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Slug (optional)</label>
                            <input type="text" name="slug" value="<?php echo htmlspecialchars((string) ($type['slug'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" placeholder="z.B. aussenfilter">
                        </div>
                        <div class="form-group">
                            <label>Beschreibung (optional)</label>
                            <textarea name="description" rows="4"><?php echo htmlspecialchars((string) ($type['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <input type="number" name="position" value="<?php echo htmlspecialchars((string) ($type['position'] ?? 0), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
