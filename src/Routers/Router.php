<?php
namespace Routers;

use Controllers\Home;
use Controllers\Project;

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
        session_start();

        switch ($resource) {
            /*case "products":
                $product = new Product();
                if ($id)
                    $html_result = $product->get($id);
                else
                    $html_result = $product->getAll();
                break;*/
            case 'list':
                $projectController = new Project();
                $html_result = $projectController->getAll();
                break;                
            case 'add':
                $projectController = new Project();
                if (isset($_POST['name']) && isset($_POST['status'])) {
                    $row= array(
                        'name' => $_POST['name'], 
                        'description' => $_POST['description'], 
                        'start_date' => date("Y-m-d",strtotime($_POST['start_date'])),
                        'end_date' => date("Y-m-d",strtotime($_POST['end_date'])),
                        'status' => $_POST['status']
                    );
                    //var_dump($row);
                    //exit();
                    if ($projectController->add($row)) {
                        self::addFlash("Проект успешно добавлен");
                        header('Location: /');
                        return '';
                    } else {
                        self::addFlash("Ошибка добавления проекта", "alert-danger");
                    }
                }                
                $html_result = $projectController->getForm();
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