<?php

namespace App\Models;

use mysqli;
use PDO;

class Connection
{
    public function connect()
    {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        return $conn;
    }
}
