<?php
declare(strict_types=1);

// 1. Authentifizierung & Config
require __DIR__ . '/../inc/bootstrap.php';
require_admin();
require_once __DIR__ . '/../config.php';

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
        header('Location: media.php?deleted=true');
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
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medien | Biohome Admin</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* Galerie-Ansicht */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .media-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s;
        }
        .media-item:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        
        .media-preview {
            height: 140px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px;
        }
        .media-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .file-icon { font-size: 2.5rem; color: #cbd5e1; font-weight: bold; }
        
        .media-details { padding: 10px; font-size: 0.85rem; }
        .media-name { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 8px; 
            color: #334155; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
        }
        
        .btn-group { display: flex; gap: 5px; }
        .action-btn {
            flex: 1;
            padding: 6px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            font-size: 0.8rem;
            text-decoration: none;
        }
        .btn-copy { background: #e0f2fe; color: #0284c7; }
        .btn-copy:hover { background: #bae6fd; }
        
        .btn-del { background: #fee2e2; color: #b91c1c; }
        .btn-del:hover { background: #fecaca; }
    </style>
    <script>
        function copyPath(path) {
            navigator.clipboard.writeText(path).then(function() {
                alert('Pfad kopiert:\n' + path);
            }, function(err) {
                console.error('Konnte Text nicht kopieren: ', err);
            });
        }
    </script>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">Bio<span>home</span></div>
        <ul class="nav">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="pages.php">Seiten verwalten</a></li>
            <li><a href="menus.php">Navigation</a></li>
            <!-- Aktiv -->
            <li><a href="media.php" class="active" style="color:var(--primary);">★ Medien (Assets)</a></li>
            <li><a href="products.php">Produkte</a></li>
            <li><a href="categories.php">Kategorien</a></li>
            <li><a href="settings.php">Einstellungen</a></li>
            <li><a href="theme_import.php">Theme Import</a></li>
            <li><a href="export.php">Export (SQL)</a></li>
        </ul>
        <div class="nav-footer">
            <a href="logout.php" style="color:var(--danger);">&larr; Abmelden</a>
        </div>
    </aside>

    <main class="main">
        <div class="header">
            <h1>Medienverwaltung</h1>
            <span style="font-size:0.9rem; color:#64748b;">Ordner: /assets/images/</span>
        </div>

        <?php if($folderError): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;">
                <?php echo $folderError; ?>
            </div>
        <?php endif; ?>

        <?php if($msg): ?>
            <div style="background:#dcfce7; color:#166534; padding:15px; border-radius:6px; margin-bottom:20px; border:1px solid #bbf7d0;">
                <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:6px; margin-bottom:20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- UPLOAD KARTE -->
        <div class="card" style="padding: 30px; text-align: center; border: 2px dashed #cbd5e1;">
            <h3 style="margin-top:0;">Bilder hochladen</h3>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="file_upload" id="file_upload" style="display:none;" onchange="this.form.submit()">
                <label for="file_upload" class="btn btn-primary">
                    Datei auswählen
                </label>
                <p style="margin-top:10px; font-size:0.85rem; color:#64748b;">
                    Dateien werden direkt in <code>/assets/images/</code> gespeichert.
                </p>
            </form>
        </div>

        <!-- BILDER LISTE -->
        <?php if(empty($files)): ?>
            <p style="text-align:center; color:#94a3b8; margin-top:40px;">
                Der Ordner <code>/assets/images/</code> ist leer oder wurde nicht gefunden.
            </p>
        <?php else: ?>
            <div class="media-grid">
                <?php foreach($files as $filePath): 
                    $fileName = basename($filePath);
                    // Der Pfad für das <img> Tag (geht eins hoch aus admin raus)
                    $previewPath = '../assets/images/' . $fileName;
                    // Der Pfad für die Datenbank (relativ zum Root)
                    $dbPath = 'assets/images/' . $fileName;
                    
                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                ?>
                <div class="media-item">
                    <div class="media-preview">
                        <?php if($isImage): ?>
                            <img src="<?php echo $previewPath; ?>" alt="<?php echo $fileName; ?>" loading="lazy">
                        <?php else: ?>
                            <div class="file-icon"><?php echo strtoupper($ext); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="media-details">
                        <span class="media-name" title="<?php echo $fileName; ?>"><?php echo $fileName; ?></span>
                        <div class="btn-group">
                            <button type="button" class="action-btn btn-copy" onclick="copyPath('<?php echo $dbPath; ?>')">
                                Pfad kopieren
                            </button>
                            <a href="media.php?delete=<?php echo $fileName; ?>" class="action-btn btn-del" onclick="return confirm('Datei wirklich löschen?');">
                                Löschen
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>