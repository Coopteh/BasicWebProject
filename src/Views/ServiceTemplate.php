<?php
namespace App\Views;

use App\Views\BaseTemplate;

class ServiceTemplate extends BaseTemplate {

    public function getServiceTemplate($rows): string 
    {
    global $user_name, $user_role;
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-10 offset-md-1">
            <h3>Журнал услуг</h3>
        END;

        if ($user_role == 'user') {
            $str .= <<<END
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Услуга</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Клиент</th>
                </tr>
            </thead>
            <tbody>
            END;
        } else {
            $str .= <<<END
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Услуга</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Клиент</th>
                    <th scope="col text-end">Операции</th>
                </tr>
            </thead>
            <tbody>
            END;
        }

        foreach($rows as $row) {
            $mydate = mb_substr($row['date_service'],0,10);
            $str .= <<<LINE
                <tr>
            <td>{$row['id_service']}</td>
            <td>{$row['name']}</td>
            <td>{$mydate}</td>
            <td>{$row['price']}</td>
            <td>{$row['fio']}</td>
            LINE;
            // проверка роли для операций изменения и удаления
            if ($user_role == 'editor') {
                $str .= <<<LINE2
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <form action="/edit_record" method="POST">
                        <input type="hidden" name="id_service" value="{$row['id_service']}">
                        <button type="submit" class="btn btn-primary btn-sm">Изменить</button>
                    </form>
                    <form action="/delete_record" method="POST">
                        <input type="hidden" name="id_service" value="{$row['id_service']}">
                        <button type="submit" class="btn btn-primary btn-sm">Удалить</button>
                    </form>  
                    </div>                  
                </td>      
                LINE2;
            }
            $str .= "</tr>";
        }
        $str .= "</tbody></table>";

        // проверка роли для операции добавления записи
        if ($user_role == 'editor') {
            $str .= <<<ADD
            <form action="/add_record" method="POST">
                <button type="submit" class="btn btn-primary">Добавить запись</button>
            </form>
            ADD;
        }
        $str .= '</div></div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>';

        $resultTemplate =  sprintf($template, 'Журнал оценок', $str);
        return $resultTemplate;
    }

    public function getFormTemplate($row, $clients) 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        if ($row) {
            $title = "Изменение услуги";
            $fromUrl = "/edit_record";
            $btnTitle = "Сохранить";
            $valueDateService = mb_substr($row['date_service'], 0, 10);
            $serviceValue = $row['price'];
            $nameService = $row['name'];
        } else {
            $title = "Добавление услуги";
            $fromUrl = "/add_record";
            $btnTitle = "Сохранить";
            $valueDateService = date('Y-m-d');
            $serviceValue = '';
            $nameService ='';
        }   
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <h3 class="mb-3">{$title}</h3>
            <form method="post" action="{$fromUrl}">
        END;
        if ($row) {
            $str .= '<input type="hidden" name="id_service" value="'.$row['id_service'].'">';
        }
        // Выбор клиента
        $str .= <<<SELECT1
        <div data-mdb-input-init class="form-outline mt-4 mb-4">
            <label class="form-label" for="selectIdUser">Клиент:</label>
            <select class="form-select" aria-label="Default select example" name="id_user" id="selectIdUser">
                <option selected>Выберите клиента</option>
        SELECT1;
        foreach($clients as $client) {
            if (isset($row["id_user"]) and ($client['id_user']==$row["id_user"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$client['id_user'].'" '.$selected.'>'.$client['fio'].'</option>';
        }
        $str.='</select></div>';

        $str .= <<<FIELDS
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Название:</label>
                    <input type="text" name="name" id="form2Example1" 
                        class="form-control" required value="{$nameService}" />
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Дата:</label>
                    <input type="text" name="date_service" id="form2Example1" 
                        class="form-control" required value="{$valueDateService}" />
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form3Example1">Стоимость:</label>
                    <input type="text" name="price" id="form3Example1" 
                    class="form-control" value="{$serviceValue}" />
                </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init 
                    class="btn btn-primary btn-block mb-4">{$btnTitle}</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        FIELDS;
        $resultTemplate =  sprintf($template, $title, $str);
        return $resultTemplate;   
    }
}