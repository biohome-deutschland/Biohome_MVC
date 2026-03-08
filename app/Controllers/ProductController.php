<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Product;
use App\Models\Page;
use App\Models\Setting;

/**
 * Product controller
 */
class ProductController extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        // Load the products page content (usually slug 'produkte' or similar)
        $page = Page::findBySlug('produkte');
        if (!$page) {
            $page = [
                'title' => 'Unsere Produkte',
                'content' => '<h1>Biohome Filtermaterialien</h1><p>Entdecken Sie unser Sortiment.</p>',
            ];
        }

        // Get global settings
        $settings = Setting::getAll();
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        $categorySlug = $_GET['category'] ?? null;
        $active_category = null;
        
        if ($categorySlug) {
            $db = \Core\Model::getDB();
            $stmt = $db->prepare('SELECT * FROM categories WHERE slug = :slug LIMIT 1');
            $stmt->bindValue(':slug', $categorySlug, \PDO::PARAM_STR);
            $stmt->execute();
            $active_category = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($active_category) {
                $products = Product::findByCategorySlug($categorySlug);
            } else {
                $products = Product::getAll(); // Fallback if category invalid
            }
        } else {
            $products = Product::getAll();
        }

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'activeTheme' => $activeTheme,
            'products' => $products,
            'active_category' => $active_category,
            'content_view' => 'Produkte/index.php'
        ]);
    }

    public function showAction()
    {
        $id = $this->route_params['id'] ?? null;
        if (!$id) {
            header("HTTP/1.0 404 Not Found");
            $page = [
                'title' => 'Fehler',
                'content' => '<p>Produkt-ID fehlt.</p>'
            ];
            $product = null;
        } else {
            $product = Product::findById((int)$id);
            if (!$product) {
                header("HTTP/1.0 404 Not Found");
                $page = [
                    'title' => 'Produkt nicht gefunden',
                    'content' => '<p>Das angeforderte Produkt existiert nicht.</p>'
                ];
            } else {
                $page = [
                    'title' => $product['title']
                ];
            }
        }

        $settings = Setting::getAll();
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'activeTheme' => $activeTheme,
            'product' => $product,
            'content_view' => 'Produkte/show.php'
        ]);
    }
}
