<?php

require '../vendor/autoload.php';

\Core\App::run($_SERVER['REQUEST_URI'], $_POST, $_GET, $_FILES);

