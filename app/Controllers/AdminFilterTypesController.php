<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

require_once __DIR__ . '/admin_filter_helpers.php';


class AdminFilterTypesController extends Controller
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
    $description = trim((string) ($_POST['description'] ?? ''));
    $position = (int) ($_POST['position'] ?? 0);

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
            $sql = "SELECT COUNT(*) FROM filter_types WHERE slug = ?";
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
                    $stmt = $db->prepare("UPDATE filter_types SET name = ?, slug = ?, description = ?, position = ? WHERE id = ?");
                    $stmt->execute([$name, $slug, $description, $position, $id]);
                    $msg = 'Filterart gespeichert.';
                } else {
                    $stmt = $db->prepare("INSERT INTO filter_types (name, slug, description, position) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $slug, $description, $position]);
                    $msg = 'Filterart angelegt.';
                }
                $action = 'list';
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id']) && $error === '') {
    $id = (int) $_GET['id'];
    $db->prepare("UPDATE filters SET type_id = NULL WHERE type_id = ?")->execute([$id]);
    $db->prepare("DELETE FROM filter_types WHERE id = ?")->execute([$id]);
    header('Location: /admin/filter_types?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) {
    $msg = 'Filterart geloescht.';
}

$type = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM filter_types WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);
    $type = $stmt->fetch();
}

$types = [];
try {
    $types = $db->query(
        "SELECT t.*, COUNT(f.id) AS filter_count
         FROM filter_types t
         LEFT JOIN filters f ON f.type_id = t.id
         GROUP BY t.id
         ORDER BY t.position ASC, t.name ASC"
    )->fetchAll();
} catch (PDOException $e) {
    $types = [];
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/filter_types.php';
        $args['admin_page'] = 'admin/filter-types';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
