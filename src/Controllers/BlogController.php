<?php

namespace App\Controllers;

use App\Classes\Http\Response;
use App\Classes\SessionHelper;
use App\Classes\View;
use App\Models\Comment;
use App\Models\Post;
use DateTime;
use JasonGrimes\Paginator;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

class BlogController extends BaseController
{

    public function index(): Response
    {
        $queryString = parseQueryString();

        $authorId = null;
        if(!empty($queryString['author'])) {
            $authorId = $queryString['author'];
        }

        $totalItems = Post::totalPosts($authorId);
        $itemsPerPage = 3;
        $currentPage = $this->getRequest()->get('page') ?? 1;
        $urlPattern = '/?page=(:num)';
        if(!is_null($authorId)) {
            $urlPattern .= '&author=' . $authorId;
        }

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        $posts = Post::getPosts($authorId, $itemsPerPage, ($currentPage - 1) * $itemsPerPage);

        return View::make('home', ['posts' => $posts, 'paginator' => $paginator]);
    }

    public function createPostForm(): Response
    {
        return View::make('blog.create');
    }

    public function storePost(): void
    {
        $inputs = cleanRequestBody($this->getRequest()->post());
        try {
            Validator::key('post_title', Validator::notEmpty())
                ->key('post_content', Validator::notEmpty())
                ->key('post_image_link', Validator::notEmpty())
                ->assert($inputs);

            // save post
            $res = Post::save([
                'title' => $inputs['post_title'],
                'content' => $inputs['post_content'],
                'image' => $inputs['post_image_link'],
                'author_id' => SessionHelper::get('user_id'),
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ]);

            if($res) {
                check24Redirect('/', ['messages' => 'Post saved successfully', 'message_type' => 'success']);
            } else {
                check24Redirect('/blog/create', ['messages' => 'An error occurred. Please try again', 'message_type' => 'danger']);
            }
        } catch (ValidationException $e) {
            $output = '';
            foreach($e->getMessages() as $message) {
                $output .= $message . "<br>";
            }

            check24Redirect('/blog/create', ['messages' => $output, 'message_type' => 'danger']);
        }
    }

    public function viewPost(): Response
    {
        $queryString = parseQueryString();

        // if no id is provided, redirect back
        if(empty($queryString['id'])) {
            check24Redirect('/');
        }

        // find post
        $post = Post::getPostOrFail((int) $queryString['id']);

        // get comments
        $comments = Comment::getCommentsByPostId($queryString['id']);

        return View::make('blog.view-post', ['post' => $post, 'comments' => $comments, 'queryString' => $queryString]);
    }

}