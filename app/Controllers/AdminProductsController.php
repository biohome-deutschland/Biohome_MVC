<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminProductsController extends Controller
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
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $cats = $_POST['categories'] ?? [];
    
    // Bild-Logik:
    // 1. Alten Wert behalten
    $img = $_POST['image_url_current'] ?? '';
    
    // 2. Wurde manuell was eingetippt? Dann nimm das.
    if (!empty($_POST['image_url_manual'])) {
        $img = trim($_POST['image_url_manual']);
    }

    // 3. Wurde eine Datei hochgeladen? Dann überschreibe alles.
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/images/';
        // Sicherstellen, dass Ordner da ist
        if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
        
        $ext = strtolower(pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($ext, $allowed)) {
            // Sauberer Dateiname: produkt-zeitstempel.ext
            $filename = 'prod_' . time() . '_' . rand(100,999) . '.' . $ext;
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $uploadDir . $filename)) {
                $img = 'assets/images/' . $filename; // Der Pfad für die DB
            } else {
                $error = "Fehler beim Bild-Upload (Rechte prüfen?).";
            }
        } else {
            $error = "Nur Bilder erlaubt (JPG, PNG, WEBP).";
        }
    }

    if (!$error) {
        if ($id) {
            $stmt = $db->prepare("UPDATE products SET title=?, description=?, image_url=? WHERE id=?");
            $stmt->execute([$title, $desc, $img, $id]);
            // Kategorien neu
            $db->prepare("DELETE FROM product_categories WHERE product_id=?")->execute([$id]);
            foreach($cats as $catId) $db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)")->execute([$id, $catId]);
            $msg = "Produkt gespeichert.";
        } else {
            $stmt = $db->prepare("INSERT INTO products (title, description, image_url) VALUES (?, ?, ?)");
            $stmt->execute([$title, $desc, $img]);
            $newId = $db->lastInsertId();
            foreach($cats as $catId) $db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)")->execute([$newId, $catId]);
            $msg = "Produkt angelegt.";
        }
        $action = 'list';
    }
}

// --- LÖSCHEN ---
if ($action === 'delete' && isset($_GET['id'])) {
    $delId = $_GET['id'];
    $db->prepare("DELETE FROM product_categories WHERE product_id=?")->execute([$delId]);
    $db->prepare("DELETE FROM products WHERE id=?")->execute([$delId]);
    header('Location: /admin/products?deleted=true'); exit;
}
if (isset($_GET['deleted'])) $msg = "Produkt gelöscht.";

// --- DATEN LADEN ---
$product = null;
$activeCats = [];
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    $stmtCat = $db->prepare("SELECT category_id FROM product_categories WHERE product_id=?");
    $stmtCat->execute([$_GET['id']]);
    $activeCats = $stmtCat->fetchAll(PDO::FETCH_COLUMN);
}
$allCats = $db->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/products.php';
        $args['admin_page'] = 'admin/products';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
