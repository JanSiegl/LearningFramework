<?php

require __DIR__ . "/vendor/autoload.php";

$router = new \App\Router\Dispatcher();
$router->addRoute('GET', '/', function () {
    echo "Hallo Anon";
});
$router->addRoute('GET', '/{name}/{alter}/{gender}', function ($name,$alter,$gender) {
    echo "Hallo " . $name. " ".$alter." jahre"." geschlecht: ".$gender;
});


$router->dispatch();


