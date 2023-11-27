<?php

namespace App\Models;

use Exception;
use mysqli;
use PDO;

class VoteStatus
{
    public $status_id;
    public $status_username;
    public $status_usercpf;
    public $status;
}


class VoteStatusModel extends Connection
{

    public const TABLE_NAME = "vote_status";
    public const EXTRA_TABLENAME_USER = "usr";

    public const COLUMN_STATUS_ID = "status_id";
    public const COLUMN_STATUS = "status";
    public const COLUMN_USER_ID = "user_id";

    public const EXTRA_COLUMN_STATUS_NAME = "status_username";
    public const EXTRA_COLUMN_STATUS_CPF = "status_usercpf";

    public function getStatus(int $id) {
        $conn = $this->connect();

        $sql = "SELECT " . self::COLUMN_STATUS 
            . " FROM " . self::TABLE_NAME
            . " WHERE " . self::COLUMN_STATUS_ID . "=:status_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":status_id", $id);
        $stmt->execute();

        $result = $stmt->fetchObject("App\Models\VoteStatus");

        return $result ? $result : null;
    }

    public function getStatusAll(int $id)
    {
        $conn = $this->connect();

        $sql = "SELECT " . self::COLUMN_STATUS . ","
            . self::EXTRA_TABLENAME_USER . "." . UserModel::COLUMN_USER_NAME . " AS " . self::EXTRA_COLUMN_STATUS_NAME . ","
            . self::EXTRA_TABLENAME_USER . "." . UserModel::COLUMN_USER_CPF . " AS " . self::EXTRA_COLUMN_STATUS_CPF

            . " FROM " . self::TABLE_NAME
            . " INNER JOIN " . UserModel::TABLE_NAME . " " . self::EXTRA_TABLENAME_USER
            . " ON " . self::TABLE_NAME . "." . self::COLUMN_USER_ID . "=" . self::EXTRA_TABLENAME_USER . "." . UserModel::COLUMN_USER_ID
            . " WHERE " . self::COLUMN_STATUS_ID . "=:status_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":status_id", $id);
        $stmt->execute();

        $result = $stmt->fetchObject("App\Models\VoteStatus");

        return $result ? $result : null;
    }

    public function updateStatus(int $id, bool $status, int $user_id)
    {
        $conn = $this->connect();

        $sql = "UPDATE " . self::TABLE_NAME . " SET "
            . self::COLUMN_STATUS . "=:status,"
            . self::COLUMN_USER_ID . "=:userid" .
            " WHERE " . self::COLUMN_STATUS_ID . "=:id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);

        if ($this->getStatus($id)->status) {
            $stmt->bindValue(':userid', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
        }

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $this->getStatusAll($id);
    }
}
