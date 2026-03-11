<?php

function admin_table_exists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare(
        "SELECT 1
         FROM INFORMATION_SCHEMA.TABLES
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = ?
         LIMIT 1"
    );
    $stmt->execute([$table]);
    return (bool) $stmt->fetchColumn();
}

function admin_column_exists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        "SELECT 1
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = ?
           AND COLUMN_NAME = ?
         LIMIT 1"
    );
    $stmt->execute([$table, $column]);
    return (bool) $stmt->fetchColumn();
}

function admin_index_exists(PDO $pdo, string $table, string $index): bool
{
    $stmt = $pdo->prepare(
        "SELECT 1
         FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = ?
           AND INDEX_NAME = ?
         LIMIT 1"
    );
    $stmt->execute([$table, $index]);
    return (bool) $stmt->fetchColumn();
}

function slugify_text(string $text): string
{
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    if (function_exists('mb_strtolower')) {
        $text = mb_strtolower($text, 'UTF-8');
    } else {
        $text = strtolower($text);
    }
    if (function_exists('iconv')) {
        $tmp = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        if (is_string($tmp) && $tmp !== '') {
            $text = $tmp;
        }
    }
    $text = preg_replace('~[^a-z0-9]+~', '-', $text) ?? '';
    $text = trim($text, '-');
    return $text !== '' ? $text : 'filter';
}

function unique_slug(PDO $pdo, string $table, string $baseSlug, ?int $excludeId = null): string
{
    $slug = $baseSlug !== '' ? $baseSlug : 'filter';
    $candidate = $slug;
    $index = 1;

    while (true) {
        if ($excludeId !== null && $excludeId > 0) {
            $stmt = $pdo->prepare(
                "SELECT id FROM {$table} WHERE slug = ? AND id <> ? LIMIT 1"
            );
            $stmt->execute([$candidate, $excludeId]);
        } else {
            $stmt = $pdo->prepare(
                "SELECT id FROM {$table} WHERE slug = ? LIMIT 1"
            );
            $stmt->execute([$candidate]);
        }

        if (!$stmt->fetchColumn()) {
            return $candidate;
        }

        $index++;
        $candidate = $slug . '-' . $index;
    }
}

function to_int_or_null($value): ?int
{
    if ($value === null || $value === '') {
        return null;
    }
    if (!is_numeric((string) $value)) {
        return null;
    }
    return (int) $value;
}

function to_float_or_null($value): ?float
{
    if ($value === null || $value === '') {
        return null;
    }
    if (!is_string($value) && !is_numeric($value)) {
        return null;
    }
    $value = str_replace(',', '.', trim((string) $value));
    if ($value === '' || !is_numeric($value)) {
        return null;
    }
    return (float) $value;
}

function format_float(?float $value): string
{
    if ($value === null) {
        return '';
    }
    $formatted = number_format($value, 2, '.', '');
    return rtrim(rtrim($formatted, '0'), '.');
}

function parse_stage_rows_from_post(array $post): array
{
    $rows = [];

    $keys = [
        'stage_id',
        'stage_order',
        'stage_type',
        'basket_index',
        'basket_volume_l',
        'fill_factor',
        'stage_note',
        'reco_id',
        'reco_product_id',
        'reco_amount_kg_per_basket',
        'reco_amount_min_kg',
        'reco_amount_max_kg',
        'reco_note',
    ];

    $max = 0;
    foreach ($keys as $key) {
        if (isset($post[$key]) && is_array($post[$key])) {
            $max = max($max, count($post[$key]));
        }
    }

    for ($i = 0; $i < $max; $i++) {
        $rows[] = [
            'stage_id' => to_int_or_null($post['stage_id'][$i] ?? null),
            'stage_order' => to_int_or_null($post['stage_order'][$i] ?? null),
            'stage_type' => trim((string) ($post['stage_type'][$i] ?? '')),
            'basket_index' => to_int_or_null($post['basket_index'][$i] ?? null),
            'basket_volume_l' => to_float_or_null($post['basket_volume_l'][$i] ?? null),
            'fill_factor' => to_float_or_null($post['fill_factor'][$i] ?? null),
            'stage_note' => trim((string) ($post['stage_note'][$i] ?? '')),
            'reco_id' => to_int_or_null($post['reco_id'][$i] ?? null),
            'reco_product_id' => to_int_or_null($post['reco_product_id'][$i] ?? null),
            'reco_amount_kg_per_basket' => to_float_or_null($post['reco_amount_kg_per_basket'][$i] ?? null),
            'reco_amount_min_kg' => to_float_or_null($post['reco_amount_min_kg'][$i] ?? null),
            'reco_amount_max_kg' => to_float_or_null($post['reco_amount_max_kg'][$i] ?? null),
            'reco_note' => trim((string) ($post['reco_note'][$i] ?? '')),
        ];
    }

    return $rows;
}

