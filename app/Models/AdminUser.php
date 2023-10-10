<?php

namespace App\Models;

use mysqli;

class UserAdmin
{
    public $username;
    public $password;
};

class AdminUser extends Connection
{
    public function setUser(String $email, String $password)
    {
        $user = new UserAdmin();
        $user->username = $email;
        $user->password = $password;

        return $user;
    }

    public function getUser(String $email, String $password)
    {
        $conn = $this->connect();

        $sql = "SELECT email, password FROM admins WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);

        $stmt->execute();
        $stmt->bind_result($username, $pass);

        if ($stmt->fetch()) {
            return $this->setUser($username, $pass);
        } else {
            return null;
        }

        $stmt->close();
        $conn->close();
    }
}
