<?php
/**
 * Front Controller
 * 
 * All requests are routed through this file.
 */

// Autoloader for classes
spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load configuration
require_once __DIR__ . '/../config/config.php';

// Load helpers
require_once __DIR__ . '/../Core/Helpers.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize Router
$router = new Core\Router();

// Load routes
require_once __DIR__ . '/../routes/web.php';

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI']);
