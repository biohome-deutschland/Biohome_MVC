<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Setting;

/**
 * Product Finder controller
 */
class ProductFinderController extends Controller
{
    /**
     * Show the product finder wizard
     *
     * @return void
     */
    public function indexAction()
    {
        $layout_data = Setting::getLayoutData();
        $settings = $layout_data['settings'];
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        View::renderTemplate('Layouts/main.php', [
            'page' => ['title' => 'Produkt-Finder', 'description' => 'Finden Sie in 3 Schritten das passende Biohome Filtermedium für Ihr Aquarium oder Ihren Teich.'],
            'settings' => $settings,
            'layout_data' => $layout_data,
            'activeTheme' => $activeTheme,
            'content_view' => 'Produkte/finder.php'
        ]);
    }
}
