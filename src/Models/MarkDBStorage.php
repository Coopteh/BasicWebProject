<?php
namespace App\Models;

use PDO;

class MarkDBStorage extends DBStorage
{

    public function getAllMarks():mixed {
        global $user_id, $user_role;

        if ($user_role == 'teacher') {
            $sql= "SELECT m.id_mark, m.id_user, m.dt_mark, 
                    m.id_group, m.value_mark, courses.name, users.fio, groups.name as name_group
                   FROM marks as m
                   JOIN courses ON  m.id_course = courses.id_course
                   JOIN users ON m.id_user = users.id_user
                   JOIN groups ON m.id_group = groups.id_group
                   WHERE (m.id_teacher = ".$user_id.") 
                   AND (m.deleted = 0) ORDER BY m.id_mark";
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        } else {
            $sql= "SELECT m.id_mark, m.id_user, m.dt_mark, 
                    m.id_group, m.value_mark, courses.name, users.fio, groups.name as name_group 
                   FROM marks as m
                   JOIN courses ON  m.id_course = courses.id_course
                   JOIN users ON m.id_user = users.id_user
                   JOIN groups ON m.id_group = groups.id_group
                   WHERE m.id_user = ".$user_id."
                   AND (m.deleted = 0) ORDER BY m.id_mark";
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

    public function getRecord($id_rec) {
        $sql= "SELECT id_mark, id_user, id_group, id_course, dt_mark, value_mark, id_teacher
                FROM marks 
                WHERE id_mark = ".$id_rec;
        $result = $this->connection->query($sql);
        $row = $result->fetch();
        return $row;       
    }

    public function saveMark($row)
    {
        if (empty($row['value_mark'])) {
            $sql = "UPDATE `marks` SET 
            `deleted` = 1,
            `id_user`=".$row['id_user'].",
            `id_course`=".$row['id_course'].",
            `dt_mark`='".$row['dt_mark']."',
            `id_teacher`=".$row['id_teacher'].",
            `id_group`=".$row['id_group']."
            WHERE `id_mark` = ".$row['id_mark'];            
        } else {
            $sql = "UPDATE `marks` SET 
            `id_user`=".$row['id_user'].",
            `id_course`=".$row['id_course'].",
            `value_mark`=".$row['value_mark'].",
            `dt_mark`='".$row['dt_mark']."',
            `id_teacher`=".$row['id_teacher'].",
            `id_group`=".$row['id_group']."
            WHERE `id_mark` = ".$row['id_mark'];
        }
        $result = $this->connection->query($sql);
        return $result;
    }
}
