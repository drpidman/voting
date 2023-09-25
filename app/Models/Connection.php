<?php

namespace App\Models;

use mysqli;

class Connection
{
    public function connect()
    {
        return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
}
