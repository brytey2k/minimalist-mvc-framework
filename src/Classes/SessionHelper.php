<?php

namespace App\Classes;

use stdClass;

class SessionHelper
{
    public static function start()
    {
        session_start();
    }

    public static function initLoginState(stdClass $user): void
    {
        static::set('is_logged_in', true);
        static::set('user_id', $user->user_id);
        static::set('first_name', $user->first_name);
    }

    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function exists($key) {
        return isset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }
}
