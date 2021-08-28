<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\Config\Database;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

$dbConnection = (new Database())->getConnection();