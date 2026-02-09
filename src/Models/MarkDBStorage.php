<?php
namespace App\Models;

use PDO;

class MarkDBStorage extends DBStorage
{

    public function getAllMarks():mixed {
        global $user_id, $user_role;

        if ($user_role == 'teacher') {
            $sql= "SELECT m.id_mark, m.id_user, m.dt_mark, 
                    m.id_group, m.value_mark, courses.name, users.fio 
                   FROM marks as m
                   JOIN courses ON  m.id_course = courses.id_course
                   JOIN users ON m.id_user = users.id_user
                   WHERE m.id_teacher = ".$user_id;
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        } else {
            $sql= "SELECT m.id_mark, m.id_user, m.dt_mark, 
                    m.id_group, m.value_mark, courses.name, users.fio 
                   FROM marks as m
                   JOIN courses ON  m.id_course = courses.id_course
                   JOIN users ON m.id_user = users.id_user
                   WHERE m.id_user = ".$user_id;
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        }
    }

    public function getGroups() {
        $sql= "SELECT id_group, name  FROM groups";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function getStudents() {
        $sql= "SELECT id_user, id_group, fio FROM users WHERE role='student'";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function getSubjects() {
        global $user_id, $user_role;
        $sql= "SELECT id_course, name  FROM courses WHERE 1";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function addMark($row) {
    global $user_id;
        $sql = "INSERT INTO `marks` 
        (`id_user`, `id_group`, `id_course`, `dt_mark`, `value_mark`, `id_teacher`) 
        VALUES 
        ('".$row['id_user']."','".$row['id_group']."','".$row['id_course']."',
        '".$row['dt_mark']."', '".$row['value_mark']."', ".$user_id." )";
 //var_dump($sql);
 //exit();        
        $result = $this->connection->query($sql);
        return $result;
    }
}
