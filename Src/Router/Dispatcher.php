<?php


namespace App\Router;


class Dispatcher {

    private $router;

    function __construct() {
        $this->router = new Router();
    }

    public final function dispatch() {
        $this->router->run(
            $_SERVER['REQUEST_METHOD'],
            $this->pathFromUri($_SERVER['REQUEST_URI']),
            $_REQUEST);
    }

    public final function addRoute($method,$pattern, $action) {
        $this->router->addRoute($method,$pattern, $action);
        return $this;
    }

    private final function pathFromUri($path) {
        $path = !empty($path) && $path[strlen($path) - 1] == '/' ? substr($path, 0, strlen($path) - 1) : $path;
        if (empty($path)) {
            return '';
        }
        $queryPos = strpos($path, '?');
        if ($queryPos !== FALSE) {
            $path = substr($path, 0, $queryPos);
        }
        return $path[0] === '/' ? substr($path, 1) : $path;
    }
}