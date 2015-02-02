<?php
require 'Slim/Slim.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

define("SPECIALCONSTANT", true);

require 'app/Controller/Controller.php';

$app->run();