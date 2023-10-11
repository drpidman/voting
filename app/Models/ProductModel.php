<?php

namespace App\Models;

use mysqli;

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
    public function getVotes(String $product_name)
    {
        $conn = $this->connect();

        $sql =
            "SELECT votes FROM products WHERE name = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $product_name);

        $stmt->execute();
        $stmt->bind_result($votes);

        if ($stmt->fetch()) {
            $product = new Product();
            $product->product_votes = $votes;

            return $product;
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
    }

    /**
     * "Setar" os votos de um produto pelo nome recebe
     * @param int $vote_num Numero de votos a serem inseridos no produto buscado
     * pelo nome
     * @param String $product_name Nome do produto que sera 
     * buscado os votos
     */
    public function setVotes(int $vote_num, String $product_name)
    {
        $conn = $this->connect();

        $sql =
            "UPDATE products SET votes = ? WHERE name = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $vote_num, $product_name);

        if ($stmt->execute()) {
            $product = new ProductModel();
            return $product->getByName($product_name);
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
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

        $sql =
            "INSERT INTO products(name,
             description,
             number,
             image,
             votes
            ) VALUES(?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssss",
            $product->product_name,
            $product->product_description,
            $product->product_number,
            $product->product_image,
            $product->product_votes
        );

        if ($stmt->execute()) {
            return $this->getByName($product->product_name);
        }

        $stmt->close();
        $conn->close();
    }

    /**
     * Deletar um produto recebe
     * @param \App\Models\Product $product Objeto produto 
     * para deletar
     */
    public function delete(Product $product)
    {
        $conn = $this->connect();

        $sql =
            "DELETE FROM products WHERE name = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $product->product_name);

        if ($stmt->execute()) {
            return $product;
        }

        $stmt->close();
        $conn->close();
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
            votes FROM products WHERE name = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $product_name);

        $stmt->execute();
        $stmt->bind_result($name, $description, $number, $image, $votes);

        if ($stmt->fetch()) {
            $product = new Product();
            $product->product_name = $name;
            $product->product_description = $description;
            $product->product_number = $number;
            $product->product_image = $image;
            $product->product_votes = $votes;

            return $product;
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
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
            "SELECT name,
            description,
            number,
            image,
            votes FROM products WHERE number = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $product_number);

        $stmt->execute();
        $stmt->bind_result($name, $description, $number, $image, $votes);

        if ($stmt->fetch()) {
            $product = new Product();
            $product->product_name = $name;
            $product->product_description = $description;
            $product->product_number = $number;
            $product->product_image = $image;
            $product->product_votes = $votes;

            return $product;
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
    }

    /**
     * Buscar todos os produtos sem parametros
     */
    public function getAll()
    {
        $conn = $this->connect();

        $sql =
            "SELECT name,
            description,
            number,
            image,
            votes FROM products";

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $stmt->bind_result($name, $description, $number, $image, $votes);

        $products = [];

        while ($stmt->fetch()) {
            $product = new Product();
            $product->product_name = $name;
            $product->product_description = $description;
            $product->product_number = $number;
            $product->product_image = $image;
            $product->product_votes = $votes;

            $products[] = $product;
        }

        $stmt->close();
        $conn->close();

        return $products;
    }
}
