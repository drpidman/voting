<?php

namespace App\Models;

use App\Models\Connection;
use PDO;

/**
 * Propriedades de historico
 * @var $history_id
 * @var $product_id
 * @var $user_id
 */
class History
{
    public $history_id;
    public $product_id;
    public $user_id;
}

class VotesHistory extends Connection
{

    public const TABLE_NAME = "VotesHistory";
    public const COLUMN_HISTORY_ID = "history_id";
    public const COLUMN_PRODUCT_ID = "product_id";
    public const COLUMN_USER_ID = "user_id";
    public const COLUMN_VOTED_AT = "votedAt";

    public const EXTRACOLUMN_VOTES_TIME = "votes_time";

    public const EXTRA_TABLE_PRODUCTS = "Products";
    public const EXTRA_COLUMN_PRODUCT_ID = "product_id";
    public const EXTRA_COLUMN_PRODUCT_NAME = "product_name";

    public const EXTRA_TABLE_USER = "Users";
    public const EXTRA_COLUMN_USER_ID = "user_id";
    public const EXTRA_COLUMN_USER_NAME = "user_name";

    /**
     * Criar novo historico
     * @param History $history
     * @return bool
     */
    public function new(History $history)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare(
            "INSERT INTO " . self::TABLE_NAME . "(" . self::COLUMN_PRODUCT_ID . ","
                . self::COLUMN_USER_ID . ")"
                . " VALUES(:product_id, :user_id)"
        );

        $stmt->bindParam(":product_id", $history->product_id);
        $stmt->bindParam(":user_id", $history->user_id);

        return $stmt->execute();
    }
    /**
     * Buscar registros de um unico usuário e verificar
     * se esta dentro do limite imposto sistematicamente
     * @param int $user_id 
     * @return unknown Desconhecido por não ter uma
     * classe especifica
     */
    public function getUserVotes(int $user_id)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare(
            "SELECT COUNT(*) AS " . self::EXTRACOLUMN_VOTES_TIME . " FROM " . self::TABLE_NAME .
                " WHERE " . self::COLUMN_USER_ID .  "=:user_id"
        );

        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $votes_time = $stmt->fetch(PDO::FETCH_OBJ);

        return $votes_time;
    }

    public function getAll()
    {
        $conn = $this->connect();
        $stmt = $conn->prepare(
            "SELECT " . self::EXTRA_TABLE_PRODUCTS . "." . self::EXTRA_COLUMN_PRODUCT_NAME . "," .
                self::EXTRA_TABLE_USER . "." . self::EXTRA_COLUMN_USER_NAME . "," .
                self::TABLE_NAME . "." . self::COLUMN_VOTED_AT .
                " FROM " . self::TABLE_NAME .
                " INNER JOIN " . self::EXTRA_TABLE_PRODUCTS .
                " ON " . self::TABLE_NAME . "." . self::COLUMN_PRODUCT_ID . "=" . self::EXTRA_TABLE_PRODUCTS . "." . self::EXTRA_COLUMN_PRODUCT_ID . 
                " INNER JOIN " . self::EXTRA_TABLE_USER .
                " ON " . self::TABLE_NAME . "." . self::COLUMN_USER_ID . "=" . self::EXTRA_TABLE_USER . "." . self::EXTRA_COLUMN_USER_ID
        );

        $stmt->execute();
        $histories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $histories;
    }
}
