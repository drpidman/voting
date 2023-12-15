<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'PageController', 'method' => 'load'), array()));
$routes->add('painel', new Route(constant('URL_SUBFOLDER') . '/painel', array('controller' => 'PainelController', 'method' => 'load'), array()));

$routes->add('painel-vote-control', new Route(constant('URL_SUBFOLDER') . '/painel/votecontrol', array('controller' => 'PainelVoteController', 'method' => 'load'), array()));
$routes->add('painel-vote-control-allow', new Route(constant('URL_SUBFOLDER') . '/painel/votecontrol/allow', array('controller' => 'PainelVoteController', 'method' => 'registerUser'), array()));
$routes->add('painel-vote-control-vote', new Route(constant('URL_SUBFOLDER') . '/painel/votecontrol/vote', array('controller' => 'PainelVoteController', 'method' => 'onVoteItem'), array()));

$routes->add('painel-status-get', new Route(constant('URL_SUBFOLDER') . '/painel/vote-status', array('controller' => 'PainelVoteController', 'method' => 'getVoteStatus'), array()));
$routes->add('painel-status-update', new Route(constant('URL_SUBFOLDER') . '/painel/vote-status/update', array('controller' => 'PainelVoteController', 'method' => 'updateVoteStatus'), array()));
$routes->add('painel-user-get', new Route(constant('URL_SUBFOLDER') . '/painel/user', array('controller' => 'PainelVoteController', 'method' => 'getUser'), array()));

$routes->add('painel-post-product', new Route(constant('URL_SUBFOLDER') . '/painel/add-product', array('controller' => 'ProductController', 'method' => 'postProduct'), array()));
$routes->add('painel-delete-product', new Route(constant('URL_SUBFOLDER') . '/painel/delete-product', array('controller' => 'ProductController', 'method' => 'deleteProduct'), array()));
$routes->add('painel-get-products', new Route(constant('URL_SUBFOLDER') . '/painel/getproducts', array('controller' => 'ProductController', 'method' => 'getProducts'), array()));
$routes->add('painel-get-vote-history', new Route(constant('URL_SUBFOLDER') . '/painel/getvote-history', array('controller' => 'ProductController', 'method' => 'getVotesHistory'), array()));


$routes->add('auth', new Route(constant('URL_SUBFOLDER') . '/auth', array('controller' => 'LoginController', 'method' => 'load'), array()));
