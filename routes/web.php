<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method' => 'indexAction'), array()));
$routes->add('painel', new Route(constant('URL_SUBFOLDER') . '/painel', array('controller' => 'PainelController', 'method' => 'showPainel'), array()));

$routes->add('painel-vote-control', new Route(constant('URL_SUBFOLDER') . '/painel/votecontrol', array('controller' => 'PainelVoteController', 'method' => 'showPainel'), array()));
$routes->add('painel-vote-control-allow', new Route(constant('URL_SUBFOLDER') . '/painel/votecontrol/allow', array('controller' => 'PainelVoteController', 'method' => 'registerUser'), array()));
$routes->add('painel-status-get', new Route(constant('URL_SUBFOLDER') . '/painel/vote-status', array('controller' => 'PainelVoteController', 'method' => 'getVoteStatus'), array()));

$routes->add('painel-post-product', new Route(constant('URL_SUBFOLDER') . '/painel/add-product', array('controller' => 'ProductController', 'method' => 'postProduct'), array()));
$routes->add('painel-delete-product', new Route(constant('URL_SUBFOLDER') . '/painel/delete-product', array('controller' => 'ProductController', 'method' => 'deleteProduct'), array()));

$routes->add('auth', new Route(constant('URL_SUBFOLDER') . '/auth', array('controller' => 'LoginController', 'method' => 'showAction'), array()));
