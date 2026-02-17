<?php
namespace App\Controllers;

use App\Models\ServiceDBStorage;
use App\Views\ServiceTemplate;

class Service {
    public function getAll(): string 
    {
        $objTemplate = new ServiceTemplate();
        $storage = new ServiceDBStorage();
        $result = $storage->getAllServices();

        $template = $objTemplate->getServiceTemplate($result);
        return $template;
    }    
    
    public function getForm( $id_rec=0 ) {
        $storage = new ServiceDBStorage();
        if ($id_rec > 0)    // это изменение записи
            $row = $storage->getRecord($id_rec);
        else
            $row = null;    // это вставка данных идет
        $clients = $storage->getClients();

        $objTemplate = new ServiceTemplate();
        $template = $objTemplate->getFormTemplate($row, $clients);
        return $template;
    }

    // Вставка новой записи после добавления данных в форме
    public function addService($row)
    {
        $storage = new ServiceDBStorage();
        $result = $storage->addService($row);
        return $result;
    }

    // Передача данных (изменение) после редактирования в форме
    public function editService($row)
    {
        $storage = new ServiceDBStorage();
        $result = $storage->saveService($row);
        return $result;
    }

    public function deleteService($id_rec)
    {
        $storage = new ServiceDBStorage();
        $result = $storage->deleteService($id_rec);
        return $result;    
    }
}