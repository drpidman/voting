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

class ProductModel
{
    public function connect()
    {
        return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }


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

    public function getProducts() {
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
}
