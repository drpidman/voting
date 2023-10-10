<?php

namespace App\Models;

use Exception;
use mysqli;

class VoteStatus
{
    public $id;
    public $status;
    public $user;
    public $cpf;
}


class VoteStatusModel extends Connection
{
    public function getStatus(int $id)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("SELECT status, user, cpf FROM vote_status WHERE id = ?");
        $stmt->bind_param("s", $id);

        $stmt->execute();
        $stmt->bind_result($status, $user, $cpf);

        if ($stmt->fetch()) {
            $vote_status = new VoteStatus();
            $vote_status->status = $status;
            $vote_status->user = $user;
            $vote_status->cpf = $cpf;

            return $vote_status;
        }
    }

    public function updateStatus(int $id, bool $status, UserVote $user)
    {
        $conn = $this->connect();

        if ($this->getStatus($id)->status) {
            $user->name = "empt";
            $user->cpf = "empt";
        }

        $stmt = $conn->prepare("UPDATE vote_status SET status = ?, user = ?, cpf = ? WHERE id = ?");
        $stmt->bind_param(
            "ssss",
            $status,
            $user->name,
            $user->cpf,
            $id
        );

        $stmt->execute();

        try {
            if ($stmt->fetch()) {
                return $this->getStatus($id);
            }
        } catch (Exception $e) {
            return json_last_error_msg();
        }
    }
}
