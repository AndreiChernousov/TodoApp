<?php
namespace App;
class Router
{
    private array $routes = [];

    public function addRoute(string $pattern, string $controller, string $action) : void
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function addRoutes(array $routes) : self
    {
        foreach ($routes as $route) {
            $this->addRoute($route['pattern'], $route['controller'], $route['action']);
        }

        return $this;
    }

    public function run() : void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $appPath = str_replace('/public/index.php', '',$_SERVER['SCRIPT_NAME']);
        $uri = str_replace($appPath, '', $uri);

        $uri = explode('?', $uri)[0];
        $uri = rtrim($uri, '/');

        foreach ($this->routes as $route) {
            if ($route['pattern'] === $uri) {
                $controller = 'App\\Controllers\\' . $route['controller'] . 'Controller';
                $action = $route['action'];
                if(!method_exists($controller, $action)) {
                    $this->send404();
                    return;
                }
                (new $controller())->{$route['action']}();
                return;
            }
        }
        $this->send404();
    }
    private function send404() : void
    {
        header('HTTP/1.0 404 Not Found');
        include '../templates/404.php';
    }
}