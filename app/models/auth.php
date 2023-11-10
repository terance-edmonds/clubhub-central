<?php

class Auth extends Routes
{

    public static function set($user)
    {
        $_SESSION['USER'] = $user;
    }

    public static function logout()
    {
        if (!empty($_SESSION['USER'])) unset($_SESSION['USER']);

        session_destroy();
    }

    public static function logged()
    {
        if (!empty($_SESSION['USER'])) return true;

        return false;
    }

    public static function authenticate($get = [])
    {
        if (empty($get['url'])) $get['url'] = 'main';
        $path = $get['url'];

        if (!array_key_exists($path, self::$routes)) return false;
        $route_auth = self::$routes[$path];

        if (in_array('ANY', $route_auth)) return true;

        if (empty($_SESSION['USER'])) return redirect("login");

        $auth_user = $_SESSION['USER'];

        if (in_array($auth_user['role'], $route_auth)) {
            return true;
        } else {
            $storage = new Storage();
            $club_id = $storage->get('club_id');
            $club_role = $storage->get('club_role');

            if (!empty($club_id) && in_array($club_role, $route_auth)) {
                return true;
            }
        }

        return redirect("not-found");
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
