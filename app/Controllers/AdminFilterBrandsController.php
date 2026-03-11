<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

require_once __DIR__ . '/admin_filter_helpers.php';


class AdminFilterBrandsController extends Controller
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





$action = $_GET['action'] ?? 'list';
$msg = '';
$error = '';

try {
    ensure_filter_schema($db);
} catch (PDOException $e) {
    $error = 'Filter-Tabellen konnten nicht angelegt werden: ' . $e->getMessage();
}

$slugify = static function (string $value): string {
    $map = [
        'ä' => 'ae',
        'ö' => 'oe',
        'ü' => 'ue',
        'Ä' => 'ae',
        'Ö' => 'oe',
        'Ü' => 'ue',
        'ß' => 'ss',
    ];
    $value = strtr($value, $map);
    $value = strtolower($value);
    $value = preg_replace('/[^a-z0-9]+/i', '-', $value) ?? '';
    return trim($value, '-');
};

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error === '') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $name = trim((string) ($_POST['name'] ?? ''));
    $slug = trim((string) ($_POST['slug'] ?? ''));
    $website = trim((string) ($_POST['website'] ?? ''));

    if ($name === '') {
        $error = 'Der Name darf nicht leer sein.';
    } else {
        if ($slug === '') {
            $slug = $slugify($name);
        }

        if ($slug === '') {
            $error = 'Der Slug konnte nicht erzeugt werden.';
        } else {
            $params = [$slug];
            $sql = "SELECT COUNT(*) FROM filter_brands WHERE slug = ?";
            if ($id > 0) {
                $sql .= " AND id != ?";
                $params[] = $id;
            }
            $check = $db->prepare($sql);
            $check->execute($params);

            if ((int) $check->fetchColumn() > 0) {
                $error = 'Dieser Slug ist bereits vergeben.';
            } else {
                if ($id > 0) {
                    $stmt = $db->prepare("UPDATE filter_brands SET name = ?, slug = ?, website = ? WHERE id = ?");
                    $stmt->execute([$name, $slug, $website !== '' ? $website : null, $id]);
                    $msg = 'Hersteller gespeichert.';
                } else {
                    $stmt = $db->prepare("INSERT INTO filter_brands (name, slug, website) VALUES (?, ?, ?)");
                    $stmt->execute([$name, $slug, $website !== '' ? $website : null]);
                    $msg = 'Hersteller angelegt.';
                }
                $action = 'list';
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id']) && $error === '') {
    $id = (int) $_GET['id'];
    $db->prepare("UPDATE filters SET brand_id = NULL WHERE brand_id = ?")->execute([$id]);
    $db->prepare("DELETE FROM filter_brands WHERE id = ?")->execute([$id]);
    header('Location: /admin/filter_brands?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) {
    $msg = 'Hersteller geloescht.';
}

$brand = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM filter_brands WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);
    $brand = $stmt->fetch();
}

$brands = [];
try {
    $brands = $db->query(
        "SELECT b.*, COUNT(f.id) AS filter_count
         FROM filter_brands b
         LEFT JOIN filters f ON f.brand_id = b.id
         GROUP BY b.id
         ORDER BY b.name ASC"
    )->fetchAll();
} catch (PDOException $e) {
    $brands = [];
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/filter_brands.php';
        $args['admin_page'] = 'admin/filter-brands';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
