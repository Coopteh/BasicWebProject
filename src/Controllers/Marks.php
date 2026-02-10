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
    
    public function getForm( $id_rec=0 ) {
        $storage = new MarkDBStorage();
        $groups = $storage->getGroups();
        $students = $storage->getStudents();
        $subjects = $storage->getSubjects();
        if ($id_rec > 0)
            $row = $storage->getRecord($id_rec);
        else
            $row = null;    // это если всатавка данных идет

        $objTemplate = new MarkTemplate();
        $template = $objTemplate->getFormTemplate($row, $groups, $students, $subjects );
        return $template;
    }

    public function addMark($row)
    {
        $storage = new MarkDBStorage();
        $result = $storage->addMark($row);
        return $result;
    }

    public function editMark($row)
    {
        $storage = new MarkDBStorage();
        $result = $storage->saveMark($row);
        return $result;
    }
}