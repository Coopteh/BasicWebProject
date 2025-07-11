<?php
namespace Routers;

use Controllers\Home;
use Controllers\Users;
use Controllers\Scores;
use Controllers\Subjects;

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
                    //var_dump($_POST);
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
            case 'scores':
                $scoreController = new Scores();
                $html_result = $scoreController->getAll();
                break; 
            case 'subjects':
                $subjectsController = new Subjects();
                $html_result = $subjectsController->getAll();
                break;                
            case 'users':
                $userController = new Users();
                $html_result = $userController->getAll();
                break; 
            case 'add_score':
                $scoreController = new Scores();
                if (isset($_POST['idstudent']) && isset($_POST['score'])) {
                    $row= array(
                        'idstudent' => $_POST['idstudent'], 
                        'idgroup' => $_POST['idgroup'], 
                        'idsubject' => $_POST['idsubject'], 
                        'date_score' => $_POST['date_score'],
                        'score' => $_POST['score']
                    );
                    //var_dump($row);
                    //exit();
                    if ($scoreController->addScore($row)) {
                        self::addFlash("Оценка успешно добавлена");
                        header('Location: /scores');
                        return '';
                    } else {
                        self::addFlash("Ошибка добавления оценки", "alert-danger");
                    }
                }                   
                $html_result = $scoreController->getForm();
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