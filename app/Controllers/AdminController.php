<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

/**
 * Admin controller
 */
class AdminController extends Controller
{
    /**
     * Check authentication before any action
     */
    protected function before()
    {
        $action = $this->route_params['action'] ?? 'index';
        
        // Allow login action without auth
        if ($action === 'login') {
            return true;
        }

        if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Show the admin dashboard
     */
    public function indexAction()
    {
        View::renderTemplate('Admin/Layouts/main.php', [
            'title' => 'Admin Dashboard',
            'admin_page' => 'admin',
            'content_view' => 'Admin/dashboard.php'
        ]);
    }

    /**
     * Handle Login
     */
    public function loginAction()
    {
        // If already logged in, redirect
        if (!empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            header('Location: /admin');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin');
                exit;
            } else {
                $error = 'Login fehlgeschlagen.';
            }
        }

        View::renderTemplate('Admin/login.php', [
            'error' => $error,
            'title' => 'Admin Login'
        ]);
    }

    /**
     * Handle Logout
     */
    public function logoutAction()
    {
        $_SESSION['admin_logged_in'] = false;
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}
