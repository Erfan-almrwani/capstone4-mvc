<?php
namespace App\Core;

class Router {
    private $routes = [];
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get($route, $controller) {
        $this->routes['GET'][$route] = $controller;
    }

    public function post($route, $controller) {
        $this->routes['POST'][$route] = $controller;
    }

    public function dispatch() {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        

        if (isset($this->routes[$method][$url])) {
            $controllerAction = $this->routes[$method][$url];
            
            list($controller, $action) = explode('@', $controllerAction);
            $controller = "App\\Controllers\\" . $controller;
            
            
            if (class_exists($controller)) {
                $controllerObject = new $controller();
                
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action not found in controller $controller");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            // الصفحة غير موجودة
            http_response_code(404);
            echo "Page not found - URL: '$url', Method: '$method'<br>";
            echo "Available GET routes: " . implode(', ', array_keys($this->routes['GET'] ?? [])) . "<br>";
            echo "Available POST routes: " . implode(', ', array_keys($this->routes['POST'] ?? [])) . "<br>";
        }
    }
}
?>