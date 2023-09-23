<?php

class Controller
{
    function view($filename, $data = [])
    {
        $path = "../app/views/" . $filename . ".php";
        extract($data); /* extract the elements in $data array */

        if (file_exists($path)) {
            require $path;
        } else {
            echo "view file not found: " . $path;
        }
    }
}
