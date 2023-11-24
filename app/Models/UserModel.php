<?php

namespace App\Models;

use mysqli;
use PDO;

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
    
        $sql = "INSERT INTO users(name, cpf) VALUES(:name, :cpf)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':cpf', $user->cpf);
    
        if ($stmt->execute()) {
            $conn = null;
            return $this->getByCpf($user->cpf);
        }
    
        return null;
    }
    
    public function getByCpf(string $cpf)
    {
        $conn = $this->connect();
    
        $sql = "SELECT name, cpf FROM users WHERE cpf = :cpf";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            $user = new UserVote();
            $user->name = $result['name'];
            $user->cpf = $result['cpf'];
            
            $conn = null;
            return $user;
        }
    
        return null;
    }
    
    public function exists(string $cpf)
    {
        $user = $this->getByCpf($cpf);
        return $user !== null;
    }    
}
