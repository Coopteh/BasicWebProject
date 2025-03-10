<?php
require 'Models/User.php';  // Подключаем автозагрузчик Composer
require 'Controllers/UserController.php';

use App\Models\User;
use App\Controllers\UserController;

$user = new User();
echo $user->getName();  // Вывод: Пользователь

$controller = new UserController();
echo $controller->getControllerName();  // Вывод: Контроллер пользователя