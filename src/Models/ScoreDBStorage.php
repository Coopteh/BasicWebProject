<?php
namespace Models;

use PDO;

class ScoreDBStorage extends DBStorage
{

    public function getAllScores():mixed {
        global $user_id, $user_role;

        if ($user_role == 'teacher') {
            $sql= "SELECT scores.idscore, scores.idgroup, scores.iduser, scores.date_score, scores.score, subjects.name,
            user2.login as fio, groups.name as name_group FROM scores 
                    JOIN subjects ON scores.idsubject = subjects.idsubject
                    JOIN users ON subjects.idteacher = users.iduser and users.iduser = ".$user_id."
                    JOIN groups ON scores.idgroup = groups.idgroup
                    JOIN users as user2 ON scores.iduser = user2.iduser";
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        } else {
            $sql= "SELECT scores.idscore, scores.date_score, scores.score, subjects.name  FROM scores 
                    JOIN subjects ON scores.idsubject = subjects.idsubject
                    WHERE iduser = ".$user_id;
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        }
    }

    public function getGroups() {
        $sql= "SELECT idgroup, name  FROM groups";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function getStudents() {
        $sql= "SELECT iduser, idgroup, login FROM users WHERE role='student'";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function getSubjects() {
        global $user_id, $user_role;
        $sql= "SELECT idsubject, name  FROM subjects WHERE idteacher=".$user_id;
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function addScore($row) {      
        $sql = "INSERT INTO `scores` (`iduser`, `idgroup`, `idsubject`, `date_score`, `score`) 
        VALUES ('".$row['idstudent']."','".$row['idgroup']."','".$row['idsubject']."',
        '".$row['date_score']."', '".$row['score']."' )";
// var_dump($sql);
// exit();        
        $result = $this->connection->query($sql);
        return $result;
    }
}
