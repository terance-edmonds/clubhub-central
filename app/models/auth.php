<?php

class Auth
{
    public static function set($user)
    {
        $_SESSION['USER'] = $user;
    }

    public static function logout()
    {
        if (!empty($_SESSION['USER'])) unset($_SESSION['USER']);
    }

    public static function logged()
    {
        if (!empty($_SESSION['USER'])) return true;

        return false;
    }

    public static function authenticate()
    {
        if (empty($_SESSION['USER'])) return redirect('login');

        return true;
    }

    public static function user()
    {
        if (!empty($_SESSION['USER'])) return $_SESSION['USER'];

        return null;
    }

    /* to get attributes value as a function */
    public static function __callStatic($func_name, $args)
    {

        $key = str_replace("get", "", strtolower($func_name));
        $key = _::snakeCase($key);

        if (!empty($_SESSION['USER'][$key])) {
            return $_SESSION['USER'][$key];
        }

        return '';
    }
}
