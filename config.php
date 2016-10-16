<?php

require "vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_time_limit(100);

define('BASE_DIR', __DIR__ . '/');
define('CACHE_DIR', BASE_DIR . 'cache/');
define('DATA_DIR', BASE_DIR . 'data/');
define('LOG_DIR', BASE_DIR . 'logs/');
define('MEDIA_DIR', BASE_DIR . 'media/');
define('ROUTE_DIR', BASE_DIR . 'routes/');

define('ACCOUNTS_DATA_FILE', DATA_DIR . 'accounts.yml');
define('MESSAGES_DATA_FILE', DATA_DIR . 'messages.yml');
define('PROXIES_DATA_FILE', DATA_DIR . 'proxies.yml');
define('SEEDERS_DATA_FILE', DATA_DIR . 'seeders.yml');

define('ROUTER_CACHE_FILE', CACHE_DIR . 'router');

require "container.php";