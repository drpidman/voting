<?php

namespace App\Models;
use App\Models\Connection;
use PDO;

class History {
    public $history_id;
    public $product_id;
    public $user_id;
}

class VotesHistory extends Connection {

    public function new(History $history) {
        $conn = $this->connect();

        $stmt = $conn->prepare(
            "INSERT INTO VotesHistory(product_id, user_id)
             VALUES(:product_id, :user_id)
            "
        );

        $stmt->bindParam(":product_id", $history->product_id);
        $stmt->bindParam(":user_id", $history->user_id);

        return $stmt->execute();
    }

    public function getUserVotes(int $user_id) {
        $conn = $this->connect();

        $stmt = $conn->prepare(
            "SELECT COUNT(*) AS votes_time FROM VotesHistory
             WHERE user_id = :user_id
            "
        );

        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $votes_time = $stmt->fetch(PDO::FETCH_OBJ);

        return $votes_time;
    }
}