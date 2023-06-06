<?php

namespace App\Classes\Http;

class RequestHandler
{

    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function handleRequest(): Response {
        global $projectRoot;

        // get path
        $path = $this->getPath();

        $routes = require $projectRoot . 'src/routes.php';

        // if route exists display
        if(array_key_exists($path, $routes)) {
            // include the related file
            $route = $routes[$path];

            // ensure we have the right request method
            if(!in_array($this->request->getMethod(), $route['methods'])) {
                return new Response(405, "<h2>405 - Method not allowed</h2>");
            }

            // if route requires authentication, redirect
            if($route['auth'] && !check24UserIsLoggedIn()) {
                check24Redirect('/auth', ['message_type' => 'info', 'messages' => 'Please log in']);
            }

            return $this->handleRouteAction($route);
        } else {
            return new Response(404, "<h2>404 Not Found</h2>");
        }
    }

    private function getPath(): ?string
    {
        $path = $this->request->getUri();

        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }

        return $path;
    }

    private function handleRouteAction(array $route): Response
    {
        $class = $route['action'][0];
        $action = $route['action'][1];

        return (new $class)->{$action}();
    }

}