<?php

namespace App\Models;

use App\Classes\DB\Database;
use App\Classes\Http\Response;
use App\Classes\SessionHelper;
use PDO;

class Post
{

    public static function getPost(int $id) {
        $pdo = Database::getInstance()->getConnection();
        $statement = $pdo->prepare("select * from posts join users on posts.author_id = users.user_id where post_id = :post_id");
        $statement->execute([':post_id' => $id]);
        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public static function getPostOrFail(int $id) {
        $post = self::getPost($id);

        if(!$post) {
            (new Response(404, '<h2>Post Not Found</h2>'))->send();
        }

        return $post;
    }

    public static function totalPosts(?int $authorId) {
        $pdo = Database::getInstance()->getConnection();

        $where = '';
        $params = [];
        if(!empty($authorId)) {
            $where = ' where posts.author_id = :author_id ';
            $params[':author_id'] = $authorId;
        }

        $statement = $pdo->prepare("select count(*) as total from posts $where");
        $statement->execute($params);
        return $statement->fetch(PDO::FETCH_OBJ)->total;
    }

    public static function getPosts(?int $authorId, $limit = null, $offset = null) {
        $pdo = Database::getInstance()->getConnection();

        $where = '';
        $params = [];
        if(!empty($authorId)) {
            $where = ' where posts.author_id = :author_id ';
            $params[':author_id'] = $authorId;
        }

        $paginate = '';
        if(!is_null($limit) && !is_null($offset)) {
            $paginate = ' limit :limit offset :offset ';
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        }

        $statement = $pdo->prepare(
            "select title, posts.created_at, posts.post_id, first_name, last_name, posts.created_at, posts.content, image, posts.author_id, count(comments.post_id) as num_comments
                    from posts 
                        join users on posts.author_id = users.user_id
                        left join comments on comments.post_id = posts.post_id
                        $where
                        group by posts.post_id
                        order by created_at desc
                            $paginate
            ");
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public static function save(array $data) {
        $pdo = Database::getInstance()->getConnection();

        $statement = $pdo->prepare(
            "insert into posts(title, content, image, author_id, created_at) value(:title, :content, :image, :author_id, :created_at)"
        );
        return $statement->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':image' => $data['image'],
            ':author_id' => $data['author_id'],
            ':created_at' => $data['created_at'],
        ]);
    }

}