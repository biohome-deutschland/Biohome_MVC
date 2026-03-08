<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminMediaController extends Controller
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




// KONFIGURATION:
// Wir gehen vom admin-Ordner eins hoch (../) in assets/images/
$uploadDir = __DIR__ . '/../assets/images/'; 
$uploadUrl = 'assets/images/'; // Relativer Pfad für die Datenbank/HTML

// Sicherheits-Check: Existiert der Ordner?
$folderError = '';
if (!is_dir($uploadDir)) {
    $folderError = "ACHTUNG: Der Ordner <code>assets/images</code> wurde nicht gefunden.<br>Bitte prüfen Sie per FTP, ob der Pfad existiert.";
}

$msg = '';
$error = '';

// --- UPLOAD LOGIK ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $file = $_FILES['file_upload'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'];
        
        if (in_array($ext, $allowed)) {
            // Dateinamen bereinigen (Leerzeichen zu Bindestrichen, alles klein)
            $cleanName = preg_replace('/[^a-z0-9\-\.]/i', '-', pathinfo($file['name'], PATHINFO_FILENAME));
            $filename = $cleanName . '.' . $ext;
            $targetPath = $uploadDir . $filename;
            
            // Datei verschieben
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $msg = "Datei erfolgreich hochgeladen: $filename";
            } else {
                $error = "Fehler beim Speichern. Prüfen Sie die Schreibrechte (CHMOD) des Ordners 'assets/images'.";
            }
        } else {
            $error = "Ungültiges Format. Erlaubt: Bilder (JPG, PNG, GIF, WEBP, SVG) und PDF.";
        }
    } else {
        $error = "Upload-Fehler Code: " . $file['error'];
    }
}

// --- LÖSCHEN LOGIK ---
if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']); // Schutz vor Pfad-Manipulation
    $fullPath = $uploadDir . $fileToDelete;
    
    if (file_exists($fullPath)) {
        unlink($fullPath);
        // Redirect um erneutes Löschen beim Neuladen zu verhindern
        header('Location: /admin/media?deleted=true');
        exit;
    }
}

if (isset($_GET['deleted'])) $msg = "Datei wurde gelöscht.";

// --- DATEIEN EINLESEN ---
$files = [];
if (is_dir($uploadDir)) {
    // Glob sucht nach allen passenden Dateiendungen im images-Ordner
    $files = glob($uploadDir . '*.{jpg,jpeg,png,gif,webp,svg,pdf}', GLOB_BRACE);
    
    // Sortieren: Neueste zuerst
    if ($files) {
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
    }
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/media.php';
        $args['admin_page'] = 'admin/media';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
