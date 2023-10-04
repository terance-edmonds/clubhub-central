<?php

class Controller
{
    function view($filename, $data = [])
    {
        $path = "../app/views/" . $filename;
        extract($data); /* extract the elements in $data array */

        if (file_exists($path . ".php")) {
            require $path . ".php";
        } else if (is_dir($path)) {
            $filename = "/index.php";

            /* if path is a directory import index.php */
            if (file_exists($path . $filename)) {
                require $path . $filename;
            } else {
                echo "view index.php file not found: " . $path;
            }
        } else {
            echo "view file not found: " . $path;
        }
    }
}
