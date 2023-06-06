<?php

namespace App\Models;

use App\Classes\DB\Database;
use App\Classes\Http\Response;
use App\Classes\SessionHelper;
use PDO;

class Comment
{

    public static function getCommentsByPostId(int $postId) {
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare("select * from comments where post_id = :post_id");
        $statement->execute([':post_id' => $postId]);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public static function findById(int $id) {
        $pdo = Database::getInstance()->getConnection();

        $statement = $pdo->prepare("select * from comments where comment_id = :comment_id");
        $statement->execute([
            ':comment_id' => $id,
        ]);
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public static function findOrFail(int $id) {
        $comment = static::findById($id);

        if(!$comment) {
            (new Response(404, "<h2>Not Found</h2>"))->send();
        }

        return $comment;
    }

    public static function delete(int $id) {
        $pdo = Database::getInstance()->getConnection();

        $statement = $pdo->prepare("delete from comments where comment_id = :comment_id");
        return $statement->execute([
            ':comment_id' => $id,
        ]);
    }

    public static function save(array $data) {
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare(
            "insert into comments(name, url, content, author_id, email, post_id, created_at) value(:name, :url, :content, :author_id, :email, :post_id, :created_at)");
        return $statement->execute([
            ':name' => $data['name'],
            ':url' => $data['url'],
            ':content' => $data['content'],
            ':author_id' => $data['author_id'],
            ':email' => $data['email'],
            ':post_id' => $data['post_id'],
            ':created_at' => $data['created_at'],
        ]);
    }

}