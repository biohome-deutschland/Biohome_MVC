<?php

namespace Core;

class Router
{
    /**
     * Array of routes (routing table)
     * @var array
     */
    protected $routes = [];
    
    /**
     * Add a route to the routing table
     *
     * @param string $route  The route URL
     * @param array  $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    /**
     * Dispatch the route
     *
     * @param string $url The routing URL
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if (array_key_exists($url, $this->routes)) {
            $params = $this->routes[$url];

            $controller = "App\Controllers\\" . $params['controller'];

            if (class_exists($controller)) {
                $controller_object = new $controller();

                $action = $params['action'];

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Method $action (in controller $controller) not found";
                }
            } else {
                echo "Controller class $controller not found";
            }
        } else {
            echo "No route matched for URL: $url";
        }
    }

    /**
     * Remove the query string variables from the URL
     *
     * @param string $url The full URL
     *
     * @return string URL stripped of query string variables
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        
        // Remove trailing slash and leading slash for cleaner matching
        return trim($url, '/');
    }
}
