<?php

namespace App\Models;

use mysqli;
use PDO;

class UserAdmin
{
    public $username;
    public $password;
};

class AdminUser extends Connection
{
    public const TABLE_NAME = "admins";
    public const COLUMN_EMAIL = "admin_email";
    public const COLUMN_PASSWORD = "admin_password";

    public function setUser(string $email, string $password)
    {
        $user = new UserAdmin();
        $user->username = $email;
        $user->password = $password;

        return $user;
    }

    public function getUser(string $email, string $password)
    {
        $conn = $this->connect();

        $sql = "SELECT " . self::COLUMN_EMAIL . "," . self::COLUMN_PASSWORD . 
        " FROM " . self::TABLE_NAME .
        " WHERE " . self::COLUMN_EMAIL . "=:email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $this->setUser($result[self::COLUMN_EMAIL], $result[self::COLUMN_PASSWORD]);
        } else {
            return null;
        }
    }
}
