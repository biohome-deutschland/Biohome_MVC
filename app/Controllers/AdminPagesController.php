<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminPagesController extends Controller
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



// 1. Authentifizierung & Konfiguration




$msg = '';
$error = '';
$action = $_GET['action'] ?? 'list';
$tinymce_key = '';
$tinymce_notice = '';
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

// --- SPEICHERN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $slug = trim($_POST['slug']);
    $title = trim($_POST['title']);
    $content = $_POST['content'];

    if (empty($title) || empty($slug)) {
        $error = "Titel und URL-Slug sind Pflichtfelder.";
    } else {
        if ($id) {
            // Update
            $stmt = $db->prepare("UPDATE pages SET title=?, slug=?, content=? WHERE id=?");
            if ($stmt->execute([$title, $slug, $content, $id])) {
                $msg = "Seite gespeichert.";
            }
        } else {
            // Neu
            // Prüfen ob Slug existiert
            $check = $db->prepare("SELECT COUNT(*) FROM pages WHERE slug = ?");
            $check->execute([$slug]);
            if ($check->fetchColumn() > 0) {
                $error = "Eine Seite mit der URL '$slug' existiert bereits.";
            } else {
                $stmt = $db->prepare("INSERT INTO pages (title, slug, content) VALUES (?, ?, ?)");
                if ($stmt->execute([$title, $slug, $content])) {
                    $msg = "Seite angelegt.";
                    $action = 'list'; // Zurück zur Übersicht
                }
            }
        }
    }
}

// --- LÖSCHEN ---
if ($action === 'delete' && isset($_GET['id'])) {
    $stmt = $db->prepare("DELETE FROM pages WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header('Location: /admin/pages?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) $msg = "Seite gelöscht.";

// --- DATEN LADEN (Edit) ---
$page = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $page = $stmt->fetch();
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/pages.php';
        $args['admin_page'] = 'admin/pages';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