function default_stage_rows(int $basketCount): array
{
    $basketCount = max(1, $basketCount);
    $rows = [];
    $order = 1;

    $rows[] = [
        'stage_id' => null,
        'stage_order' => $order++,
        'stage_type' => 'mechanik',
        'basket_index' => null,
        'basket_volume_l' => null,
        'fill_factor' => null,
        'stage_note' => 'Vorfilterung zuerst.',
        'reco_id' => null,
        'reco_product_id' => null,
        'reco_amount_kg_per_basket' => null,
        'reco_amount_min_kg' => null,
        'reco_amount_max_kg' => null,
        'reco_note' => '',
    ];

    for ($basket = 1; $basket <= $basketCount; $basket++) {
        $rows[] = [
            'stage_id' => null,
            'stage_order' => $order++,
            'stage_type' => 'biohome',
            'basket_index' => $basket,
            'basket_volume_l' => null,
            'fill_factor' => 0.85,
            'stage_note' => 'Biohome-Stufe.',
            'reco_id' => null,
            'reco_product_id' => null,
            'reco_amount_kg_per_basket' => null,
            'reco_amount_min_kg' => null,
            'reco_amount_max_kg' => null,
            'reco_note' => '',
        ];
    }

    $rows[] = [
        'stage_id' => null,
        'stage_order' => $order++,
        'stage_type' => 'leer',
        'basket_index' => null,
        'basket_volume_l' => null,
        'fill_factor' => null,
        'stage_note' => 'Auslauf. Kein Feinvlies nach Biohome.',
        'reco_id' => null,
        'reco_product_id' => null,
        'reco_amount_kg_per_basket' => null,
        'reco_amount_min_kg' => null,
        'reco_amount_max_kg' => null,
        'reco_note' => '',
    ];

    return $rows;
}

function product_name_column(PDO $pdo): string
{
    $stmt = $pdo->query(
        "SELECT COLUMN_NAME
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = 'products'
           AND COLUMN_NAME IN ('title', 'name')"
    );
    $cols = $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN, 0) : [];
    if (in_array('title', $cols, true)) {
        return 'title';
    }
    if (in_array('name', $cols, true)) {
        return 'name';
    }
    return 'id';
}

