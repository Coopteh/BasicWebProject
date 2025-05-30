<?php
namespace Controllers;

use Models\UserDBStorage;
use Views\UserTemplate;

class Users {
    public function get(): string 
    {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getLoginTemplate();
        return $template;
    }

    public function auth($login,$password)
    {
        $storage = new UserDBStorage();
        $result = $storage->getUser($login,$password);
        if ($result !== false) {
            $_SESSION['user_id']= $result["iduser"];
            $_SESSION['user_name']= $result["login"];
            $_SESSION['user_role']= $result["role"];
        }
        return $result;
    }

    public function getAll(): string 
    {
        $objTemplate = new UserTemplate();
        $storage = new UserDBStorage();
        $result = $storage->getAllUsers();
        $template = $objTemplate->getUsersTemplate($result);
        return $template;
    }    

    public function addUser($row)
    {
        $storage = new UserDBStorage();
        $result = $storage->addUser($row);
        return $result;
    }

    public function getForm() {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getFormTemplate();
        return $template;
    }
}