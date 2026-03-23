<?php

// Dashboard Route
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('index.php', ['controller' => 'HomeController', 'action' => 'index']);

// Products (Catalog and Details)
$router->add('produkte', ['controller' => 'ProductController', 'action' => 'index']);
$router->add('produkt/{id:\d+}', ['controller' => 'ProductController', 'action' => 'show']);
$router->add('produkt-finder', ['controller' => 'ProductFinderController', 'action' => 'index']);

// Admin
$router->add('admin', ['controller' => 'AdminController', 'action' => 'index']);
$router->add('admin/login', ['controller' => 'AdminController', 'action' => 'login']);
$router->add('admin/logout', ['controller' => 'AdminController', 'action' => 'logout']);
$router->add('admin/filter-calculator', ['controller' => 'AdminFilterCalculatorController', 'action' => 'index']);

// Bulk Migrated Admin Routes
$adminEntities = [
    'products' => 'AdminProductsController',
    'pages' => 'AdminPagesController',
    'categories' => 'AdminCategoriesController',
    'filters' => 'AdminFiltersController',
    'filter-types' => 'AdminFilterTypesController',
    'filter-brands' => 'AdminFilterBrandsController',
    'settings' => 'AdminSettingsController',
    'menus' => 'AdminMenusController',
    'slider' => 'AdminSliderController',
    'media' => 'AdminMediaController',
    'migration' => 'AdminMaintenanceController',
    'theme-import' => 'AdminMaintenanceController',
    'export' => 'AdminMaintenanceController'
];

foreach ($adminEntities as $route => $controller) {
    $router->add("admin/{$route}", ['controller' => $controller, 'action' => 'index']);
}

// Tools & Filters
$router->add('filter-calculator', ['controller' => 'FilterController', 'action' => 'index']);
$router->add('filtertypen', ['controller' => 'FilterController', 'action' => 'index']);
$router->add('filter/{id:\d+}', ['controller' => 'FilterController', 'action' => 'show']);

// Contact Form
$router->add('kontakt', ['controller' => 'ContactController', 'action' => 'show']);
$router->add('kontakt/senden', ['controller' => 'ContactController', 'action' => 'send']);

// Static Pages Handler (Catch-all for slugs)
$router->add('{slug:[a-zA-Z0-9-_\/\.]+}', ['controller' => 'PageController', 'action' => 'show']);
