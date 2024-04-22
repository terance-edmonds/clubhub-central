<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

/* show formatted */

function show($data)
{
    print_r("<pre style='max-width: 100%' >");
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
function setValue($str, $default = '', $format = 'text', $method = 'post')
{
    preg_match_all("/\w+/", $str, $matches);
    $parts = $matches[0];
    $data = ($method == 'get') ? $_GET : $_POST;

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

    if ($format == 'datetime' && !empty($data)) {
        try {
            $moment = new \Moment\Moment($data);
            $data = $moment->format('Y-m-d') . 'T' . $moment->format('H:i');
        } catch (\Throwable $th) {
            //
        }
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
    if (empty($val))
        $val = '-';

    switch ($format) {
        case 'datetime':
            $moment = new \Moment\Moment($val);
            $val = $moment->format('d/m/Y - h:i A');
            break;
        case 'date':
            $moment = new \Moment\Moment($val);
            $val = $moment->format('dS F');
            break;
        case 'time':
            $moment = new \Moment\Moment($val);
            $val = $moment->format('h:i A');
            break;
        case 'boolean':
            $val = ($val == '1') ? 'true' : 'false';
            break;
        case 'number':
            $val = numberFormat($val);
            break;
        case 'snake_title':
            $val = ucwords(str_replace('_', ' ', strtolower($val)));;
            break;
    }

    return $val;
}

/* get duration from now */
function dateFromNow($val)
{
    $moment = new \Moment\Moment($val, 'Asia/Colombo');

    return $moment->fromNow()->getRelative();
}

function dateFormat($val, $format)
{
    $moment = new \Moment\Moment($val);

    return $moment->format($format);
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

function generateFileDir($folder = null)
{
    $currentRoot = dirname(__DIR__, 2);
    $route = "/assets/uploads/";

    if (empty($folder))
        $folder = date_create()->format('Uv');

    $route .= $folder;

    /* create folder path if does not exist */
    $target_dir = $currentRoot . "/public" . $route;
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    return ["dir" => $target_dir, "url" => ROOT . $route];
}

/* upload file */
function uploadFile($name, $folder = null, $file_name = null)
{
    if (!empty($_FILES[$name]['name'])) {
        /* create upload directory if not exists */
        $currentRoot = dirname(__DIR__, 2);
        $route = "/assets/uploads/";

        /* create a folder path */
        if (empty($folder))
            $folder = date_create()->format('Uv');
        $route .= $folder;

        /* create folder path if does not exist */
        $target_dir = $currentRoot . "/public" . $route;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $info = pathinfo($_FILES[$name]['name']);
        $extension = $info['extension'];

        /* add a file name if not given */
        if (!empty($_FILES[$name]['name']))
            $file_name = $_FILES[$name]['name'];
        else if (empty($file_name))
            $file_name = milliseconds() . "." . $extension;

        $save_path = $target_dir . '/' . $file_name;

        /* save the file */
        $result = move_uploaded_file($_FILES[$name]['tmp_name'], $save_path);

        if (!$result)
            return null;

        return ["url" => ROOT . $route . '/' . $file_name, "name" => $file_name, "result" => $result];
    }

    return null;
}

/* upload QR code */
function generateQRCode($data)
{
    $writer = new PngWriter();

    $qr_code = QrCode::create($data)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
        ->setSize(300)
        ->setMargin(10)
        ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->setForegroundColor(new Color(0, 0, 0))
        ->setBackgroundColor(new Color(255, 255, 255));

    $qr_code_result = $writer->write($qr_code);

    $currentRoot = dirname(__DIR__, 2);
    $route = "/assets/qr-codes/";
    $target_dir = $currentRoot . "/public" . $route;
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = milliseconds() . ".png";
    $qr_code_result->saveToFile($target_dir . $file_name);

    return ROOT . $route . $file_name;
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
        } else if ($val["path"] == $path) {
            $func = $val["id"];
            $val["active"] = 'true';
        }
    }
    return $func;
}

/* to json */
function toJson($data, $attributes = [])
{
    $json = [];

    if (count($attributes) == 0) {
        $json = $data;
    } else {
        foreach ($data as $key => $value) {
            if (in_array($key, $attributes)) {
                $json[$key] = $value;
            }
        }
    }

    return json_encode($json);
}

/* format number */
function numberFormat($number = 0, $decimals = 0)
{
    if (strpos($number, '.') != null) {
        $decimal_numbers = substr($number, strpos($number, '.'));
        $decimal_numbers = substr($decimal_numbers, 1, $decimals);
    } else {
        $decimal_numbers = 0;
        for ($i = 2; $i <= $decimals; $i++) {
            $decimal_numbers = $decimal_numbers . '0';
        }
    }

    $number = (int) $number;
    $number = strrev($number);

    $n = '';
    $str_len = strlen($number);

    for ($i = 0; $i < $str_len; $i++) {
        if ($i == 2 || ($i > 2 && $i % 2 == 0))
            $n = $n . $number[$i] . ',';
        else
            $n = $n . $number[$i];
    }

    $number = $n;
    $number = strrev($number);

    ($decimals != 0) ? $number = $number . '.' . $decimal_numbers : $number;
    if (!empty($number[0]) && $number[0] == ',')
        $number = substr_replace($number, '', 0, 1);
    if (!empty($number[1]) && $number[1] == ',' && $number[0] == '-')
        $number = substr_replace($number, '', 1, 1);

    return $number;
}

/* short a number */
function shortNumber($num = 0)
{
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }

    return round($num, 1) . $units[$i];
}
