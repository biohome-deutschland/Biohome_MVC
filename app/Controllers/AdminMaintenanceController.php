<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class AdminMaintenanceController extends Controller
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
        // Get current route name to highlight sidebar
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        // e.g., 'Biohome_MVC/Biohome_New_App/public/admin/migration'
        
        $admin_page = 'admin'; // fallback
        $title = 'Wartungsbereich';
        
        if (strpos($uri, 'migration') !== false) {
            $admin_page = 'admin/migration';
            $title = 'Migration';
        } elseif (strpos($uri, 'theme-import') !== false) {
            $admin_page = 'admin/theme-import';
            $title = 'Theme Import';
        } elseif (strpos($uri, 'export') !== false) {
            $admin_page = 'admin/export';
            $title = 'Export (SQL)';
        }

        View::renderTemplate('Admin/Layouts/main.php', [
            'title' => $title,
            'admin_page' => $admin_page,
            'content_view' => 'Admin/maintenance.php'
        ]);
    }
}
