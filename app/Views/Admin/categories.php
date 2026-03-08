<div class="header">
            <h1>Kategorien verwalten</h1>
            <a href="/" target="_blank" class="btn btn-sm" style="background:#e2e8f0; color:#334155;">Webseite ansehen</a>
        </div>

        <!-- Feedback Meldungen -->
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

        <div style="display: flex; gap: 30px; align-items: flex-start; flex-wrap:wrap;">
            
            <!-- LISTE VORHANDENER KATEGORIEN -->
            <div class="card" style="flex: 2; min-width:300px;">
                <div class="card-body" style="padding:0;">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px;">ID</th>
                                <th>Name</th>
                                <th>Slug (URL)</th>
                                <th style="text-align:right">Aktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($db->query("SELECT * FROM categories ORDER BY name ASC") as $row): ?>
                            <tr>
                                <td style="color:#94a3b8;"><?php echo $row['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                                <td><code style="background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#64748b;"><?php echo htmlspecialchars($row['slug']); ?></code></td>
                                <td style="text-align:right">
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn-danger" style="text-decoration:none;" onclick="return confirm('Kategorie wirklich löschen? Die Produkte bleiben erhalten, verlieren aber diese Zuordnung.');">Löschen</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- NEUE KATEGORIE ERSTELLEN -->
            <div class="card" style="flex: 1; min-width:250px; position:sticky; top:20px;">
                <div class="card-body">
                    <h3 style="margin-top:0; color:var(--primary);">Neue Kategorie</h3>
                    <p style="font-size:0.9rem; color:#64748b; margin-bottom:20px;">
                        Erstelle eine neue Gruppe für deine Produkte. Der URL-Name (Slug) wird automatisch generiert.
                    </p>
                    
                    <form method="post">
                        <div class="form-group">
                            <label>Name der Kategorie</label>
                            <input type="text" name="name" placeholder="z.B. Laborbedarf" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%">Hinzufügen</button>
                    </form>
                </div>
            </div>

        </div>
