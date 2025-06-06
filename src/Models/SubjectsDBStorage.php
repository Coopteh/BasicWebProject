<?php
namespace Models;

use PDO;

class SubjectsDBStorage extends DBStorage
{

    public function getAllSubjects():mixed {
        global $user_id, $user_role;

        $sql= "SELECT idsubject, name  FROM subjects
               WHERE idteacher = ".$user_id;
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

}
