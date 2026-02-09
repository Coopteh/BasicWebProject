<?php
namespace App\Controllers;

use App\Models\MarkDBStorage;
use App\Views\MarkTemplate;

class Marks {
    public function getAll(): string 
    {
        $objTemplate = new MarkTemplate();
        $storage = new MarkDBStorage();
        $result = $storage->getAllMarks();

        $groups = $storage->getGroups();
        $students = $storage->getStudents();

        $template = $objTemplate->getMarkTemplate($result, $groups, $students );

        return $template;
    }    
    
    public function getForm() {
        $storage = new MarkDBStorage();
        $groups = $storage->getGroups();
        $students = $storage->getStudents();
        $subjects = $storage->getSubjects();

        $objTemplate = new MarkTemplate();
        $template = $objTemplate->getFormTemplate($groups, $students, $subjects);
        return $template;
    }

    public function addMark($row)
    {
        $storage = new MarkDBStorage();
        $result = $storage->addMark($row);
        return $result;
    }
}