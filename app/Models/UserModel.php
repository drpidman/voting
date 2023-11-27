<?php

namespace App\Models;

use mysqli;
use PDO;

class UserVote
{
    public $user_id;
    public $user_name;
    public $user_cpf;
};

class UserModel extends Connection
{

    public const TABLE_NAME = "Users";
    public const COLUMN_USER_ID = "user_id";
    public const COLUMN_USER_NAME = "user_name";
    public const COLUMN_USER_CPF = "user_cpf";

    public function new(UserVote $user)
    {
        $conn = $this->connect();

        $sql =
            " INSERT INTO " . self::TABLE_NAME . "(" . self::COLUMN_USER_NAME . "," .
            self::COLUMN_USER_CPF . ")" .
            " VALUES(:name, :cpf)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $user->user_name);
        $stmt->bindParam(':cpf', $user->user_cpf);

        if ($stmt->execute()) {
            return $this->getByCpf($user->user_cpf);
        }

        return null;
    }

    public function getByCpf(string $cpf)
    {
        $conn = $this->connect();

        $sql = "SELECT " . self::COLUMN_USER_ID . ","
            . self::COLUMN_USER_NAME . ","
            . self::COLUMN_USER_CPF . " FROM " . self::TABLE_NAME .
            " WHERE " . self::COLUMN_USER_CPF . "=:cpf";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        $result = $stmt->fetchObject("App\Models\UserVote");

        return $result ? $result : null;
    }

    public function exists(string $cpf)
    {
        $user = $this->getByCpf($cpf);
        return $user !== null;
    }
}
