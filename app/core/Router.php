<?php
require_once __DIR__ . '/config.php';
use app\helper\Helper;
class Router
{
    private $routes = [];

    public function add($method, $path, $callback, $roles)
    {
        $this->routes[] = compact('method', 'path', 'callback', "roles");
    }

    public function get($path, $callback, $roles)
    {
        $this->add('GET', $path, $callback, $roles);
    }

    public function post($path, $callback, $roles)
    {
        $this->add('POST', $path, $callback, $roles);
    }

    public function dispatch($request)
    {
        if ($request->getMethod() === 'POST' && !Helper::validateCsrfToken()) {
            Helper::goToPage('/');
        }

        foreach ($this->routes as $route) {
            $isRouteAcceptParam = strpos($route['path'], "/{id}") != false;
            $param = null;
            if ($isRouteAcceptParam) {
                $route['path'] = str_replace('/{id}', '', $route['path']);
                $param = str_replace($route['path'], '', $request->getPath());
            }

            $requestPath = $param ? str_replace($param, '', $request->getPath()) : $request->getPath();
            if (
                $route['method'] === $request->getMethod() &&
                $route['path'] === $requestPath
            ) {
                if (Helper::isLogged()) {
                    // If the user role matched one of the route roles
                    if (!in_array(Helper::getUserRole(), $route['roles'])) {
                        continue;
                    }
                } else {
                    if (!in_array("visitor", $route['roles'])) {
                        Helper::goToPage("login");
                    }
                }


                if (is_callable($route['callback'])) {
                    return call_user_func($route['callback']);
                }

                if (is_array($route['callback'])) {
                    [$controller, $action] = $route['callback'];
                    $controllerInstance = new $controller();
                    return $param != null ? $controllerInstance->$action(str_replace("/", "", $param)) : $controllerInstance->$action();
                }
            }
        }

        Helper::goToPage('/404');
    }
}