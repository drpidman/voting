<?php

namespace App\Models;

use App\Models\Connection;
use PDO;

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
    public const EXTRACOLUMN_VOTES_TIME = "votes_time";

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
}
