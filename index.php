<?php

require "bootstrap.php";

use Src\Controller\StatisticsController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[1] !== 'statistics') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$statisticId = null;
if (isset($uri[2])) {
    $statisticId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$statisticsController = new StatisticsController($dbConnection, $requestMethod, $statisticId);
$statisticsController->processRequest();