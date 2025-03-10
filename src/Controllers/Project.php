<?php
namespace Controllers;

use Models\ProjectDBStorage;
use Views\ProjectTemplate;

class Project {
    public function getAll(): string 
    {
        $objTemplate = new ProjectTemplate();
        $storage = new ProjectDBStorage();
        $result = $storage->getAll();
        $template = $objTemplate->getProjectTemplate($result);
        return $template;
    }    

    public function add($row)
    {
        $storage = new ProjectDBStorage();
        $result = $storage->add($row);
        return $result;
    }
    
    public function getForm() {
        $objTemplate = new ProjectTemplate();
        $template = $objTemplate->getFormTemplate();
        return $template;
    }
}