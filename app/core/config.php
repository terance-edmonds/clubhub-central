<?php

/* app info */
$currentProtocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$currentDomain = $_SERVER['HTTP_HOST'];


if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('ROOT', $currentProtocol . $currentDomain . '/chc/public');
} else {
    define('ROOT', $currentProtocol . $currentDomain);
}
