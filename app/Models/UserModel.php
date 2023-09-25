<?php

namespace App\Models;

use mysqli;

class UserVote
{
    public $name;
    public $cpf;
};

class UserModel extends Connection
{
    public function new(UserVote $user)
    {
        $conn = $this->connect();

        $sql =
            "INSERT INTO users(name, cpf) VALUES(?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ss",
            $user->name,
            $user->cpf
        );

        if ($stmt->execute()) {
            return $this->getByName($user->cpf);
        }

        $stmt->close();
        $conn->close();
    }

    public function getByName(String $cpf)
    {
        $conn = $this->connect();

        $sql =
            "SELECT name, cpf FROM users WHERE cpf = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $cpf);

        $stmt->execute();
        $stmt->bind_result($name, $ucpf);

        if ($stmt->fetch()) {
            $user = new UserVote();
            $user->name = $name;
            $user->cpf = $ucpf;

            return $user;
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
    }



    public function exists(String $cpf)
    {
        $user = $this->getByName($cpf);
        return !isset($user);
    }
}
