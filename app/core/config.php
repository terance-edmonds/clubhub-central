<?php

/* env */
$currentRoot = dirname(__DIR__, 2);
require_once $currentRoot . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($currentRoot);
$dotenv->load();

/* app info */
$currentServer = $_SERVER['SERVER_NAME'];
$currentProtocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$currentDomain = $_SERVER['HTTP_HOST'];

/* set variables */
define('ROOT', $currentProtocol . $currentDomain . $_ENV["ROOT"]);

/* database variables */
define('DB_NAME', $_ENV["DB_NAME"]);
define('DB_HOST', $_ENV["DB_HOST"]);
define('DB_USER', $_ENV["DB_USER"]);
define('DB_PASS', $_ENV["DB_PASS"]);
define('DB_DRIVER', $_ENV["DB_DRIVER"]);

/* mail variables */
define('MAIL_HOST', $_ENV["MAIL_HOST"]);
define('MAIL_USERNAME', $_ENV["MAIL_USERNAME"]);
define('MAIL_USER', $_ENV["MAIL_USER"]);
define('MAIL_PASS', $_ENV["MAIL_PASS"]);
