<?php
session_start();

$USERNAME = filter_input(INPUT_POST, "username", FILTER_SANITIZE_EMAIL);
$PASSWORD = filter_input(INPUT_POST, "password", FILTER_DEFAULT);

if (empty($USERNAME) || empty($PASSWORD)) {
    echo json_encode([
        "status"=>404,
        "msg"=>"Usuario e senha nao podem ser vazias"
    ]);
    return;
    
}

