<?php

use Root\Controller\MainController;

ini_set('display_errors', 1);

$url = explode('?', $_SERVER['REQUEST_URI'])[0];

session_start();

include '../vendor/autoload.php';
include '../config/database.php';

$routes = include_once '../config/routes.php';

if (!isset($routes[$url])) {
    (new MainController)->notFound();
    exit;
}

$controller = $routes[$url]['controller'];
$method = $routes[$url]['method'];

(new $controller)->$method();
