<?php
namespace Views;

use Views\BaseTemplate;

class ProjectTemplate extends BaseTemplate {
    public function getProjectTemplate($rows): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-8 offset-md-2">
        END;

        $str .= <<<END
        <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Описание</th>
            <th scope="col">Дата начала</th>
            <th scope="col">Дата окончания</th>
            <th scope="col">Статус работы</th>
          </tr>
        </thead>
        <tbody>
        END;

        foreach($rows as $row)
            $str .= <<<LINE
                <tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['description']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
                <td>{$row['status']}</td>
                </tr>
            LINE;

        $str .= <<<END
                </tbody>
            </table>        
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Список проектов', $str);
        return $resultTemplate;
    }

    public function getFormTemplate() 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <form method="post" action="/add">
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Название преокта:</label>
                    <input type="text" name="name" id="form2Example1" class="form-control" required/>
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example2">Описание:</label>
                    <input type="text" name="description" id="form2Example2" class="form-control" required/>
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example3">Дата начала:</label>
                    <input type="date" class="form-control" id="dateInput" name="start_date" required>
                    <div class="invalid-feedback">Поле обязательное</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example3">Дата окончания:</label>
                    <input type="date" class="form-control" id="dateInput" name="end_date" required>
                    <div class="invalid-feedback">Поле обязательное</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example3">Статус работы:</label>
                    <select class="form-select" name="status" aria-label="project" id="form2Example3">
                    <option value="В работе">В работе</option>
                    <option value="Завершен">Завершен</option>
                    <option value="Отменен">Отменен</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Добавить</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Добавление пользователя', $str);
        return $resultTemplate;   
    }
}