<?php

/* auto load modal */
spl_autoload_register(function ($class_name) {
    require "../app/models/" . _::kebabCase($class_name) . ".php";
});

require "config.php";
require "database.php";
require "modal.php";
require "functions.php";
require "calendar.php";
require "controller.php";
require "app.php";
