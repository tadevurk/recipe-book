<?php
class ArrayRouter {
    public function route($uri) {
        // defining routes
        $routes = array(
            '' => array(
                'controllers' => 'homecontroller',
                'method' => 'index'
            ),
            'about' => array(
                'controllers' => 'homecontroller',
                'method' => 'about'
            ),
        );

        // deal with undefined paths first
        if(!isset($routes[$uri]['controllers']) || !isset($routes[$uri]['method'])) {
            http_response_code(404);
            die();
        }

        // dynamically instantiate controllers and method
        $controller = $routes[$uri]['controllers'];
        $method = $routes[$uri]['method'];

        require __DIR__ . '/controllers/' . $controller . '.php';
        $controllerObj = new $controller;
        $controllerObj->$method();
    }
}
?>