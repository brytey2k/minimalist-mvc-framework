<?php

namespace App\Controllers;

use App\Classes\Http\Response;
use App\Classes\SessionHelper;
use App\Models\Comment;
use DateTime;
use PDO;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

class CommentsController extends BaseController
{

    public function save() {
        $inputs = cleanRequestBody($this->getRequest()->post());

        try {
            Validator::key('name', Validator::notEmpty())
                ->assert($inputs);

            if(empty($inputs['id'])) {
                (new Response(400, "<h2>Bad Request</h2>"))->send();
            }

            // save comment
            $res = Comment::save([
                'name' => $inputs['name'],
                'url' => $inputs['url'],
                'content' => $inputs['comment'],
                'author_id' => SessionHelper::get('user_id'),
                'email' => $inputs['email'],
                'post_id' => $inputs['id'],
                'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            ]);

            if($res) {
                $flashData = ['messages' => 'Comment added successfully', 'message_type' => 'success'];
            } else {
                $flashData = ['messages' => 'An error occurred. Please try again', 'message_type' => 'danger'];
            }

            check24Redirect('/blog/view-post?id=' . $inputs['id'], $flashData);
        } catch(ValidationException $e) {
            $output = '';
            foreach ($e->getMessages() as $error) {
                $output .= $error . "<br>";
            }

            check24Redirect('/blog/view-post?id=' . $inputs['id'], ['messages' => $output, 'message_type' => 'danger']);
        }
    }

    public function delete() {
        // Retrieve the data
        $commentId = htmlentities($_POST['comment_id']);

        // Validate
        if (empty($commentId)) {
            check24Redirect('/', ['messages' => 'An error occurred', 'message_type' => 'danger']);
        }

        // find the comment
        $comment = Comment::findOrFail($commentId);

        // delete comment
        $res = Comment::delete($commentId);

        if($res) {
            $flashData = ['messages' => 'Comment removed successfully', 'message_type' => 'success'];
        } else {
            $flashData = ['messages' => 'An error occurred. Please try again', 'message_type' => 'danger'];
        }

        check24Redirect('/blog/view-post?id=' . $comment->post_id, $flashData);
    }

}