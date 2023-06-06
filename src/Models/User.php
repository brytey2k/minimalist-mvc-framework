<?php

namespace App\Models;

use App\Classes\DB\Database;
use PDO;
use stdClass;

class User
{

    protected PDO $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public static function getUserByStatus($username, $status = 'active') {
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare('select * from users where username = :username and status = :status');
        $statement->execute([
            ':username' => $username,
            ':status' => $status
        ]);

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function updatePassword(string $newPasswordHash, stdClass $user): void
    {
        $statement = $this->connection->prepare("update users set password = :password where user_id = :user_id");
        $statement->execute([
            ':password' => $newPasswordHash,
            ':user_id' => $user->user_id,
        ]);
    }

}