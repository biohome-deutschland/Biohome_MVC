<?php

// Dashboard Route
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('admin', ['controller' => 'AdminController', 'action' => 'index']);
$router->add('filter-calculator', ['controller' => 'FilterController', 'action' => 'index']);
