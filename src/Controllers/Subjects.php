<?php
namespace Controllers;

use Models\SubjectsDBStorage;
use Views\SubjectsTemplate;

class Subjects {
    public function getAll(): string 
    {
        $objTemplate = new SubjectsTemplate();
        $storage = new SubjectsDBStorage();

        $result = $storage->getAllSubjects();

        $template = $objTemplate->getSubjectsTemplate($result);
        return $template;
    }    
}