function ensure_filter_schema(PDO $pdo): void
{
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_types (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            slug VARCHAR(120) NOT NULL,
            description TEXT NULL,
            position INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_brands (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            slug VARCHAR(120) NOT NULL,
            website VARCHAR(255) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description LONGTEXT NULL,
            image_url VARCHAR(255) NULL,
            video_url VARCHAR(255) NULL,
            type_id INT NULL,
            brand_id INT NULL,
            is_featured TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_type (type_id),
            INDEX idx_brand (brand_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );
}

function ensure_calculator_schema(PDO $pdo): void
{
    ensure_filter_schema($pdo);

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS product_specs (
            product_id INT NOT NULL PRIMARY KEY,
            volume_per_kg_l DECIMAL(6,2) NOT NULL,
            bulk_density_g_per_l DECIMAL(6,2) NULL,
            pellet_shape VARCHAR(50) NULL,
            pellet_diameter_mm_min DECIMAL(6,2) NULL,
            pellet_diameter_mm_max DECIMAL(6,2) NULL,
            pellet_length_mm_min DECIMAL(6,2) NULL,
            pellet_length_mm_max DECIMAL(6,2) NULL,
            brick_length_mm DECIMAL(6,2) NULL,
            brick_width_mm DECIMAL(6,2) NULL,
            brick_height_mm DECIMAL(6,2) NULL,
            spec_note TEXT NULL,
            CONSTRAINT fk_product_specs_product
                FOREIGN KEY (product_id) REFERENCES products(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_models (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brand_id INT NOT NULL,
            type_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_filter_models_brand (brand_id),
            INDEX idx_filter_models_type (type_id),
            CONSTRAINT fk_filter_models_brand FOREIGN KEY (brand_id) REFERENCES filter_brands(id),
            CONSTRAINT fk_filter_models_type FOREIGN KEY (type_id) REFERENCES filter_types(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_variants (
            id INT AUTO_INCREMENT PRIMARY KEY,
            model_id INT NOT NULL,
            variant_name VARCHAR(255) NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            basket_count INT DEFAULT 0,
            total_media_volume_l DECIMAL(6,2) NULL,
            default_basket_volume_l DECIMAL(6,2) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_filter_variants_model (model_id),
            CONSTRAINT fk_filter_variants_model FOREIGN KEY (model_id) REFERENCES filter_models(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_stages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            variant_id INT NOT NULL,
            stage_order INT NOT NULL,
            stage_type ENUM('mechanik','biohome','chemie','leer') NOT NULL,
            basket_index INT NULL,
            basket_volume_l DECIMAL(6,2) NULL,
            fill_factor DECIMAL(4,2) NULL,
            note TEXT NULL,
            INDEX idx_filter_stages_variant (variant_id),
            INDEX idx_filter_stages_order (variant_id, stage_order),
            CONSTRAINT fk_filter_stages_variant FOREIGN KEY (variant_id) REFERENCES filter_variants(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS filter_stage_recommendations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            stage_id INT NOT NULL,
            product_id INT NOT NULL,
            amount_kg_per_basket DECIMAL(6,2) NULL,
            amount_min_kg DECIMAL(6,2) NULL,
            amount_max_kg DECIMAL(6,2) NULL,
            recommendation_note TEXT NULL,
            INDEX idx_filter_stage_reco_stage (stage_id),
            INDEX idx_filter_stage_reco_product (product_id),
            CONSTRAINT fk_filter_stage_reco_stage FOREIGN KEY (stage_id) REFERENCES filter_stages(id),
            CONSTRAINT fk_filter_stage_reco_product FOREIGN KEY (product_id) REFERENCES products(id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $columns = [
        'variant_id' => "INT NULL",
        'basket_count' => "INT NULL",
        'amount_min_kg' => "DECIMAL(6,2) NULL",
        'amount_max_kg' => "DECIMAL(6,2) NULL",
        'recommended_product_id' => "INT NULL",
        'calc_json' => "LONGTEXT NULL",
        'cache_updated_at' => "DATETIME NULL",
    ];
    foreach ($columns as $name => $ddl) {
        if (!admin_column_exists($pdo, 'filters', $name)) {
            $pdo->exec("ALTER TABLE filters ADD COLUMN {$name} {$ddl}");
        }
    }

    if (!admin_index_exists($pdo, 'filters', 'idx_filters_variant_id')) {
        $pdo->exec("CREATE UNIQUE INDEX idx_filters_variant_id ON filters (variant_id)");
    }
    if (!admin_index_exists($pdo, 'filters', 'idx_filters_recommended_product')) {
        $pdo->exec("CREATE INDEX idx_filters_recommended_product ON filters (recommended_product_id)");
    }
}

function load_stage_rows(PDO $pdo, int $variantId): array
{
    $stmt = $pdo->prepare(
        "SELECT s.id AS stage_id,
                s.stage_order,
                s.stage_type,
                s.basket_index,
                s.basket_volume_l,
                s.fill_factor,
                s.note AS stage_note,
                r.id AS reco_id,
                r.product_id AS reco_product_id,
                r.amount_kg_per_basket AS reco_amount_kg_per_basket,
                r.amount_min_kg AS reco_amount_min_kg,
                r.amount_max_kg AS reco_amount_max_kg,
                r.recommendation_note AS reco_note
         FROM filter_stages s
         LEFT JOIN filter_stage_recommendations r ON r.stage_id = s.id
         WHERE s.variant_id = ?
         ORDER BY s.stage_order ASC, s.id ASC"
    );
    $stmt->execute([$variantId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function rebuild_filter_cache_row(PDO $pdo, int $filterId, string $productNameCol): void
{
    $safeProductNameCol = str_replace('`', '``', $productNameCol);
    $variantStmt = $pdo->prepare(
        "SELECT f.id AS filter_id,
                f.title AS filter_title,
                f.description AS filter_description,
                f.image_url,
                f.video_url,
                f.is_featured,
                v.id AS variant_id,
                v.variant_name,
                v.slug AS variant_slug,
                v.basket_count,
                v.total_media_volume_l,
                v.default_basket_volume_l,
                m.id AS model_id,
                m.name AS model_name,
                m.type_id,
                m.brand_id
         FROM filters f
         LEFT JOIN filter_variants v ON v.id = f.variant_id
         LEFT JOIN filter_models m ON m.id = v.model_id
         WHERE f.id = ?
         LIMIT 1"
    );
    $variantStmt->execute([$filterId]);
    $row = $variantStmt->fetch(PDO::FETCH_ASSOC);
    if (!$row || empty($row['variant_id'])) {
        return;
    }

    $stageStmt = $pdo->prepare(
        "SELECT s.stage_order,
                s.stage_type,
                s.basket_index,
                s.basket_volume_l,
                s.fill_factor,
                s.note,
                r.product_id,
                r.amount_kg_per_basket,
                r.amount_min_kg,
                r.amount_max_kg,
                r.recommendation_note,
                p.`{$safeProductNameCol}` AS product_name
         FROM filter_stages s
         LEFT JOIN filter_stage_recommendations r ON r.stage_id = s.id
         LEFT JOIN products p ON p.id = r.product_id
         WHERE s.variant_id = ?
         ORDER BY s.stage_order ASC, s.id ASC"
    );
    $stageStmt->execute([(int) $row['variant_id']]);
    $stages = $stageStmt->fetchAll(PDO::FETCH_ASSOC);

    $calcStages = [];
    $amountMin = 0.0;
    $amountMax = 0.0;
    $hasAmount = false;
    $bioProducts = [];

    foreach ($stages as $stage) {
        $reco = null;
        if (!empty($stage['product_id'])) {
            $reco = [
                'product_id' => (int) $stage['product_id'],
                'product_name' => (string) ($stage['product_name'] ?? ''),
                'amount_kg_per_basket' => $stage['amount_kg_per_basket'] !== null ? (float) $stage['amount_kg_per_basket'] : null,
                'amount_min_kg' => $stage['amount_min_kg'] !== null ? (float) $stage['amount_min_kg'] : null,
                'amount_max_kg' => $stage['amount_max_kg'] !== null ? (float) $stage['amount_max_kg'] : null,
                'note' => (string) ($stage['recommendation_note'] ?? ''),
            ];
        }

        $calcStages[] = [
            'order' => (int) $stage['stage_order'],
            'type' => (string) $stage['stage_type'],
            'basket_index' => $stage['basket_index'] !== null ? (int) $stage['basket_index'] : null,
            'basket_volume_l' => $stage['basket_volume_l'] !== null ? (float) $stage['basket_volume_l'] : null,
            'fill_factor' => $stage['fill_factor'] !== null ? (float) $stage['fill_factor'] : null,
            'note' => (string) ($stage['note'] ?? ''),
            'recommendation' => $reco,
        ];

        if ((string) $stage['stage_type'] !== 'biohome') {
            continue;
        }

        if (!empty($stage['product_id'])) {
            $bioProducts[] = (int) $stage['product_id'];
        }

        if ($stage['amount_min_kg'] !== null) {
            $amountMin += (float) $stage['amount_min_kg'];
            $hasAmount = true;
        } elseif ($stage['amount_kg_per_basket'] !== null) {
            $amountMin += (float) $stage['amount_kg_per_basket'];
            $hasAmount = true;
        }

        if ($stage['amount_max_kg'] !== null) {
            $amountMax += (float) $stage['amount_max_kg'];
            $hasAmount = true;
        } elseif ($stage['amount_kg_per_basket'] !== null) {
            $amountMax += (float) $stage['amount_kg_per_basket'];
            $hasAmount = true;
        }
    }

    $uniqueProducts = array_values(array_unique($bioProducts));
    $recommendedProductId = count($uniqueProducts) === 1 ? (int) $uniqueProducts[0] : null;

    if (!$hasAmount) {
        $amountMin = null;
        $amountMax = null;
    }

    $calc = [
        'variant_id' => (int) $row['variant_id'],
        'basket_count' => $row['basket_count'] !== null ? (int) $row['basket_count'] : null,
        'total_media_volume_l' => $row['total_media_volume_l'] !== null ? (float) $row['total_media_volume_l'] : null,
        'default_basket_volume_l' => $row['default_basket_volume_l'] !== null ? (float) $row['default_basket_volume_l'] : null,
        'stages' => $calcStages,
    ];

    $update = $pdo->prepare(
        "UPDATE filters
         SET type_id = ?,
             brand_id = ?,
             basket_count = ?,
             amount_min_kg = ?,
             amount_max_kg = ?,
             recommended_product_id = ?,
             calc_json = ?,
             cache_updated_at = NOW()
         WHERE id = ?"
    );
    $update->execute([
        (int) ($row['type_id'] ?? 0),
        (int) ($row['brand_id'] ?? 0),
        $row['basket_count'] !== null ? (int) $row['basket_count'] : null,
        $amountMin !== null ? round((float) $amountMin, 2) : null,
        $amountMax !== null ? round((float) $amountMax, 2) : null,
        $recommendedProductId,
        json_encode($calc, JSON_UNESCAPED_UNICODE),
        $filterId,
    ]);
}
