<?php if ($filterId <= 0): ?>
        <div class="header">
            <h1>Filter-Kalkulator</h1>
            <a href="/admin/filters" class="btn" style="background:#e2e8f0; color:#334155;">Zurueck zu Filtern</a>
        </div>

        <?php if ($message !== ''): ?><div style="background:#dcfce7; padding:12px 14px; margin-bottom:16px;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        <?php if ($error !== ''): ?><div style="background:#fee2e2; color:#b91c1c; padding:12px 14px; margin-bottom:16px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th width="70">ID</th>
                        <th>Filter</th>
                        <th>Typ</th>
                        <th>Hersteller</th>
                        <th>Variante</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aktion</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($listRows as $row): ?>
                    <?php
                    $hasCalc = !empty($row['variant_id']);
                    $variantLabel = trim((string) ($row['model_name'] ?? '') . ' ' . (string) ($row['variant_name'] ?? ''));
                    if ($variantLabel === '') {
                        $variantLabel = '-';
                    }
                    ?>
                    <tr>
                        <td><?php echo (int) $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars((string) $row['title'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo htmlspecialchars((string) ($row['type_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) ($row['brand_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($variantLabel, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php if ($hasCalc): ?>
                                <span style="display:inline-block; padding:4px 8px; border-radius:999px; background:#dcfce7; color:#166534; font-size:12px;">Kalkulator aktiv</span>
                            <?php else: ?>
                                <span style="display:inline-block; padding:4px 8px; border-radius:999px; background:#fee2e2; color:#b91c1c; font-size:12px;">Noch kein Setup</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:right;">
                            <a href="/admin/filter-calculator?filter_id=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-primary">Bearbeiten</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="header">
            <h1>Filter-Kalkulator bearbeiten</h1>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <a href="/admin/filter-calculator" class="btn" style="background:#e2e8f0; color:#334155;">Zur Liste</a>
                <a href="/admin/filters?action=edit&id=<?php echo (int) $filterId; ?>" class="btn" style="background:#e2e8f0; color:#334155;">Filter bearbeiten</a>
            </div>
        </div>

        <?php if ($message !== ''): ?><div style="background:#dcfce7; padding:12px 14px; margin-bottom:16px;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        <?php if ($error !== ''): ?><div style="background:#fee2e2; color:#b91c1c; padding:12px 14px; margin-bottom:16px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

        <form method="post">
            <input type="hidden" name="filter_id" value="<?php echo (int) $filterId; ?>">

            <div class="card" style="margin-bottom:16px;">
                <div class="card-body">
                    <h3 style="margin-top:0;">1) Basisdaten</h3>

                    <div class="form-group">
                        <label>Filter-Titel</label>
                        <input type="text" name="filter_title" value="<?php echo htmlspecialchars((string) ($_POST['filter_title'] ?? $current['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Filter-Bildpfad (optional)</label>
                        <input type="text" name="filter_image_url" value="<?php echo htmlspecialchars((string) ($_POST['filter_image_url'] ?? $current['image_url'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" placeholder="assets/images/filters/...">
                    </div>

                    <div class="form-group">
                        <label>Filterart</label>
                        <?php $selectedTypeId = to_int_or_null($_POST['type_id'] ?? $current['type_id'] ?? null); ?>
                        <select name="type_id">
                            <option value="">Bitte waehlen</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo (int) $type['id']; ?>" <?php echo ($selectedTypeId === (int) $type['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars((string) $type['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hersteller</label>
                        <?php $selectedBrandId = to_int_or_null($_POST['brand_id'] ?? $current['brand_id'] ?? null); ?>
                        <select name="brand_id">
                            <option value="">Bitte waehlen</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo (int) $brand['id']; ?>" <?php echo ($selectedBrandId === (int) $brand['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars((string) $brand['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Modellname</label>
                        <input type="text" name="model_name" value="<?php echo htmlspecialchars((string) ($_POST['model_name'] ?? $current['model_name'] ?? $current['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="form-group">
                        <label>Modellbeschreibung (kurz)</label>
                        <textarea name="model_description" rows="3"><?php echo htmlspecialchars((string) ($_POST['model_description'] ?? $current['model_description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px;">
                        <div class="form-group">
                            <label>Variantenname (optional)</label>
                            <input type="text" name="variant_name" value="<?php echo htmlspecialchars((string) ($_POST['variant_name'] ?? $current['variant_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Variant-Slug (optional)</label>
                            <input type="text" name="variant_slug" value="<?php echo htmlspecialchars((string) ($_POST['variant_slug'] ?? $current['variant_slug'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Biohome-Koerbe</label>
                            <input type="number" min="1" max="20" name="basket_count" value="<?php echo htmlspecialchars((string) ($_POST['basket_count'] ?? $current['basket_count'] ?? 1), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Gesamtvolumen (L, optional)</label>
                            <input type="text" name="total_media_volume_l" value="<?php echo htmlspecialchars((string) ($_POST['total_media_volume_l'] ?? format_float(to_float_or_null($current['total_media_volume_l'] ?? null))), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Korbvolumen (L, optional)</label>
                            <input type="text" name="default_basket_volume_l" value="<?php echo htmlspecialchars((string) ($_POST['default_basket_volume_l'] ?? format_float(to_float_or_null($current['default_basket_volume_l'] ?? null))), ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Filterbeschreibung</label>
                        <textarea name="filter_description" rows="6"><?php echo htmlspecialchars((string) ($_POST['filter_description'] ?? $current['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:16px;">
                <div class="card-body">
                    <h3 style="margin-top:0;">2) Stufen und Empfehlungen</h3>
                    <p style="margin-top:0; color:#64748b; font-size:0.9rem;">
                        Reihenfolge von oben nach unten: Mechanik -> Biohome -> Auslauf. Kein Feinvlies nach Biohome als letzte Stufe.
                    </p>
                    <div style="overflow-x:auto;">
                        <table style="min-width:1280px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Typ</th>
                                    <th>Korb</th>
                                    <th>Korb L</th>
                                    <th>Fill</th>
                                    <th>Produkt</th>
                                    <th>kg/Korb</th>
                                    <th>Min kg</th>
                                    <th>Max kg</th>
                                    <th>Stufen-Notiz</th>
                                    <th>Reco-Notiz</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($stageRows as $idx => $stage): ?>
                                <tr>
                                    <td style="width:70px;">
                                        <input type="hidden" name="stage_id[]" value="<?php echo htmlspecialchars((string) ($stage['stage_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="reco_id[]" value="<?php echo htmlspecialchars((string) ($stage['reco_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="number" name="stage_order[]" min="1" value="<?php echo htmlspecialchars((string) ($stage['stage_order'] ?? ($idx + 1)), ENT_QUOTES, 'UTF-8'); ?>">
                                    </td>
                                    <td>
                                        <?php $stageType = (string) ($stage['stage_type'] ?? ''); ?>
                                        <select name="stage_type[]">
                                            <option value="">- entfernen -</option>
                                            <option value="mechanik" <?php echo $stageType === 'mechanik' ? 'selected' : ''; ?>>Mechanik</option>
                                            <option value="biohome" <?php echo $stageType === 'biohome' ? 'selected' : ''; ?>>Biohome</option>
                                            <option value="chemie" <?php echo $stageType === 'chemie' ? 'selected' : ''; ?>>Chemie</option>
                                            <option value="leer" <?php echo $stageType === 'leer' ? 'selected' : ''; ?>>Leer/Auslauf</option>
                                        </select>
                                    </td>
                                    <td><input type="number" min="1" name="basket_index[]" value="<?php echo htmlspecialchars((string) ($stage['basket_index'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="basket_volume_l[]" value="<?php echo htmlspecialchars((string) format_float(to_float_or_null($stage['basket_volume_l'] ?? null)), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="fill_factor[]" value="<?php echo htmlspecialchars((string) format_float(to_float_or_null($stage['fill_factor'] ?? null)), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td>
                                        <?php $selectedProduct = to_int_or_null($stage['reco_product_id'] ?? null); ?>
                                        <select name="reco_product_id[]">
                                            <option value="">- kein Produkt -</option>
                                            <?php foreach ($products as $product): ?>
                                                <option value="<?php echo (int) $product['id']; ?>" <?php echo ($selectedProduct === (int) $product['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars((string) $product['product_name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="reco_amount_kg_per_basket[]" value="<?php echo htmlspecialchars((string) format_float(to_float_or_null($stage['reco_amount_kg_per_basket'] ?? null)), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="reco_amount_min_kg[]" value="<?php echo htmlspecialchars((string) format_float(to_float_or_null($stage['reco_amount_min_kg'] ?? null)), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="reco_amount_max_kg[]" value="<?php echo htmlspecialchars((string) format_float(to_float_or_null($stage['reco_amount_max_kg'] ?? null)), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="stage_note[]" value="<?php echo htmlspecialchars((string) ($stage['stage_note'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><input type="text" name="reco_note[]" value="<?php echo htmlspecialchars((string) ($stage['reco_note'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top:10px;">
                        <button type="submit" name="add_row" value="1" class="btn btn-sm" style="background:#e2e8f0; color:#334155;" formnovalidate>+ Stufe hinzufuegen</button>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:16px;">
                <div class="card-body">
                    <h3 style="margin-top:0;">3) Produkt-Spezifikation fuer Rechner (Liter pro kg)</h3>
                    <p style="margin-top:0; color:#64748b; font-size:0.9rem;">
                        Diese Werte nutzt der Kalkulator fuer Umrechnung zwischen kg und Schuettvolumen.
                    </p>
                    <div style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produkt</th>
                                    <th style="width:200px;">Liter pro kg</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $product): ?>
                                <?php
                                $pid = (int) $product['id'];
                                $postedSpec = $_POST['spec_volume'][$pid] ?? null;
                                $specValue = $postedSpec !== null ? to_float_or_null($postedSpec) : ($specByProduct[$pid] ?? null);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string) $product['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <input type="text" name="spec_volume[<?php echo $pid; ?>]" value="<?php echo htmlspecialchars((string) format_float($specValue), ENT_QUOTES, 'UTF-8'); ?>" placeholder="z.B. 1.25">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:8px; align-items:center;">
                <button type="submit" name="save" value="1" class="btn btn-primary">Speichern und Cache aktualisieren</button>
                <a href="../scripts/build_filter_images.php?run=1" target="_blank" class="btn" style="background:#e2e8f0; color:#334155;">Danach SVGs neu erzeugen</a>
            </div>
        </form>
    <?php endif; ?>
