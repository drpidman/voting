<?php

namespace App\Models;

use mysqli;
use PDO;

class UserVote
{
    public $id;
    public $name;
    public $cpf;
    public $allowedvotes;
};

class UserModel extends Connection
{
    public function new(UserVote $user)
    {
        $conn = $this->connect();

        $sql =
        "BEGIN;
        INSERT INTO users(name, cpf) VALUES(:name, :cpf);
        INSERT INTO userallowedvotes(user_id) VALUES(LAST_INSERT_ID());
        COMMIT;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':cpf', $user->cpf);

        if ($stmt->execute()) {
            return $this->getByCpf($user->cpf);
        }

        return null;
    }

    public function getByCpf(string $cpf)
    {
        $conn = $this->connect();

        $sql = "SELECT Users.id, Users.name, Users.cpf, allvts.allowed_votes FROM Users
        INNER JOIN UserAllowedVotes allvts
         ON Users.id = allvts.user_id 
        WHERE cpf = :cpf";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $result ? $result : null;
    }

    public function subVotes(int $user_id) {
        $conn = $this->connect();

        $sql = 
        " UPDATE UserAllowedVotes 
          SET allowed_votes = UserAllowedVotes.allowed_votes -1 
          WHERE user_id = :user_id;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    }

    public function exists(string $cpf)
    {
        $user = $this->getByCpf($cpf);
        return $user !== null;
    }
}
