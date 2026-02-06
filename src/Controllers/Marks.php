<?php
namespace App\Controllers;

use App\Models\MarkDBStorage;
use App\Views\MarkTemplate;

class Marks {
    public function getAll(): string 
    {
        $objTemplate = new ScoreTemplate();
        $storage = new ScoreDBStorage();
        $result = $storage->getAllScores();

        $groups = $storage->getGroups();
        $students = $storage->getStudents();

        $template = $objTemplate->getScoreTemplate($result, $groups, $students );

        return $template;
    }    
    
    public function getForm() {
        $storage = new ScoreDBStorage();
        $groups = $storage->getGroups();
        $students = $storage->getStudents();
        $subjects = $storage->getSubjects();

        $objTemplate = new ScoreTemplate();
        $template = $objTemplate->getFormTemplate($groups, $students, $subjects);
        return $template;
    }

    public function addScore($row)
    {
        $storage = new ScoreDBStorage();
        $result = $storage->addScore($row);
        return $result;
    }
}