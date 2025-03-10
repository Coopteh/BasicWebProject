<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Route\Router;
use App\Controller\BlogController;

$router = new Router();
$router->addRoute('/project/', [new BlogController(), 'index']);
$router->dispatch($_SERVER['REQUEST_URI']);
