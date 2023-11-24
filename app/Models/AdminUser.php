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
    
        $sql = "SELECT email, password FROM admins WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $this->setUser($result['email'], $result['password']);
        } else {
            return null;
        }
    }
    
}
