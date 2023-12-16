<?php

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;

interface Controller
{
    public function load(RouteCollection $routes);
}
