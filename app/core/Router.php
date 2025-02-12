<?php
namespace app\core;

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Request.php';
use app\helper\Helper;

class Router
{
    private $routes = [];

    // Ajouter une route
    public function add($method, $path, $controllerAction)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => trim($path, '/'),
            'controller' => $controllerAction[0],
            'action' => $controllerAction[1]
        ];
    }

    // Ajouter une route GET
    public function get($path, $controllerAction)
    {
        $this->add('GET', $path, $controllerAction);
    }

    // Ajouter une route POST
    public function post($path, $controllerAction)
    {
        $this->add('POST', $path, $controllerAction);
    }

    // Dispatcher la requête
    public function dispatch($requestUri, $requestMethod)
    {
        $requestPath = trim(parse_url($requestUri, PHP_URL_PATH), '/');
        $requestMethod = strtoupper($requestMethod);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                $controllerClass = $route['controller'];
                $action = $route['action'];
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        return call_user_func([$controller, $action]);
                    } else {
                        throw new \Exception("Méthode {$action} non trouvée dans {$controllerClass}");
                    }
                } else {
                    throw new \Exception("Contrôleur {$controllerClass} non trouvé");
                }
            }
        }

        // Si aucune route ne correspond
        http_response_code(404);
        require '../app/views/404.php';
    }
}
