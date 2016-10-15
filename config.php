<?php

require "vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_DIR', __DIR__ . '/');
define('DATA_DIR', BASE_DIR . 'data/');
define('LOG_DIR', BASE_DIR . 'logs/');
define('MEDIA_DIR', BASE_DIR . 'media/');
define('ROUTE_DIR', BASE_DIR . 'routes/');

define('ACCOUNTS_DATA_FILE', DATA_DIR . 'accounts.yml');
define('PROXIES_DATA_FILE', DATA_DIR . 'proxies.yml');

require "container.php";