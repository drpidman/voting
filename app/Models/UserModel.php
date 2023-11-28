<?php

namespace App\Models;

use PDO;

/**
 * Propriedades de usuário
 * @var $user_id;
 * @var $user_name;
 * @var $user_cpf;
 */
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
    /**
     * @param UserVote $user Criar novo
     * usuario
     * @return UserVote
     */
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
    /**
     * @param string $cpf Buscar usuário
     * pelo CPF cadastrado
     * @return UserVote
     */
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
    /**
     * @param string $cpf Função retirada do codigo e
     * refatorada para todas as estruturas que a usam
     * Verificar a existência do CPF mesmo sendo UNIQUE
     * @return bool
     */
    public function exists(string $cpf)
    {
        $user = $this->getByCpf($cpf);
        return $user !== null;
    }
}
