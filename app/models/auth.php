<?php

class Auth
{
    public static function authenticate($user)
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

    public static function user()
    {
        if (!empty($_SESSION['USER'])) return $_SESSION['USER'];

        return false;
    }

    /* to get attributes value as a function */
    public static function __callStatic($func_name, $args)
    {

        $key = str_replace("get", "", strtolower($func_name));
        $key = _::snakeCase($key);

        if (!empty($_SESSION['USER_DATA']->$key)) {
            return $_SESSION['USER_DATA']->$key;
        }

        return '';
    }
}
