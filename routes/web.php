<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method'=>'indexAction'), array()));
$routes->add('painel', new Route(constant('URL_SUBFOLDER') . '/painel', array('controller' => 'PainelController', 'method'=>'showPainel'), array()));
$routes->add('painel-post-product', new Route(constant('URL_SUBFOLDER') . '/painel/add-product', array('controller' => 'AddProductController', 'method'=>'postProduct'), array()));

$routes->add('auth', new Route(constant('URL_SUBFOLDER') . '/auth', array('controller' => 'LoginController', 'method'=>'showAction'), array()));