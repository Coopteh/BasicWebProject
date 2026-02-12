<?php
ini_set('default_charset', 'UTF-8');  
require_once("./vendor/autoload.php");

use App\Routers\Router;

$user_id=0;
$user_name=""; 
$user_role="";

// Обновляем глобальные переменные - данными из сессии
session_start();
if (isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
if (isset($_SESSION['user_name']))
    $user_name = $_SESSION['user_name'];
if (isset($_SESSION['user_role']))
    $user_role = $_SESSION['user_role'];

$router = new Router();
$url = $_SERVER['REQUEST_URI'];

echo $router->route($url);
