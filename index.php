<?php
define('ROOT', __DIR__);
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
(new \Juslintek\Supermetrics\App)();
