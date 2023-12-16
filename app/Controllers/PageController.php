<?php 

namespace App\Controllers;

use App\Models\ProductModel;
use Symfony\Component\Routing\RouteCollection;

class PageController implements Controller
{
    // Homepage action
	public function load(RouteCollection $routes)
	{
		$product = new ProductModel();
		$products = $product->getAll();

        require_once APP_ROOT . '/views/home.php';
	}
}