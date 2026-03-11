<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

require_once __DIR__ . '/admin_filter_helpers.php';


class AdminFiltersController extends Controller
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
$tinymce_key = '';
$tinymce_notice = '';

try {
    ensure_filter_schema($db);
} catch (PDOException $e) {
    $error = 'Filter-Tabellen konnten nicht angelegt werden: ' . $e->getMessage();
}

if (defined('TINYMCE_API_KEY') && TINYMCE_API_KEY !== '') {
    $tinymce_key = TINYMCE_API_KEY;
} else {
    try {
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute(['tinymce_api_key']);
        $tinymce_key = (string) $stmt->fetchColumn();
    } catch (PDOException $e) {
        $tinymce_key = '';
    }
}
$tinymce_key = trim($tinymce_key);
if ($tinymce_key === '') {
    $tinymce_key = 'no-api-key';
    $tinymce_notice = 'TinyMCE laeuft mit dem Demo-Key. Hinterlegen Sie einen API Key unter Einstellungen.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error === '') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $title = trim((string) ($_POST['title'] ?? ''));
    $desc = (string) ($_POST['description'] ?? '');
    $type_id = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int) $_POST['type_id'] : null;
    $brand_id = isset($_POST['brand_id']) && $_POST['brand_id'] !== '' ? (int) $_POST['brand_id'] : null;
    $video_url = trim((string) ($_POST['video_url'] ?? ''));
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $img = $_POST['image_url_current'] ?? '';

    if (!empty($_POST['image_url_manual'])) {
        $img = trim((string) $_POST['image_url_manual']);
    }

    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/images/filters/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $ext = strtolower(pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed, true)) {
            $filename = 'filter_' . time() . '_' . rand(100, 999) . '.' . $ext;
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $uploadDir . $filename)) {
                $img = 'assets/images/filters/' . $filename;
            } else {
                $error = 'Fehler beim Bild-Upload (Rechte pruefen?).';
            }
        } else {
            $error = 'Nur Bilder erlaubt (JPG, PNG, WEBP).';
        }
    }

    if ($title === '') {
        $error = 'Der Titel darf nicht leer sein.';
    }

    if ($error === '') {
        if ($id > 0) {
            $stmt = $db->prepare(
                "UPDATE filters SET title = ?, description = ?, image_url = ?, video_url = ?, type_id = ?, brand_id = ?, is_featured = ? WHERE id = ?"
            );
            $stmt->execute([$title, $desc, $img, $video_url !== '' ? $video_url : null, $type_id, $brand_id, $is_featured, $id]);
            $msg = 'Filter gespeichert.';
        } else {
            $stmt = $db->prepare(
                "INSERT INTO filters (title, description, image_url, video_url, type_id, brand_id, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$title, $desc, $img, $video_url !== '' ? $video_url : null, $type_id, $brand_id, $is_featured]);
            $msg = 'Filter angelegt.';
        }
        $action = 'list';
    }
}

if ($action === 'delete' && isset($_GET['id']) && $error === '') {
    $delId = (int) $_GET['id'];
    $db->prepare("DELETE FROM filters WHERE id = ?")->execute([$delId]);
    header('Location: /admin/filters?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) {
    $msg = 'Filter geloescht.';
}

$filter = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM filters WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);
    $filter = $stmt->fetch();
}

$types = [];
$brands = [];
try {
    $types = $db->query("SELECT * FROM filter_types ORDER BY position ASC, name ASC")->fetchAll();
    $brands = $db->query("SELECT * FROM filter_brands ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $types = [];
    $brands = [];
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/filters.php';
        $args['admin_page'] = 'admin/filters';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
