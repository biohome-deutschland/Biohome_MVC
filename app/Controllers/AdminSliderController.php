<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminSliderController extends Controller
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




$msg = '';
$error = '';
$action = $_GET['action'] ?? 'list';

// --- SPEICHERN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    // Bild Logik
    $img = $_POST['image_url_current'] ?? '';
    if (!empty($_POST['image_url_manual'])) $img = trim($_POST['image_url_manual']);
    
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/images/';
        if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
        $ext = strtolower(pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION));
        $filename = 'slide_' . time() . '_' . rand(100,999) . '.' . $ext;
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $uploadDir . $filename)) {
            $img = 'assets/images/' . $filename;
        } else {
            $error = "Upload fehlgeschlagen.";
        }
    }

    if (!$error) {
        $data = [
            $img,
            trim($_POST['title']),
            trim($_POST['subtitle']),
            trim($_POST['btn_text']),
            trim($_POST['btn_link']),
            (int)$_POST['position']
        ];

        if ($id) {
            $stmt = $db->prepare("UPDATE slides SET image_url=?, title=?, subtitle=?, btn_text=?, btn_link=?, position=? WHERE id=?");
            $stmt->execute([...$data, $id]);
            $msg = "Slide gespeichert.";
        } else {
            $stmt = $db->prepare("INSERT INTO slides (image_url, title, subtitle, btn_text, btn_link, position) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($data);
            $msg = "Slide angelegt.";
        }
        $action = 'list';
    }
}

// --- LÖSCHEN ---
if (isset($_GET['delete'])) {
    $db->prepare("DELETE FROM slides WHERE id=?")->execute([$_GET['delete']]);
    header('Location: /admin/slider'); exit;
}

$slide = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM slides WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $slide = $stmt->fetch();
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/slider.php';
        $args['admin_page'] = 'admin/slider';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
