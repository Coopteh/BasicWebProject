<?php
namespace Controllers;

use Models\ScoreDBStorage;
use Views\ScoreTemplate;

class Scores {
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
}