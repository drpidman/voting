<?php

namespace App\Models;

use PDO;
use PDOException;

/**
 * Propriedades de produto
 * @var $product_id
 * @var $product_image
 * @var $product_description
 * @var $product_number
 * @var $product_image
 */
class Product
{
    public $product_id;
    public $product_name;
    public $product_description;
    public $product_number;
    public $product_image;
};

class ProductModel extends Connection
{

    public const TABLE_NAME = "Products";
    public const COLUMN_PRODUCT_ID = "product_id";
    public const COLUMN_PRODUCT_NAME = "product_name";
    public const COLUMN_PRODUCT_DESCRIPTION = "product_description";
    public const COLUMN_PRODUCT_NUMBER = "product_number";
    public const COLUMN_PRODUCT_IMAGE = "product_image";

    public const EXTRA_TABLE_HISTORY = "VotesHistory";
    public const EXTRA_COLUMN_HISTORY_ID = "history_id";

    /**
     * Criar um novo produto
     * @param \App\Models\Product $product Objeto produto 
     * para criação
     * @return Product||null
     */
    public function new(Product $product)
    {
        $conn = $this->connect();

        $sql =
            "INSERT INTO " . self::TABLE_NAME
            . "(" .
            self::COLUMN_PRODUCT_NAME . "," .
            self::COLUMN_PRODUCT_DESCRIPTION . "," .
            self::COLUMN_PRODUCT_NUMBER . "," .
            self::COLUMN_PRODUCT_IMAGE
            . ")" .
            "VALUES(:product_name, :product_description, :product_number, :product_image)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_name', $product->product_name);
        $stmt->bindParam(':product_description', $product->product_description);
        $stmt->bindParam(':product_number', $product->product_number);
        $stmt->bindParam(':product_image', $product->product_image);

        if ($stmt->execute()) {
            $newProductId = $conn->lastInsertId();
            $newProduct = $this->getById($newProductId);

            return $newProduct;
        }

        return null;
    }
    /**
     * Deletar um produto
     * @param Product $product Objeto produto 
     * para deletar
     * @return Product||PDOException||null
     */
    public function delete(Product $product)
    {
        $conn = $this->connect();


        try {
            $conn->beginTransaction();

            $sqlDeleteHistory = "DELETE FROM " . VotesHistory::TABLE_NAME .
                " WHERE " . VotesHistory::COLUMN_PRODUCT_ID .  "=:product_id;";
            $sqlDeleteProduct =  "DELETE FROM " . self::TABLE_NAME .
                " WHERE " . self::COLUMN_PRODUCT_NAME . "=:product_name;";

            $stmtHistory = $conn->prepare($sqlDeleteHistory);
            $stmtHistory->bindParam(":product_id", $product->product_id);
            $stmtHistory->execute();

            $stmtProduct = $conn->prepare($sqlDeleteProduct);
            $stmtProduct->bindParam(":product_name", $product->product_name);
            $stmtProduct->execute();

            $conn->commit();

            return $product;
        } catch (PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }
    /**
     * Buscar um produto pelo id
     * @param String $product_id id do produto que sera 
     * buscado
     * @return Product||null
     */
    public function getById(int $product_id)
    {
        $conn = $this->connect();

        $sql =
            "SELECT " . self::COLUMN_PRODUCT_NAME  . "," .
            self::COLUMN_PRODUCT_DESCRIPTION . "," .
            self::COLUMN_PRODUCT_NUMBER . "," .
            self::COLUMN_PRODUCT_IMAGE .
            " FROM " . self::TABLE_NAME .
            " WHERE " . self::COLUMN_PRODUCT_ID . "=:product_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_OBJ);
        return $product ? $product : null;
    }
    /**
     * Buscar um produto pelo nome
     * @param String $product_name Nome do produto que sera 
     * buscado
     * @return Product||null
     */
    public function getByName(String $product_name)
    {
        $conn = $this->connect();

        $sql =
            "SELECT " . self::COLUMN_PRODUCT_ID . "," .
            self::COLUMN_PRODUCT_NAME  . "," .
            self::COLUMN_PRODUCT_DESCRIPTION . "," .
            self::COLUMN_PRODUCT_NUMBER . "," .
            self::COLUMN_PRODUCT_IMAGE .
            " FROM " . self::TABLE_NAME .
            " WHERE " . self::COLUMN_PRODUCT_NAME . "=:product_name";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":product_name", $product_name);
        $stmt->execute();
        $product = $stmt->fetchObject("App\Models\Product");

        return $product ? $product : null;
    }
    /**
     * Buscar um produto pelo numero
     * @param String $product_number Numero do produto que sera
     * buscado
     * 
     * Futuramente será mudado o tipo String para int.
     * @return Product||null
     */
    public function getByNumber(String $product_number)
    {
        $conn = $this->connect();

        $sql =
            "SELECT " . self::COLUMN_PRODUCT_ID . ","
            . self::COLUMN_PRODUCT_NAME  . ","
            . self::COLUMN_PRODUCT_DESCRIPTION . ","
            . self::COLUMN_PRODUCT_NUMBER . ","
            . self::COLUMN_PRODUCT_IMAGE .
            " FROM " . self::TABLE_NAME .
            " WHERE " . self::COLUMN_PRODUCT_NUMBER . "=:product_number";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":product_number", $product_number);
        $stmt->execute();

