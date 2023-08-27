<head>
    <title>ClubHub Central</title>

    <!-- main styles -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/index.css">

    <!-- poppins font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<?php

class App
{
    protected $controller = 'not-found';

    function __construct()
    {
        $arr = $this->getURL();
        $filename = $arr[0];
        $method = $arr[1] ?? 'index';

        unset($arr[0]); // remove the first item of the array
        if (!empty($arr[1])) unset($arr[1]); // remove the second item of the array

        /* get the controller */
        $file = $this->getFilePath($filename);
        if (file_exists($file)) {
            require $file;
            $this->controller = kebabToPascal($filename);
        } else {
            require $this->getFilePath($this->controller);
        }

        /* convert kebab case to pascal case */
        $this->controller = kebabToPascal($this->controller);

        /* initiate the controller */
        $curr_controller = new $this->controller();

        /* create an new array */
        $arr = array_values($arr);

        /* call the controller function */
        call_user_func_array([$curr_controller, $method], $arr);
    }

    private function getURL()
    {
        $url = $_GET['url'] ?? 'home';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $arr = explode('/', $url);

        return $arr;
    }

    private function getFilePath($file)
    {
        return "../app/controllers/" . $file . ".controller.php";
    }
}
