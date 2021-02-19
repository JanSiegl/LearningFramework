<?php

use App\Router\Router;

require __DIR__ . "/vendor/autoload.php";

$router = new Router($_SERVER);

$router->addRoute('hello', function() {
    echo 'Well, hello there!!';
});

$router->addRoute('calc',function (){
    echo (new \App\Calculator())->sum(10,10);
});

$router->addRoute('hello/jan',function (){
    echo "hello jan";
});

/**
 * @todo make me work!
 */
$router->addRoute('hello/{name}/{alter}/{plz}',function ($name){
    echo "hello ".$name;
});


$router->run();


