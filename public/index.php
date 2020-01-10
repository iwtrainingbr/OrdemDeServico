<?php

ini_set('display_errors', 1);

$url = $_SERVER['REQUEST_URI'];

session_start();

include '../vendor/autoload.php';

$routes = include_once '../config/routes.php';

if (!isset($routes[$url])) {
    (new MainController)->notFound();
    exit;
}

$controller = $routes[$url]['controller'];
$method = $routes[$url]['method'];

(new $controller)->$method();
