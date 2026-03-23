<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use PDO;
use PDOException;

class AdminSettingsController extends Controller
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'site_name' => trim($_POST['site_name'] ?? ''),
        'site_tagline' => trim($_POST['site_tagline'] ?? ''),
        'admin_email' => trim($_POST['admin_email'] ?? ''),
        'active_theme' => $_POST['active_theme'] ?? 'Biohome-v3',
        'company_email' => trim($_POST['company_email'] ?? ''),
        'company_phone' => trim($_POST['company_phone'] ?? ''),
        'company_address' => trim($_POST['company_address'] ?? ''),
        'footer_text' => trim($_POST['footer_text'] ?? ''),
        'footer_layout' => $_POST['footer_layout'] ?? 'standard',
        'footer_align' => $_POST['footer_align'] ?? 'left',
        'footer_spacing' => $_POST['footer_spacing'] ?? 'normal',
        'footer_show_products' => isset($_POST['footer_show_products']) ? '1' : '0',
        'footer_show_navigation' => isset($_POST['footer_show_navigation']) ? '1' : '0',
        'footer_show_contact' => isset($_POST['footer_show_contact']) ? '1' : '0',
        'footer_show_social' => isset($_POST['footer_show_social']) ? '1' : '0',
        'tinymce_api_key' => trim($_POST['tinymce_api_key'] ?? ''),
        'social_facebook' => trim($_POST['social_facebook'] ?? ''),
        'social_youtube' => trim($_POST['social_youtube'] ?? ''),
        'social_instagram' => trim($_POST['social_instagram'] ?? ''),
    ];

    foreach ($settings as $key => $val) {
        $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $val, $val]);
    }
    $msg = "Einstellungen gespeichert.";
}

function get_set(PDO $db, string $key, string $default = ''): string {
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $value = $stmt->fetchColumn();
    return $value !== false ? (string) $value : $default;
}

$site_name = get_set($db, 'site_name', 'Biohome');
$site_tagline = get_set($db, 'site_tagline', '');
$admin_email = get_set($db, 'admin_email', '');
$active_theme = get_set($db, 'active_theme', 'Biohome-v3');

$company_email = get_set($db, 'company_email', '');
$company_phone = get_set($db, 'company_phone', '');
$company_address = get_set($db, 'company_address', '');

$footer_text = get_set($db, 'footer_text', '');
$footer_layout = get_set($db, 'footer_layout', 'standard');
$footer_align = get_set($db, 'footer_align', 'left');
$footer_spacing = get_set($db, 'footer_spacing', 'normal');
$footer_show_products = get_set($db, 'footer_show_products', '1');
$footer_show_navigation = get_set($db, 'footer_show_navigation', '1');
$footer_show_contact = get_set($db, 'footer_show_contact', '1');
$footer_show_social = get_set($db, 'footer_show_social', '1');
$tinymce_api_key = get_set($db, 'tinymce_api_key', '');

$social_fb = get_set($db, 'social_facebook', '');
$social_yt = get_set($db, 'social_youtube', '');
$social_insta = get_set($db, 'social_instagram', '');

$themes = [];
if (is_dir(__DIR__ . '/../../public/themes/')) {
    foreach (scandir(__DIR__ . '/../../public/themes/') as $dir) {
        if ($dir !== '.' && $dir !== '..' && is_dir(__DIR__ . '/../../public/themes/' . $dir)) {
            $themes[] = $dir;
        }
    }
}


        $args = get_defined_vars();
        $args['content_view'] = 'Admin/settings.php';
        $args['admin_page'] = 'admin/settings';
        View::renderTemplate('Admin/Layouts/main.php', $args);
    }
}
