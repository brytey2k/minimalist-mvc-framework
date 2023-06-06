<?php

namespace App\Classes;

use App\Models\User;
use stdClass;

class Auth
{

    public static function rehashPasswordIfNeeded(string $password, stdClass $user): void
    {
        if (password_needs_rehash($user->password, PASSWORD_DEFAULT)) {
            // Generate a new password hash and update it in the database
            $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);

            // Update the password hash in the database
            (new User())->updatePassword($newPasswordHash, $user);
        }
    }

    public static function logout(): void
    {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }

}