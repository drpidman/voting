<?php

namespace App\Models;

use Exception;
use mysqli;
use PDO;

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

        $stmt = $conn->prepare("SELECT status, user, cpf FROM vote_status WHERE id = :status_id");
        $stmt->bindParam(":status_id", $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $vote_status = new VoteStatus();
            $vote_status->status = $result['status'];
            $vote_status->user = $result['user'];
            $vote_status->cpf = $result['cpf'];

            $conn = null;
            return $vote_status;
        }

        return null;
    }

    public function updateStatus(int $id, bool $status, UserVote $user)
    {
        $conn = $this->connect();

        if ($this->getStatus($id)->status) {
            $user->name = "empt";
            $user->cpf = "empt";
        }

        $stmt = $conn->prepare("UPDATE vote_status SET status = :status, user = :user, cpf = :cpf WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
        $stmt->bindParam(':user', $user->name);
        $stmt->bindParam(':cpf', $user->cpf);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $result = $this->getStatus($id);

        if ($result) {
            return $result;
        } else {
            return json_last_error_msg();
        }
    }
}
