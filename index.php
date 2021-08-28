<?php

require "bootstrap.php";

use Src\Controller\StatisticsController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ($uri[1] !== 'statistics') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$statisticId = null;
if (isset($uri[2])) {
    $statisticId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new StatisticsController($dbConnection, $requestMethod, $statisticId);
$controller->processRequest();