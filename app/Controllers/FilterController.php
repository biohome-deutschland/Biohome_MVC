<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use App\Models\Setting;

/**
 * Filter controller
 */
class FilterController extends Controller
{
    /**
     * Show the filter catalog
     *
     * @return void
     */
    public function indexAction()
    {
        $db = \Core\Model::getDB();
        
        $filter_types = $db->query("SELECT * FROM filter_types ORDER BY position ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);
        $filter_brands = $db->query("SELECT * FROM filter_brands ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

        $active_type_slug = $_GET['type'] ?? '';
        $active_brand_slug = $_GET['brand'] ?? '';

        $active_filter_type = null;
        if ($active_type_slug) {
            foreach ($filter_types as $type) {
                if ($type['slug'] === $active_type_slug) {
                    $active_filter_type = $type;
                    break;
                }
            }
        }

        $active_filter_brand = null;
        if ($active_brand_slug) {
            foreach ($filter_brands as $brand) {
                if ($brand['slug'] === $active_brand_slug) {
                    $active_filter_brand = $brand;
                    break;
                }
            }
        }

        $active_type_id = $active_filter_type['id'] ?? null;
        $active_brand_id = $active_filter_brand['id'] ?? null;

        $filters = [];
        $available_brands = $filter_brands;

        try {
            $sql = "SELECT f.*, t.name AS type_name, b.name AS brand_name
                    FROM filters f
                    LEFT JOIN filter_types t ON f.type_id = t.id
                    LEFT JOIN filter_brands b ON f.brand_id = b.id";
            $where = [];
            $params = [];

            if ($active_type_id) {
                $where[] = "f.type_id = ?";
                $params[] = $active_type_id;
            }
            if ($active_brand_id) {
                $where[] = "f.brand_id = ?";
                $params[] = $active_brand_id;
            }
            if ($where) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }
            $sql .= " ORDER BY f.is_featured DESC, f.id DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $filters = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($active_type_id) {
                $stmt = $db->prepare(
                    "SELECT DISTINCT b.*
                     FROM filter_brands b
                     JOIN filters f ON f.brand_id = b.id
                     WHERE f.type_id = ?
                     ORDER BY b.name ASC"
                );
                $stmt->execute([$active_type_id]);
                $available_brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (\PDOException $e) {
            $filters = [];
        }

        $page = [
            'title' => $active_filter_type['name'] ?? 'Filtertypen',
            'description' => $active_filter_type['description'] ?? 'Finden Sie den passenden Filter und die optimale Biohome-Bestückung.'
        ];
        if ($active_filter_brand) {
            $page['title'] = $active_filter_brand['name'] . ' - ' . $page['title'];
        }

        $settings = Setting::getAll();
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'activeTheme' => $activeTheme,
            'filters' => $filters,
            'filter_types' => $filter_types,
            'available_brands' => $available_brands,
            'active_filter_type' => $active_filter_type,
            'active_filter_brand' => $active_filter_brand,
            'content_view' => 'Filter/index.php'
        ]);
    }

    /**
     * Show single filter details
     */
    public function showAction()
    {
        $id = $this->route_params['id'] ?? null;
        $db = \Core\Model::getDB();

        $filter = null;
        if ($id) {
            $stmt = $db->prepare(
                "SELECT f.*,
                        t.name AS type_name,
                        b.name AS brand_name
                 FROM filters f
                 LEFT JOIN filter_types t ON f.type_id = t.id
                 LEFT JOIN filter_brands b ON f.brand_id = b.id
                 WHERE f.id = ?"
            );
            $stmt->execute([(int)$id]);
            $filter = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        if (!$filter) {
            header("HTTP/1.0 404 Not Found");
            $page = [
                'title' => 'Filter nicht gefunden',
                'content' => '<p>Das angeforderte Modell existiert nicht.</p>'
            ];
        } else {
            $page = [
                'title' => $filter['title']
            ];
        }

        $settings = Setting::getAll();
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'activeTheme' => $activeTheme,
            'filter' => $filter,
            'content_view' => 'Filter/show.php'
        ]);
    }
}
