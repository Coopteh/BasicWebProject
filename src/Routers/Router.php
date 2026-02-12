<?php
namespace App\Routers;

use App\Controllers\Home;
use App\Controllers\Users;
use App\Controllers\Marks;
use App\Controllers\Courses;

class Router {
    public function route(string $url):?string 
    {
        $path = parse_url($url, PHP_URL_PATH);  
        //     /products/12

        $pieces = explode("/", $path);          
        // [0]- пусто, [1]- products, [2]- 12
        
        $id = 0;
        // Идентификатор найден
        if (isset($pieces[2]) && !empty($pieces[2])) {
            $id = intval($pieces[2]);
        }
        // метод GET, POST, DELETE
    	$method = $_SERVER['REQUEST_METHOD'];

        $resource = $pieces[1];
        $html_result = "";

        switch ($resource) {
            case 'login':
                $userController = new Users();
                if (isset($_POST['login']) && isset($_POST['password'])) {
                    if ($userController->auth($_POST['login'],$_POST['password'])) {
                        self::addFlash("Успешно пройдена аутентификация пользователя");
                        header('Location: /');
                        return '';
                    } else {
                        self::addFlash("Такого пользователя нет в БД", "alert-danger");
                    }
                }
                $html_result = $userController->get();
                break;
            case 'logout':
                unset($_SESSION['user_id']);
                unset($_SESSION['user_name']);
                unset($_SESSION['user_role']);
                self::addFlash("Вы вышли из аккаунта");
                header('Location: /');
                return ''; 
            case 'services':
                $controller = new Service();
                $html_result = $controller->getAll();
                break;          
            case 'add_record':
                $controller = new Service();
                if (isset($_POST['id_user']) && isset($_POST['price'])) {
                    $row= array(
                        'id_user' => $_POST['id_user'], 
                        'date_service' => $_POST['date_service'],
                        'price' => $_POST['price'],
                        'name' => $_POST['name'],
                    );
                    if ($controller->add($row)) {
                        self::addFlash("Запись успешно добавлена");
                        header('Location: /services');
                        return '';
                    } else {
                        self::addFlash("Ошибка добавления записи", "alert-danger");
                    }
                }                   
                $html_result = $controller->getForm();
                break;
            case 'edit_record':
                $controller = new Service();
                if (isset($_POST['id_user']) && isset($_POST['price'])) {
                    $row= array(
                        'id_user' => $_POST['id_user'], 
                        'date_service' => $_POST['date_service'],
                        'price' => $_POST['price'],
                        'name' => $_POST['name'],
                    );
                    if ($controller->edit($row)) {
                        self::addFlash("Запись успешно изменена");
                        header('Location: /services');
                        return '';
                    } else {
                        self::addFlash("Ошибка изменения записи", "alert-danger");
                    }
                }     
                if (isset($_POST['id_service']))
                    $html_result = $controller->getForm($_POST['id_service']);
                else {
                    self::addFlash("Ошибка изменения записи", "alert-danger");
                    header('Location: /services');
                    return '';
                }
                break;
            default:
                $home = new Home();
                $html_result = $home->get();
                break;
        }
        
        return $html_result;
    }

    public static function addFlash($str, $type='alert-info') 
    {
        $_SESSION['flash'] = $str;
        $_SESSION['flash_class'] = $type;
    }
}