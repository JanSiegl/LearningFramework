<?php

namespace App\Controller;

class IndexController
{

    public function indexAction($name)
    {
        echo "Hallo " . $name;
    }
}