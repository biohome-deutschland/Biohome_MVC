<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use Throwable;
use RuntimeException;

// --- LEGACY FUNCTIONS MOVED TO admin_filter_helpers.php ---


class AdminFilterCalculatorController extends Controller
{
    protected function before()
    {
        if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function indexAction()
    {
        $db = \Core\Model::getDB();

try {
    ensure_calculator_schema($db);
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Schema-Fehler: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

$productNameCol = product_name_column($db);
$safeProductCol = str_replace('`', '``', $productNameCol);

$types = $db->query("SELECT id, name FROM filter_types ORDER BY position ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);
$brands = $db->query("SELECT id, name FROM filter_brands ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$products = $db->query("SELECT id, `{$safeProductCol}` AS product_name FROM products ORDER BY `{$safeProductCol}` ASC")->fetchAll(PDO::FETCH_ASSOC);
$specRows = $db->query("SELECT product_id, volume_per_kg_l FROM product_specs")->fetchAll(PDO::FETCH_ASSOC);
$specByProduct = [];
foreach ($specRows as $specRow) {
    $specByProduct[(int) $specRow['product_id']] = (float) $specRow['volume_per_kg_l'];
}

$filterId = to_int_or_null($_GET['filter_id'] ?? $_POST['filter_id'] ?? null) ?? 0;
$message = '';
$error = '';

if (isset($_GET['saved']) && $_GET['saved'] === '1') {
    $message = 'Kalkulator-Daten gespeichert und Cache aktualisiert.';
}

if ($filterId > 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $addRow = isset($_POST['add_row']) && $_POST['add_row'] === '1';
    $save = isset($_POST['save']) && $_POST['save'] === '1';

    if ($save) {
        $validStageTypes = ['mechanik', 'biohome', 'chemie', 'leer'];

        try {
            $db->beginTransaction();

            $filterTitle = trim((string) ($_POST['filter_title'] ?? ''));
            $filterDescription = (string) ($_POST['filter_description'] ?? '');
            $filterImageUrl = trim((string) ($_POST['filter_image_url'] ?? ''));
            $typeId = to_int_or_null($_POST['type_id'] ?? null);
            $brandId = to_int_or_null($_POST['brand_id'] ?? null);
            $modelName = trim((string) ($_POST['model_name'] ?? ''));
            $modelDescription = trim((string) ($_POST['model_description'] ?? ''));
            $variantName = trim((string) ($_POST['variant_name'] ?? ''));
            $variantSlugInput = trim((string) ($_POST['variant_slug'] ?? ''));
            $basketCount = max(1, to_int_or_null($_POST['basket_count'] ?? 1) ?? 1);
            $totalMediaVolume = to_float_or_null($_POST['total_media_volume_l'] ?? null);
            $defaultBasketVolume = to_float_or_null($_POST['default_basket_volume_l'] ?? null);

            $currentIds = $db->prepare(
                "SELECT f.id,
                        f.variant_id,
                        v.model_id
                 FROM filters f
                 LEFT JOIN filter_variants v ON v.id = f.variant_id
                 WHERE f.id = ?
                 LIMIT 1"
            );
            $currentIds->execute([$filterId]);
            $idRow = $currentIds->fetch(PDO::FETCH_ASSOC);
            if (!$idRow) {
                throw new RuntimeException('Filter wurde nicht gefunden.');
            }

            if ($filterTitle === '') {
                throw new RuntimeException('Filter-Titel darf nicht leer sein.');
            }
            if ($modelName === '') {
                throw new RuntimeException('Modellname darf nicht leer sein.');
            }
            if ($typeId === null || $typeId <= 0) {
                throw new RuntimeException('Bitte eine Filterart waehlen.');
            }
            if ($brandId === null || $brandId <= 0) {
                throw new RuntimeException('Bitte einen Hersteller waehlen.');
            }

            $modelId = to_int_or_null($idRow['model_id']) ?? 0;
            $variantId = to_int_or_null($idRow['variant_id']) ?? 0;

            $modelSlug = unique_slug($db, 'filter_models', slugify_text($modelName), $modelId > 0 ? $modelId : null);
            if ($variantSlugInput === '') {
                $variantSlugInput = slugify_text(trim($modelName . ' ' . $variantName));
            }
            $variantSlug = unique_slug($db, 'filter_variants', slugify_text($variantSlugInput), $variantId > 0 ? $variantId : null);

            if ($modelId > 0) {
                $updateModel = $db->prepare(
                    "UPDATE filter_models
                     SET brand_id = ?, type_id = ?, name = ?, slug = ?, description = ?
                     WHERE id = ?"
                );
                $updateModel->execute([$brandId, $typeId, $modelName, $modelSlug, $modelDescription, $modelId]);
            } else {
                $insertModel = $db->prepare(
                    "INSERT INTO filter_models (brand_id, type_id, name, slug, description)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $insertModel->execute([$brandId, $typeId, $modelName, $modelSlug, $modelDescription]);
                $modelId = (int) $db->lastInsertId();
            }

            if ($variantId > 0) {
                $updateVariant = $db->prepare(
                    "UPDATE filter_variants
                     SET model_id = ?, variant_name = ?, slug = ?, basket_count = ?, total_media_volume_l = ?, default_basket_volume_l = ?
                     WHERE id = ?"
                );
                $updateVariant->execute([
                    $modelId,
                    $variantName !== '' ? $variantName : null,
                    $variantSlug,
                    $basketCount,
                    $totalMediaVolume,
                    $defaultBasketVolume,
                    $variantId,
                ]);
            } else {
                $insertVariant = $db->prepare(
                    "INSERT INTO filter_variants (model_id, variant_name, slug, basket_count, total_media_volume_l, default_basket_volume_l)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                $insertVariant->execute([
                    $modelId,
                    $variantName !== '' ? $variantName : null,
                    $variantSlug,
                    $basketCount,
                    $totalMediaVolume,
                    $defaultBasketVolume,
                ]);
                $variantId = (int) $db->lastInsertId();
            }

            $updateFilter = $db->prepare(
                "UPDATE filters
                 SET title = ?, description = ?, image_url = ?, type_id = ?, brand_id = ?, variant_id = ?, basket_count = ?
                 WHERE id = ?"
            );
            $updateFilter->execute([
                $filterTitle,
                $filterDescription,
                $filterImageUrl !== '' ? $filterImageUrl : null,
                $typeId,
                $brandId,
                $variantId,
                $basketCount,
                $filterId,
            ]);

            $existingStageIdsStmt = $db->prepare("SELECT id FROM filter_stages WHERE variant_id = ?");
            $existingStageIdsStmt->execute([$variantId]);
            $existingStageIds = array_map('intval', $existingStageIdsStmt->fetchAll(PDO::FETCH_COLUMN));

            $rows = parse_stage_rows_from_post($_POST);
            $keptStageIds = [];
            $stageCounter = 1;

            $insertStage = $db->prepare(
                "INSERT INTO filter_stages (variant_id, stage_order, stage_type, basket_index, basket_volume_l, fill_factor, note)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $updateStage = $db->prepare(
                "UPDATE filter_stages
                 SET stage_order = ?, stage_type = ?, basket_index = ?, basket_volume_l = ?, fill_factor = ?, note = ?
                 WHERE id = ? AND variant_id = ?"
            );
            $deleteRecoByStage = $db->prepare("DELETE FROM filter_stage_recommendations WHERE stage_id = ?");
            $insertReco = $db->prepare(
                "INSERT INTO filter_stage_recommendations (stage_id, product_id, amount_kg_per_basket, amount_min_kg, amount_max_kg, recommendation_note)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $updateReco = $db->prepare(
                "UPDATE filter_stage_recommendations
                 SET product_id = ?, amount_kg_per_basket = ?, amount_min_kg = ?, amount_max_kg = ?, recommendation_note = ?
                 WHERE id = ? AND stage_id = ?"
            );
            $findRecoByStage = $db->prepare("SELECT id FROM filter_stage_recommendations WHERE stage_id = ? LIMIT 1");

            foreach ($rows as $row) {
                $stageType = $row['stage_type'];
                if (!in_array($stageType, $validStageTypes, true)) {
                    continue;
                }

                $stageOrder = $row['stage_order'] ?? $stageCounter;
                if ($stageOrder < 1) {
                    $stageOrder = $stageCounter;
                }

                $fillFactor = $row['fill_factor'];
                if ($fillFactor !== null) {
                    $fillFactor = max(0.0, min(1.0, $fillFactor));
                }

                $stageId = $row['stage_id'] ?? 0;
                if ($stageId > 0) {
                    $updateStage->execute([
                        $stageOrder,
                        $stageType,
                        $row['basket_index'],
                        $row['basket_volume_l'],
                        $fillFactor,
                        $row['stage_note'] !== '' ? $row['stage_note'] : null,
                        $stageId,
                        $variantId,
                    ]);
                    $keptStageIds[] = $stageId;
                } else {
                    $insertStage->execute([
                        $variantId,
                        $stageOrder,
                        $stageType,
                        $row['basket_index'],
                        $row['basket_volume_l'],
                        $fillFactor,
                        $row['stage_note'] !== '' ? $row['stage_note'] : null,
                    ]);
                    $stageId = (int) $db->lastInsertId();
                    $keptStageIds[] = $stageId;
                }

                $hasRecoData = $row['reco_product_id'] !== null
                    || $row['reco_amount_kg_per_basket'] !== null
                    || $row['reco_amount_min_kg'] !== null
                    || $row['reco_amount_max_kg'] !== null
                    || $row['reco_note'] !== '';

                if ($hasRecoData && ($row['reco_product_id'] === null || $row['reco_product_id'] <= 0)) {
                    throw new RuntimeException('Stufe ' . $stageOrder . ': Empfehlung braucht ein Produkt.');
                }

                if ($hasRecoData) {
                    $recoId = $row['reco_id'] ?? 0;
                    if ($recoId > 0) {
                        $updateReco->execute([
                            $row['reco_product_id'],
                            $row['reco_amount_kg_per_basket'],
                            $row['reco_amount_min_kg'],
                            $row['reco_amount_max_kg'],
                            $row['reco_note'] !== '' ? $row['reco_note'] : null,
                            $recoId,
                            $stageId,
                        ]);
                    } else {
                        $findRecoByStage->execute([$stageId]);
                        $existingRecoId = to_int_or_null($findRecoByStage->fetchColumn()) ?? 0;
                        if ($existingRecoId > 0) {
                            $updateReco->execute([
                                $row['reco_product_id'],
                                $row['reco_amount_kg_per_basket'],
                                $row['reco_amount_min_kg'],
                                $row['reco_amount_max_kg'],
                                $row['reco_note'] !== '' ? $row['reco_note'] : null,
                                $existingRecoId,
                                $stageId,
                            ]);
                        } else {
                            $insertReco->execute([
                                $stageId,
                                $row['reco_product_id'],
                                $row['reco_amount_kg_per_basket'],
                                $row['reco_amount_min_kg'],
                                $row['reco_amount_max_kg'],
                                $row['reco_note'] !== '' ? $row['reco_note'] : null,
                            ]);
                        }
                    }
                } else {
                    $deleteRecoByStage->execute([$stageId]);
                }

                $stageCounter++;
            }

            $toDelete = array_values(array_diff($existingStageIds, $keptStageIds));
            if (!empty($toDelete)) {
                $placeholders = implode(',', array_fill(0, count($toDelete), '?'));
                $deleteReco = $db->prepare(
                    "DELETE FROM filter_stage_recommendations
                     WHERE stage_id IN ({$placeholders})"
                );
                $deleteReco->execute($toDelete);

                $deleteStagesParams = $toDelete;
                $deleteStagesParams[] = $variantId;
                $deleteStages = $db->prepare(
                    "DELETE FROM filter_stages
                     WHERE id IN ({$placeholders}) AND variant_id = ?"
                );
                $deleteStages->execute($deleteStagesParams);
            }

            if (isset($_POST['spec_volume']) && is_array($_POST['spec_volume'])) {
                $upsertSpec = $db->prepare(
                    "INSERT INTO product_specs (product_id, volume_per_kg_l)
                     VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE volume_per_kg_l = VALUES(volume_per_kg_l)"
                );
                foreach ($_POST['spec_volume'] as $productIdRaw => $volumeRaw) {
                    $productId = to_int_or_null($productIdRaw) ?? 0;
                    $volume = to_float_or_null($volumeRaw);
                    if ($productId <= 0 || $volume === null || $volume <= 0) {
                        continue;
                    }
                    $upsertSpec->execute([$productId, round($volume, 2)]);
                }
            }

            rebuild_filter_cache_row($db, $filterId, $productNameCol);
            $db->commit();

            header('Location: /admin/filter-calculator?filter_id=' . $filterId . '&saved=1');
            exit;
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            $error = $e->getMessage();
        }
    } elseif ($addRow) {
        $message = 'Leere Stufe hinzugefuegt. Jetzt Werte eintragen und speichern.';
    }
}

$listRows = [];
if ($filterId <= 0) {
    $listRows = $db->query(
        "SELECT f.id,
                f.title,
                f.variant_id,
                f.basket_count,
                t.name AS type_name,
                b.name AS brand_name,
                m.name AS model_name,
                v.variant_name
         FROM filters f
         LEFT JOIN filter_types t ON t.id = f.type_id
         LEFT JOIN filter_brands b ON b.id = f.brand_id
         LEFT JOIN filter_variants v ON v.id = f.variant_id
         LEFT JOIN filter_models m ON m.id = v.model_id
         ORDER BY f.id DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
}

$current = null;
$stageRows = [];
if ($filterId > 0) {
    $stmt = $db->prepare(
        "SELECT f.*,
                v.id AS calc_variant_id,
                v.model_id AS calc_model_id,
                v.variant_name,
                v.slug AS variant_slug,
                v.total_media_volume_l,
                v.default_basket_volume_l,
                m.name AS model_name,
                m.description AS model_description
         FROM filters f
         LEFT JOIN filter_variants v ON v.id = f.variant_id
         LEFT JOIN filter_models m ON m.id = v.model_id
         WHERE f.id = ?
         LIMIT 1"
    );
    $stmt->execute([$filterId]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current) {
        $error = 'Filter nicht gefunden.';
        $filterId = 0;
    }
}

if ($filterId <= 0 && empty($listRows)) {
    $listRows = $db->query(
        "SELECT f.id,
                f.title,
                f.variant_id,
                f.basket_count,
                t.name AS type_name,
                b.name AS brand_name,
                m.name AS model_name,
                v.variant_name
         FROM filters f
         LEFT JOIN filter_types t ON t.id = f.type_id
         LEFT JOIN filter_brands b ON b.id = f.brand_id
         LEFT JOIN filter_variants v ON v.id = f.variant_id
         LEFT JOIN filter_models m ON m.id = v.model_id
         ORDER BY f.id DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
}

if ($filterId > 0 && $current) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_row']) && $_POST['add_row'] === '1') {
        $stageRows = parse_stage_rows_from_post($_POST);
        $stageRows[] = [
            'stage_id' => null,
            'stage_order' => count($stageRows) + 1,
            'stage_type' => '',
            'basket_index' => null,
            'basket_volume_l' => null,
            'fill_factor' => null,
            'stage_note' => '',
            'reco_id' => null,
            'reco_product_id' => null,
            'reco_amount_kg_per_basket' => null,
            'reco_amount_min_kg' => null,
            'reco_amount_max_kg' => null,
            'reco_note' => '',
        ];
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save']) && $_POST['save'] === '1' && $error !== '') {
        $stageRows = parse_stage_rows_from_post($_POST);
    } else {
        $variantId = to_int_or_null($current['variant_id']) ?? 0;
        if ($variantId > 0) {
            $stageRows = load_stage_rows($db, $variantId);
        }
        if (empty($stageRows)) {
            $stageRows = default_stage_rows((int) ($current['basket_count'] ?? 1));
        }
    }
}
// End of legacy parsing

        View::renderTemplate('Admin/Layouts/main.php', [
            'content_view' => 'Admin/filter_calculator.php',
            'admin_page' => 'admin/filter-calculator',
            'filterId' => $filterId ?? 0,
            'message' => $message ?? '',
            'error' => $error ?? '',
            'listRows' => $listRows ?? [],
            'current' => $current ?? null,
            'stageRows' => $stageRows ?? [],
            'pdo' => $db
        ]);
    }
}
