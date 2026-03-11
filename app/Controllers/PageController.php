<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Page;
use App\Models\Setting;

/**
 * Page controller
 */
class PageController extends Controller
{
    /**
     * Show a static page
     *
     * @return void
     */
    public function showAction()
    {
        $slug = $this->route_params['slug'] ?? '';
        
        // Remove .html from legacy URLs to match DB slugs
        $slug = preg_replace('/\.html$/i', '', $slug);
        
        $page = Page::findBySlug($slug);
        
        if (!$page) {
            header("HTTP/1.0 404 Not Found");
            $page = [
                'title' => 'Seite nicht gefunden',
                'content' => '<p>Die angeforderte Seite konnte leider nicht gefunden werden.</p>'
            ];
        } else {
            // Strip any raw HTML headers saved inside the content from the old CMS dump
            if (preg_match('/<main[^>]*>(.*?)<\/main>/is', $page['content'], $matches)) {
                $page['content'] = ltrim($matches[1]);
            }
            $page['content'] = preg_replace('/<header class="site-header">.*?<\/header>/is', '', $page['content']);
        }

        $layout_data = Setting::getLayoutData();
        $settings = $layout_data['settings'];
        $activeTheme = $settings['active_theme'] ?? 'Biohome-v3';

        $view = 'Page/show.php';
        if ($slug === 'kontakt') {
            $view = 'Page/kontakt.php';
        }

        View::renderTemplate('Layouts/main.php', [
            'page' => $page,
            'settings' => $settings,
            'layout_data' => $layout_data,
            'activeTheme' => $activeTheme,
            'content_view' => $view
        ]);
    }
}
