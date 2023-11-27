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
        " INSERT INTO users(name, cpf) VALUES(:name, :cpf) ";

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

        $sql = "SELECT Users.id AS user_id, Users.name, Users.cpf FROM Users
        WHERE cpf = :cpf";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $result ? $result : null;
    }

    public function exists(string $cpf)
    {
        $user = $this->getByCpf($cpf);
        return $user !== null;
    }
}
