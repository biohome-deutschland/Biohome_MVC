<?php

namespace Core;

/**
 * View template engine
 */
class View
{
    /**
     * Render a view file
     *
     * @param string $view  The view file path relative to App/Views
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = __DIR__ . "/../app/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }

    /**
     * Render a view template using basic PHP layout wrapping
     * (A simple custom implementation. In the future this could be replaced with Twig or Blade)
     */
    public static function renderTemplate($view, $args = [])
    {
        // For basic templating, we just use standard require for now.
        static::render($view, $args);
    }
}
