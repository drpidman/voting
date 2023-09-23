<?php

namespace App\Models;

use mysqli;

class UserVote {
    public $name;
    public $cpf;
};

class UserModel {

    public function connect()
    {
        return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

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
            return $this->getByName($user->name);
        }

        $stmt->close();
        $conn->close();
    }

    public function getByName(String $user_name) {
        $conn = $this->connect();

        $sql =
            "SELECT name, cpf FROM users WHERE name = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $user_name);

        $stmt->execute();
        $stmt->bind_result($name, $cpf);

        if ($stmt->fetch()) {
            $user = new UserVote();
            $user->name = $name;
            $user->cpf = $cpf;

            return $user;
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
    }

}