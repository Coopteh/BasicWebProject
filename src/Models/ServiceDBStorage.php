<?php
namespace App\Models;

use PDO;

class ServiceDBStorage extends DBStorage
{

    // получаем все записи для таблицы журнала
    public function getAllServices():mixed {
        global $user_id, $user_role;

        if ($user_role == 'tech') {
            $sql= "SELECT m.id_service, m.id_user, m.date_service, 
                    m.name, m.price, users.fio
                   FROM services as m
                   JOIN users ON m.id_user = users.id_user
                   WHERE (m.deleted = 0) ORDER BY m.id_service DESC";
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        } else {
            $sql= "SELECT m.id_service, m.id_user, m.date_service, 
                    m.name, m.price, users.fio
                   FROM services as m
                   JOIN users ON m.id_user = users.id_user
                   WHERE (m.id_user = ".$user_id.") 
                   AND (m.deleted = 0) ORDER BY m.id_service DESC";
            $result = $this->connection->query($sql);
            $rows = $result->fetchAll();
            return $rows;
        }
    }

    public function addService($row) {
    global $user_id;
        $sql = "INSERT INTO `services` 
        (`name`, `price`, `id_user`) 
        VALUES 
        ('".$row['name']."','".$row['price']."','".$row['id_user']."')";
 //var_dump($sql);
 //exit();        
        $result = $this->connection->query($sql);
        return $result;
    }

    public function getRecord($id_rec) {
        $sql= "SELECT id_service, id_user, date_service, name, price, deleted
                FROM services 
                WHERE id_service = ".$id_rec;
        $result = $this->connection->query($sql);
        $row = $result->fetch();
        return $row;       
    }

    public function saveService($row)
    {
        $sql = "UPDATE `services` SET 
        `name`='".$row['name']."',
        `price`='".$row['price']."',
        `id_user`='".$row['id_user']."',
        `date_service`='".$row['date_service']."'
        WHERE `id_service` = ".$row['id_service'];

        $result = $this->connection->query($sql);
        return $result;
    }

    public function getClients() {
        $sql= "SELECT id_user, fio FROM users WHERE role='client'";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function deleteService($id_rec)
    {
        $sql = "UPDATE `services` SET `deleted`=1
        WHERE `id_service` = ".$id_rec;
        $result = $this->connection->query($sql);
        return $result;
    }
}
