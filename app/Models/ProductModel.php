<?php

namespace App\Models;

use mysqli;
use PDO;

class Product
{
    public $product_name;
    public $product_description;
    public $product_number;
    public $product_image;
};


/**
 * Classe para gerenciar o produto
 */
class ProductModel extends Connection
{
    /**
     * Criar um novo produto recebe
     * @param \App\Models\Product $product Objeto produto 
     * para criação
     */
    public function new(Product $product)
    {
        $conn = $this->connect();

        $sql = "INSERT INTO products(
             name,
             description,
             number,
             image
            ) 
            VALUES(:product_name, :product_description, :product_number, :product_image)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product->product_name);
        $stmt->bindParam(':product_description', $product->product_description);
        $stmt->bindParam(':product_number', $product->product_number);
        $stmt->bindParam(':product_image', $product->product_image);

        if ($stmt->execute()) {
            $newProductId = $conn->lastInsertId();
            $newProduct = $this->getById($newProductId);
            $conn = null;
            return $newProduct;
        }

        return null;
    }

    /**
     * Deletar um produto recebe
     * @param \App\Models\Product $product Objeto produto 
     * para deletar
     */
    public function delete(Product $product)
    {
        $conn = $this->connect();

        $sql = "DELETE FROM products WHERE name = :product_name";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product->product_name);

        if ($stmt->execute()) {
            $conn = null;
            return $product;
        }

        return null;
    }

    /**
     * Buscar um produto pelo nome recebe
     * @param String $product_id Nome do produto que sera 
     * buscado
     */
    public function getById(int $product_id)
    {
        $conn = $this->connect();

        $sql =
            "SELECT name,
            description,
            number,
            image
            FROM products WHERE id = :product_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_OBJ);

        $conn = null;

        return $product ? $product : null;
    }

    /**
     * Buscar um produto pelo nome recebe
     * @param String $product_name Nome do produto que sera 
     * buscado
     */
    public function getByName(String $product_name)
    {
        $conn = $this->connect();

        $sql =
            "SELECT name,
            description,
            number,
            image
            FROM products WHERE name = :product_name";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":product_name", $product_name);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_OBJ);

        $conn = null;

        return $product ? $product : null;
    }

    /**
     * Buscar um produto pelo numero recebe
     * @param String $product_number Numero do produto que sera
     * buscado
     * 
     * Futuramente será mudado o tipo String para int.
     */
    public function getByNumber(String $product_number)
    {
        $conn = $this->connect();

        $sql =
            "SELECT id AS product_id, 
            name AS product_name,
            description,
            number,
            image
            FROM products WHERE number = :product_number";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":product_number", $product_number);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        return $product ? $product : null;
    }

    /**
     * Buscar todos os produtos sem parametros
     */
    public function getAll()
    {
        $conn = $this->connect();

        $sql = "SELECT name AS product_name,
            description AS product_description,
            number AS product_number,
            image AS product_image
            FROM products";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