        $product = $stmt->fetchObject("App\Models\Product");

        return $product ? $product : null;
    }
    /**
     * Buscar todos os produtos
     * @return Product[]
     */
    public function getAll()
    {
        $conn = $this->connect();

        $sql =
            "SELECT " . self::COLUMN_PRODUCT_NAME  . "," .
            self::COLUMN_PRODUCT_DESCRIPTION . "," .
            self::COLUMN_PRODUCT_NUMBER . "," .
            self::COLUMN_PRODUCT_IMAGE .
            " FROM " . self::TABLE_NAME;

        $sqlNew =
            "SELECT COUNT(" . self::EXTRA_TABLE_HISTORY . "." . self::EXTRA_COLUMN_HISTORY_ID . ") AS votes," .
            self::TABLE_NAME . "." . self::COLUMN_PRODUCT_ID . "," .
            self::TABLE_NAME . "." . self::COLUMN_PRODUCT_NAME . "," .
            self::TABLE_NAME . "." . self::COLUMN_PRODUCT_DESCRIPTION . "," .
            self::TABLE_NAME . "." . self::COLUMN_PRODUCT_NUMBER . "," .
            self::TABLE_NAME . "." . self::COLUMN_PRODUCT_IMAGE .  "," .
            "CAST((COUNT" . "(".self::EXTRA_TABLE_HISTORY.".".self::EXTRA_COLUMN_HISTORY_ID.")"."* 100.0) / total_votes.total AS INT) AS percentage" .
            " FROM " . self::TABLE_NAME .
            " LEFT JOIN " . self::EXTRA_TABLE_HISTORY .
            " ON " . self::TABLE_NAME . "." . self::COLUMN_PRODUCT_ID . "=" . self::EXTRA_TABLE_HISTORY . "." . self::COLUMN_PRODUCT_ID . 
            " CROSS JOIN" .
            " (SELECT COUNT(" . SELF::EXTRA_COLUMN_HISTORY_ID . ") AS total FROM ". self::EXTRA_TABLE_HISTORY .") AS total_votes " .
            " GROUP BY " .
             self::TABLE_NAME . "." . self::COLUMN_PRODUCT_ID . "," .
             self::TABLE_NAME . "." . self::COLUMN_PRODUCT_NAME . "," .
             self::TABLE_NAME . "." . self::COLUMN_PRODUCT_DESCRIPTION . "," .
             self::TABLE_NAME . "." . self::COLUMN_PRODUCT_NUMBER . "," .
             self::TABLE_NAME . "." . self::COLUMN_PRODUCT_IMAGE 
            ;

        $stmt = $conn->prepare($sqlNew);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
