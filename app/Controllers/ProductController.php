<?php

namespace App\Controllers;

use App\Models\AdminUser;
use App\Models\Product;
use App\Models\ProductModel;
use Symfony\Component\Routing\RouteCollection;

session_start();

class ProductController
{
    public function postProduct(RouteCollection $routes)
    {
        if (!isset($_SESSION['user'])) {
            echo json_encode([
                "status" => 401,
                "message" => "Ação não autorizada"
            ]);
            http_response_code(401);
            return;
        }

        $products = new ProductModel();
        $product = new Product();

        if (!isset($_POST["product_name"]) || !isset($_POST["product_description"]) || !isset($_POST["product_number"]) || !isset($_POST["product_image"])) {
            return;
        }

        $product_name = filter_input(INPUT_POST, "product_name", FILTER_DEFAULT);
        $product_description = filter_input(INPUT_POST, "product_description", FILTER_DEFAULT);
        $product_number = filter_input(INPUT_POST, "product_number", FILTER_VALIDATE_INT);
        $product_image = filter_input(INPUT_POST, "product_image", FILTER_DEFAULT);

        if (empty($product_name) || empty($product_description) || empty($product_number) || empty($product_image)) {
            echo json_encode([
                "status" => 404,
                "message" => "FormData incompleto"
            ]);
            http_response_code(404);
            return;
        }

        $image_extension = explode("/", explode(":", substr($product_image, 0, strpos($product_image, ";")))[1])[1];
        $image_name = time() . '.' . $image_extension;

        $product_image = str_replace("data:image/" . $image_extension . ";base64,", '', $product_image);
        $product_image = str_replace(' ', '+', $product_image);

        file_put_contents(APP_ROOT . '/public/images/' . $image_name, base64_decode($product_image));
        $url = URL_SUBFOLDER . '/public/images/' . $image_name;

        $product->product_name = $product_name;
        $product->product_description = $product_description;
        $product->product_number = $product_number;
        $product->product_image = $url;

        $products->new($product);

        echo json_encode($product);
    }

    public function deleteProduct(RouteCollection $routes)
    {
        if (!isset($_SESSION['user'])) {
            echo json_encode([
                "status" => 401,
                "message" => "Ação não autorizada"
            ]);
            http_response_code(401);
            return;
        }

        $products = new ProductModel();
        $product = new Product();

        if (!isset($_POST["product_name"])) {
            echo json_encode([
                "status" => 404,
                "message" => "Nome do produto é requirido"
            ]);
            http_response_code(404);
            return;
        }

        $product_name = $_POST["product_name"];
        $product = $products->getByName($product_name);

        if (!isset($product)) {
            echo json_encode([
                "status" => 404,
                "message" => "Não foi possivel encontrar este produto"
            ]);
            http_response_code(404);
            return;
        }

        $deleted_product = $products->delete($product);
        
        echo json_encode([
            "status" => 200,
            "deleted" => $deleted_product
        ]);
    }

    public function getProducts(RouteCollection $routes)
    {
        $products = new ProductModel();

        echo json_encode($products->getAll());
    }
}
