<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

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
        View::renderTemplate('Home/index.php', [
            'name'    => 'Biohome User',
            'colors'  => ['red', 'green', 'blue']
        ]);
    }
}
