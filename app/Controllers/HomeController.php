<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Page;
use App\Models\Setting;

/**
 * Home controller
 */
class HomeController extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        // Handle legacy CMS URLs like ?page=datenschutz via 301 redirect
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $legacyPage = preg_replace('/[^a-zA-Z0-9-_]/', '', $_GET['page']);
            header('Location: /' . $legacyPage, true, 301);
            exit;
        }

        // Load the front page content 
        // In the old system, the front page usually has slug '' or 'home'
        $page = Page::findBySlug('home');
        
        if ($page) {
            // The old CMS saved the entire HTML page (including header/footer) into the content field!
            // We must extract strictly what is inside the <main> tags.
            if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $page['content'], $matches)) {
                $page['content'] = ltrim($matches[1]);
            }
            // If the content still has a stray header tag for some reason, remove it
            $page['content'] = preg_replace('/<header class="site-header">.*?<\/header>/is', '', $page['content']);
        } else {
            // Fallback if 'home' slug is not found
            $page = [
                'title' => 'Willkommen bei Biohome',
                'content' => '<h1>Willkommen bei Biohome</h1><p>Das beste Filtermaterial für Ihr Aquarium und Ihren Teich.</p>',
                'meta_title' => 'Biohome Deutschland',
                'meta_description' => 'Hochleistungs-Filtermaterial für Aquarien und Teiche.'
            ];
        }

        // Get layout data and global settings
        $layout_data = Setting::getLayoutData();
        $settings = $layout_data['settings'];
        
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        // Fetch dynamic content pieces for the front-page view
        $slides = \App\Models\Slide::getAll();
        $categories = \App\Models\Category::getAll();
        $featured_products = \App\Models\Product::getFeatured(6);

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'layout_data' => $layout_data,
            'slides' => $slides,
            'categories' => $categories,
            'featured_products' => $featured_products,
            'activeTheme' => $activeTheme,
            'content_view' => 'Home/index.php' // The specific view to inject into the layout
        ]);
    }
}
