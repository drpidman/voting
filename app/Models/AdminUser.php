<?php
namespace App\Models;

use mysqli;

class User  {
    public $username;
    public $password;
};

class AdminUser {
    public function connect() {
        return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function setUser(String $email, String $password)
    {
        $user = new User();
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

        // Feche a declaração e a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }
}
