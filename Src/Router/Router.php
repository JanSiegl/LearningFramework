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
    public function __construct()
    {

    }


    public function addRoute(string $method, string $uri, $fn)
    {
        if (!array_key_exists($method, $this->routes)) {
            $this->routes[$method] = [];
        }
        $this->routes[$method][$uri] = $fn;
    }

    public function run($method, $path, $params)
    {
        $path = $this->withEscapedSlashes("/{$path}");
        foreach ($this->routes[$method] as $pattern => $handler) {
            $patternParams = $this->patternParams($pattern);
            if (!empty($patternParams)) {
                $pattern = $this->withParams($pattern);
            }
            $pattern = $this->withEscapedSlashes($pattern);
            if ($this->requestMatches($pattern, $path, $patternParams, $params)) {
                foreach($params as $key=>$value){
                    if(0 === strpos($key, "XDEBUG")){
                        unset($params[$key]);
                    }
                }
                $func=new \ReflectionFunction($handler);
                $funcParams=$func->getParameters();
                $invokeParams=[];
                foreach ($funcParams as $fParam){
                    $invokeParams[]=$params[$fParam->getName()];
                }
                $func->invokeArgs($invokeParams);
                return;
            }
        }

        http_response_code(404);
        if (array_key_exists('/', $this->routes)) {
            $this->routes[$method]['/']([]);
        }

    }

    private function requestMatches($pattern, $path, $patternParams, &$params)
    {
        if (preg_match("/^{$pattern}$/i", $path, $matches)) {
            if (!$patternParams) {
                return ($path == $pattern);
            }

            foreach($patternParams as $index=>$patternParam){
                $params[$patternParam]=$matches[$index+1];
            }
            return true;
        }
        return false;
    }

    private function patternParams($pattern)
    {
        $matches = [];
        if (preg_match_all('/{(\w+)}/', $pattern, $matches)) {
            return $matches[1];
        }
    }

    private function withEscapedSlashes($pattern)
    {
        return str_replace('/', ':', $pattern);
    }

    private function withMethod($pattern)
    {
        return !preg_match("/^[A-Z]+ .+$/i", $pattern) ? "GET {$pattern}" : $pattern;
    }

    private function withParams($pattern)
    {
        return preg_replace('/{\w+}/', '([^:]+)', $pattern);
    }

}