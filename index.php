<?php

require 'config.php';

$route = @$_GET['route'];

if(empty($route)){
    die('NOT FOUND');
}

$routeFile = PUBLIC_DIR . '/' . $route . '.php';

if(!file_exists($routeFile)){
    die('ROUTE DOES NOT EXIST');
}

require $routeFile;