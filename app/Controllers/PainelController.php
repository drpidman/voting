<?php 
namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;

session_start();

class PainelController
{
	public function showPainel(RouteCollection $routes)
	{
        $homepage = $routes->get('homepage')->getPath();
        $addproduct = $routes->get('painel-post-product')->getPath();

        $user = $_SESSION['user'];
    
        if (!isset($user)) {
            header('Location: ' . $homepage);
            return;
        }

        require_once APP_ROOT . '/views/painel/painel.php';
	}
}