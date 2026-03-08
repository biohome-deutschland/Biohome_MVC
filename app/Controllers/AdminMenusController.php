<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminMenusController extends Controller
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



// 1. Authentifizierung & Config




$msg = '';
$error = '';
$action = $_GET['action'] ?? 'list';

function normalize_menu_link(string $link, string $label = ''): string {
    $link = trim(html_entity_decode($link, ENT_QUOTES, 'UTF-8'));
    if ($link === '') {
        return $link;
    }
    $label_lower = strtolower(trim($label));
    if ($label_lower === 'produkte') {
        return '?page=produkte';
    }
    if ($label_lower === 'startseite' || $label_lower === 'home') {
        return 'index.php';
    }
    if (preg_match('/pages\\.php\\?(?:page|slug)=([^&]+)/i', $link, $match)) {
        return '?page=' . $match[1];
    }
    if (preg_match('/index\\.php\\?page=([^&]+)/i', $link, $match)) {
        return '?page=' . $match[1];
    }
    if (preg_match('/\\?page=home\\b/i', $link)) {
        return 'index.php';
    }
    return $link;
}

// --- SPEICHERN (Neu & Edit) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $label = trim($_POST['label']);
    $link = trim($_POST['link']);
    $link = normalize_menu_link($link, $label);
    $position = (int)$_POST['position'];

    if (empty($label) || empty($link)) {
        $error = "Name und Link dürfen nicht leer sein.";
    } else {
        if ($id) {
            // Update
            $stmt = $db->prepare("UPDATE menu_items SET label=?, link=?, position=? WHERE id=?");
            $stmt->execute([$label, $link, $position, $id]);
            $msg = "Menüpunkt aktualisiert.";
        } else {
            // Neu
            $stmt = $db->prepare("INSERT INTO menu_items (label, link, position) VALUES (?, ?, ?)");
            $stmt->execute([$label, $link, $position]);
            $msg = "Menüpunkt hinzugefügt.";
        }
        $action = 'list'; // Zurück zur Liste
    }
}

// --- LÖSCHEN ---
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM menu_items WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header('Location: /admin/menus?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) $msg = "Menüpunkt gelöscht.";

// --- DATEN LADEN (Für Edit) ---
$item = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM menu_items WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $item = $stmt->fetch();
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/menus.php';
        $args['admin_page'] = 'admin/menus';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
