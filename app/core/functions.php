<?php

/* route to path */
function redirect($link)
{
    header("Location: " . ROOT . "/" . $link);
    die;
}

/* set values on inputs */
function setValue($key, $default = '')
{
    if (!empty($_POST[$key])) {
        return $_POST[$key];
    } else
	if (!empty($default)) {
        return $default;
    }

    return '';
}

/* random key string */
function randomString()
{
    $str = rand();
    $result = md5($str);

    return $result;
}
