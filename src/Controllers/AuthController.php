<?php

namespace App\Controllers;

use App\Classes\Auth;
use App\Classes\Http\Response;
use App\Models\User;
use App\Classes\SessionHelper;
use App\Classes\View;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

class AuthController extends BaseController
{
    public function login(): Response
    {
        if(check24UserIsLoggedIn()) {
            check24Redirect('/');
        }
        return View::make('auth.login');
    }

    public function processLogin(): void
    {
        $inputs = cleanRequestBody($this->getRequest()->post());

        try {
            Validator::key('username', Validator::notEmpty())
                ->key('password', Validator::notEmpty())
                ->assert($inputs);

            $user = User::getUserByStatus($inputs['username']);
            if(!$user) {
                // invalid username
                check24Redirect('/auth', ['messages' => 'Invalid username or password', 'message_type' => 'danger']);
            }

            if (password_verify($inputs['password'], $user->password)) {
                // Check if password needs rehashing
                Auth::rehashPasswordIfNeeded($inputs['password'], $user);

                // setup login session
                SessionHelper::initLoginState($user);

                check24Redirect('/');
            } else {
                // Password is incorrect
                check24Redirect('/auth', ['messages' => 'Invalid username or password', 'message_type' => 'danger']);
            }
        } catch (ValidationException $e) {
            $output = '';
            foreach($e->getMessages() as $message) {
                $output .= $message . "<br>";
            }

            check24Redirect('/auth', ['messages' => $output, 'message_type' => 'danger']);
        }
    }

    public function logout(): void
    {
        Auth::logout();

        // go back to login page
        check24Redirect('/auth');
    }

}