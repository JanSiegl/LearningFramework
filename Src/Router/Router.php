<?php


namespace App\Router;

/**
 * Class Router
 * a Fast and simple Router for Callbacks
 * @package App\Router
 */
class Router
{
    public $request;

    public $routes = [];

    /**
     * Router constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = trim($request['REQUEST_URI'],'/');
    }


    public function addRoute(string $uri, $fn)
    {
        $this->routes[$uri] = $fn;
    }

    public function hasRoute($uri)
    {
        return array_key_exists($uri, $this->routes);
    }

    public function run()
    {
        var_dump($this->routes);
        var_dump($this->request);
        if ($this->hasRoute($this->request)) {
            $this->routes[$this->request]->call($this);
        }
    }
}