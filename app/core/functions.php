<?php

/* show formatted */
function show($data)
{
    print_r("<pre>");
    print_r($data);
    print_r("</pre>");
}

/* route to path */
function redirect($link = '')
{
    if (empty($link)) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header("location: " . ROOT . "/" . $link);
    }
}

/* set values on inputs */
function setValue($str, $default = '')
{
    preg_match_all("/\w+/", $str, $matches);
    $parts = $matches[0];
    $data = $_POST;

    foreach ($parts as $key) {
        if (!empty($data[$key])) {
            $data = $data[$key];
        } else {
            $data = '';
            break;
        }
    }

    if (empty($data) && !empty($default)) {
        $data = $default;
    }

    return $data;
}

function setFile($key, $default = '')
{
    if (!empty($_FILES[$key])) {
        return $_FILES[$key];
    } else
	if (!empty($default)) {
        return $default;
    }

    return '';
}

/* display column value */
function displayValue($val, $format = 'text')
{
    if (empty($val)) $val = '-';

    if ($format == 'datetime') {
        $moment = new \Moment\Moment($val);
        $val = $moment->format('d/m/Y - h:m A');
    }

    return $val;
}

/* random key string */
function randomString()
{
    $str = rand();
    $result = md5($str);

    return $result;
}

/* get epoch milliseconds */
function milliseconds()
{
    $mt = explode(' ', microtime());
    return intval($mt[1] * 1E3) + intval(round($mt[0] * 1E3));
}

/* upload file */
function uploadFile($name)
{
    if (!empty($_FILES[$name]['name'])) {
        /* create upload directory if not exists */
        $currentRoot = dirname(__DIR__, 2);
        $route = "/assets/uploads/";
        $target_dir = $currentRoot . "/public" . $route;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $info = pathinfo($_FILES[$name]['name']);

        $extension =  $info['extension'];

        $file_name = milliseconds() . "." . $extension;
        $save_path = $target_dir  . $file_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $save_path);

        if (!$result) return null;

        return ["url" => ROOT . $route . $file_name, "name" => $file_name, "result" => $result];
    }

    return null;
}

/* get active tab */
function getActiveTab($tabs, $get)
{
    $tab = $tabs[0];
    if (!empty($get) && !empty($get['tab'])) {
        $tab = in_array($get['tab'], $tabs) ? $get['tab'] : $tabs[0];
    }

    return $tab;
}

/* get active menu */
function getActiveMenu(&$menu, $path)
{
    $func = "view";
    $path = "/" . $path;

    foreach ($menu as $x => &$val) {
        if (is_array($val["path"])) {
            if (in_array($path, $val["path"])) {
                $func = $val["id"];
                $val["active"] = 'true';
            }
        } else if ($val["path"] ==  $path) {
            $func = $val["id"];
            $val["active"] = 'true';
        }
    }
    return $func;
}
