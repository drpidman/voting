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
    public $product_votes;
};

/**
 * Classe para gerenciar os votos dos produtos
 */
class ProductModelVotes extends Connection
{
    /**
     * Buscar os votos de um produto pelo nome recebe
     * @param String $product_name Nome do produto que sera 
     * buscado os votos
     */
    public function getVotes(string $product_name)
    {
        $conn = $this->connect();

        $sql = "SELECT votes FROM products WHERE name = :product_name";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $product = new Product();
            $product->product_votes = $result['votes'];
            $conn = null;
            return $product;
        } else {
            return null;
        }
    }

    /**
     * "Setar" os votos de um produto pelo nome recebe
     * @param int $vote_num Numero de votos a serem inseridos no produto buscado
     * pelo nome
     * @param String $product_name Nome do produto que sera 
     * buscado os votos
     */
    public function setVotes(String $product_name)
    {
        $conn = $this->connect();

        $sql =
            "UPDATE products SET votes = products.votes + 1 WHERE name = :product_name";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":product_name", $product_name);

        if ($stmt->execute()) {
            $conn = null;
            $product = new ProductModel();
            return $product->getByName($product_name);
        } else {
            return null;
        }
    }
}

/**
 * Classe para gerenciar o produto
 */
class ProductModel extends ProductModelVotes
{
    /**
     * Criar um novo produto recebe
     * @param \App\Models\Product $product Objeto produto 
     * para criação
     */
    public function new(Product $product)
    {
        $conn = $this->connect();

        $sql = "INSERT INTO products(name,
             description,
             number,
             image,
             votes
            ) VALUES(:product_name, :product_description, :product_number, :product_image, :product_votes)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product->product_name);
        $stmt->bindParam(':product_description', $product->product_description);
        $stmt->bindParam(':product_number', $product->product_number);
        $stmt->bindParam(':product_image', $product->product_image);
        $stmt->bindParam(':product_votes', $product->product_votes);

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
            image,
            votes FROM products WHERE id = :product_id";

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
            image,
            votes FROM products WHERE name = :product_name";

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
            "SELECT name AS product_name,
            description,
            number,
            image,
            votes FROM products WHERE number = :product_number";

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
            image AS product_image,
            votes FROM products";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
