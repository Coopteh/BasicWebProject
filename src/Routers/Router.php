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
            /*case "products":
                $product = new Product();
                if ($id)
                    $html_result = $product->get($id);
                else
                    $html_result = $product->getAll();
                break;*/
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
            case 'marks':
                $controller = new Marks();
                $html_result = $controller->getAll();
                break; 
            case 'subjects':
                $subjectsController = new Subjects();
                $html_result = $subjectsController->getAll();
                break;                
            case 'users':
                $userController = new Users();
                $html_result = $userController->getAll();
                break; 
            case 'add_mark':
                $controller = new Marks();
                if (isset($_POST['id_user']) && isset($_POST['value_mark'])) {
                    $row= array(
                        'id_user' => $_POST['id_user'], 
                        'id_group' => $_POST['id_group'], 
                        'id_course' => $_POST['id_course'], 
                        'dt_mark' => $_POST['dt_mark'],
                        'value_mark' => $_POST['value_mark']
                    );
                    //var_dump($row);
                    //exit();
                    if ($controller->addMark($row)) {
                        self::addFlash("Оценка успешно добавлена");
                        header('Location: /marks');
                        return '';
                    } else {
                        self::addFlash("Ошибка добавления оценки", "alert-danger");
                    }
                }                   
                $html_result = $controller->getForm();
                break;
            case 'edit_mark':
                $controller = new Marks();
                if (isset($_POST['id_user']) && isset($_POST['value_mark'])) {
                    $row= array(
                        'id_mark' => $_POST['id_mark'], 
                        'id_teacher' => $_POST['id_teacher'],
                        'id_user' => $_POST['id_user'], 
                        'id_group' => $_POST['id_group'], 
                        'id_course' => $_POST['id_course'], 
                        'dt_mark' => $_POST['dt_mark'],
                        'value_mark' => $_POST['value_mark']
                    );
                    if ($controller->editMark($row)) {
                        self::addFlash("Оценка успешно изменена");
                        header('Location: /marks');
                        return '';
                    } else {
                        self::addFlash("Ошибка изменения оценки", "alert-danger");
                    }
                }     
                if (isset($_POST['id_mark']))
                    $html_result = $controller->getForm($_POST['id_mark']);
                else {
                    self::addFlash("Ошибка изменения записи", "alert-danger");
                    header('Location: /marks');
                    return '';
                }
                break;
            case 'add_user':
                $userController = new Users();
                if (isset($_POST['login']) && isset($_POST['password'])) {
                    $row= array(
                        'login' => $_POST['login'], 
                        'password' => $_POST['password'], 
                        'role' => $_POST['role']
                    );
                    //var_dump($row);
                    //exit();
                    if ($userController->addUser($row)) {
                        self::addFlash("Пользователь успешно добавлен");
                        header('Location: /');
                        return '';
                    } else {
                        self::addFlash("Ошибка добавления пользователя", "alert-danger");
                    }
                }                
                $html_result = $userController->getForm();
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