<?php

require "vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_DIR', __DIR__ . '/');
define('DATA_DIR', BASE_DIR . 'data');
define('ROUTE_DIR', BASE_DIR . 'routes');