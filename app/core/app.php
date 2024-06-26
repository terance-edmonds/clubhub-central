<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ClubHub Central">
    <link rel="shortcut icon" href="<?= ROOT ?>/assets/images/favicon.ico" type="image/x-icon">

    <!-- app -->
    <title>ClubHub Central</title>

    <!-- main styles -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/index.css">
    <!-- pre loader -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/pre-loader.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Peta:wght@100;200;300;400;500;600;700;800;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- font-icons -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    <!-- select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
</head>

<body>
    <!-- pre loader -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ?>
        <div data-active="true" id="pre-loader">
            <div class="loader-wrapper">
                <div class="loader"></div>
            </div>
        </div>
    <?php } ?>

    <?php

    class App
    {
        protected $controller = 'not-found';

        function __construct()
        {
            $arr = $this->getURL();
            $filename = $arr[0];
            $method = $arr[1] ?? 'index';

            /* route authentication */
            $authorized = Auth::authenticate($_GET);
            if (!$authorized) {
                $filename = 'not-found';
                $method = 'index';
            };

            unset($arr[0]); // remove the first item of the array
            if (!empty($arr[1])) unset($arr[1]); // remove the second item of the array

            /* get the controller */
            $file = $this->getFilePath($filename);

            if (file_exists($file)) {
                require $file;
                $this->controller = $filename;
            } else {
                require $this->getFilePath($this->controller);
                $method = "index";
            }

            /* convert kebab case to pascal case */
            $this->controller = _::startCase($this->controller);
            $this->controller = str_replace(" ", "", $this->controller);

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

        private function getFilePath($fileName)
        {
            return "../app/controllers/" . $fileName . ".php";
        }
    }

    ?>

    <div id="overlay"></div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- other -->
    <script src="<?= ROOT ?>/assets/js/index.js"></script>
    <script src="<?= ROOT ?>/assets/js/pre-loader.js"></script>
    <script src="<?= ROOT ?>/assets/js/libs/moment.min.js"></script>
    <script src="<?= ROOT ?>/assets/js/libs/moment-timezone-with-data.min.js"></script>

    <!-- select2 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
</body>

</html>