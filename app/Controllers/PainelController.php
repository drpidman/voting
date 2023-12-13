<?php 
namespace App\Controllers;

use App\Models\ProductModel;
use Symfony\Component\Routing\RouteCollection;

session_start();

class PainelController implements Controller
{
	public function load(RouteCollection $routes)
	{
        $homepage = $routes->get('homepage')->getPath();

        $addproduct = $routes->get('painel-post-product')->getPath();
        $deleteproduct = $routes->get('painel-delete-product')->getPath();

        $product = new ProductModel();
		$products = $product->getAll();
    
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $homepage);
            return;
        }

        require_once APP_ROOT . '/views/painel/painel.php';
	}
}