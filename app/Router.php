<?php

class Router {
    private $routes = array();

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            $handler = explode('@', $this->routes[$method][$path]);
            $controllerName = $handler[0];
            $methodName = $handler[1];

            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            echo "Page not found.";
        }
    }
}
