<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminCategoriesController extends Controller
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



// Zugriff auf $db sicherstellen


$error = '';
$msg = '';

// --- LOGIK: NEUE KATEGORIE ANLEGEN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    
    if (empty($name)) {
        $error = "Der Name darf nicht leer sein.";
    } else {
        // Slug automatisch erstellen (z.B. "Teich & Filter" -> "teich-filter")
        // 1. Umlaute ersetzen
        $slug = str_replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'], $name);
        // 2. Alles klein, Sonderzeichen weg
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
        
        // Prüfen ob Slug schon existiert, um Fehler zu vermeiden
        $check = $db->prepare("SELECT COUNT(*) FROM categories WHERE slug = ?");
        $check->execute([$slug]);
        
        if ($check->fetchColumn() > 0) {
            $error = "Eine Kategorie mit diesem URL-Namen ($slug) existiert bereits.";
        } else {
            $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
            if ($stmt->execute([$name, $slug])) {
                $msg = "Kategorie '$name' erfolgreich angelegt.";
            } else {
                $error = "Datenbankfehler beim Anlegen.";
            }
        }
    }
}

// --- LOGIK: LÖSCHEN ---
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // 1. Verknüpfungen löschen (Produkte verlieren diese Kategorie, werden aber NICHT gelöscht)
    $db->prepare("DELETE FROM product_categories WHERE category_id=?")->execute([$id]);
    
    // 2. Kategorie selbst löschen
    $db->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
    
    // Redirect, um Neuladen zu verhindern
    header('Location: /admin/categories?deleted=true');
    exit;
}

if (isset($_GET['deleted'])) {
    $msg = "Kategorie wurde gelöscht.";
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/categories.php';
        $args['admin_page'] = 'admin/categories';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
