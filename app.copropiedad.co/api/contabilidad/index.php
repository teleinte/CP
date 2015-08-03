<?php
require 'Slim/Slim.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

define("SPECIALCONSTANT", true);

require 'app/Controller/ContabilidadController.php';

$app->run();