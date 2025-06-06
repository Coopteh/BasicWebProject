<?php
namespace Views;

use Views\BaseTemplate;

class ScoreTemplate extends BaseTemplate {

    public function getScoreTemplate($rows, $groups, $students): string 
    {
    global $user_name;
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <h1>Журнал оценок (студент {$user_name})</h1>

        END;
        $str .= <<<SELECT
        <form method="GET">
        <div class="m-3">
        <select class="form-select" aria-label="Default select example" name="select_group">
            <option selected>Выберите группу</option>
        SELECT;
        foreach($groups as $group) {
            if (isset($_GET["select_group"]) and ($group['idgroup']==$_GET["select_group"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$group['idgroup'].'" '.$selected.'>'.$group['name'].'</option>';
        }
        $str.='</select>';

        $str .= <<<SELECT
        <select class="form-select" aria-label="Default select example" name="select_student">
            <option selected>Выберите студента</option>
        SELECT;
        foreach($students as $student) {
            if (isset($_GET["select_student"]) and ($student['iduser']==$_GET["select_student"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$student['iduser'].'" '.$selected.'>'.$student['login'].'</option>';
        }
        $str.='</select>';

        $str.='<button type="submit" class="btn btn-primary">фильтровать</button>
        </div></form>';


        $str .= <<<END
        <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Дисциплина</th>
                <th scope="col">Дата</th>
                <th scope="col">Оценка</th>
                <th scope="col">Группа</th>
                <th scope="col">Студент</th>
            </tr>
        </thead>
        <tbody>
        END;

        foreach($rows as $row) {
            if (isset($_GET["select_group"]) and ($row['idgroup']==$_GET["select_group"])) {
                $str .= <<<LINE
                    <tr>
                    <td>{$row['idscore']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['date_score']}</td>
                    <td>{$row['score']}</td>
                    <td>{$row['name_group']}</td>
                    <td>{$row['fio']}</td>
                    </tr>
                LINE;
            } else 
                if (isset($_GET["select_student"]) and ($row['iduser']==$_GET["select_student"])) {
                    $str .= <<<LINE
                        <tr>
                        <td>{$row['idscore']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['date_score']}</td>
                        <td>{$row['score']}</td>
                        <td>{$row['name_group']}</td>
                        <td>{$row['fio']}</td>
                        </tr>
                    LINE;
                } else 
                if (!isset($_GET["select_group"]) and !isset($_GET["select_student"])) {     
                    $str .= <<<LINE
                        <tr>
                        <td>{$row['idscore']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['date_score']}</td>
                        <td>{$row['score']}</td>
                        <td>{$row['name_group']}</td>
                        <td>{$row['fio']}</td>
                        </tr>
                    LINE;
                }
        }

        $str .= <<<END
                </tbody>
            </table>        

            <form action="/add_score" method="POST">
                <button type="submit" class="btn btn-primary">Добавить запись</button>
            </form>


            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Журнал оценок', $str);
        return $resultTemplate;
    }

    public function getFormTemplate($groups, $students, $subjects) 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <h1>Добавление оценки</h1>
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <form method="post" action="/add_score">
        END;

        // Выбор студента
        $str .= <<<SELECT1
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="idstudent">
            <option selected>Выберите студента</option>
        SELECT1;
        foreach($students as $student) {
            if (isset($_POST["idstudent"]) and ($student['iduser']==$_POST["idstudent"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$student['iduser'].'" '.$selected.'>'.$student['login'].'</option>';
        }
        $str.='</select></div>';

        // Выбор группы
        $str .= <<<SELECT
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="idgroup">
            <option selected>Выберите группу</option>
        SELECT;
        foreach($groups as $group) {
            if (isset($_POST["idgroup"]) and ($group['idgroup']==$_POST["idgroup"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$group['idgroup'].'" '.$selected.'>'.$group['name'].'</option>';
        }
        $str.='</select></div>';

        // Выбор дисциплины
        $str .= <<<SELECT
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="idsubject">
            <option selected>Выберите дисциплину</option>
        SELECT;
        foreach($subjects as $subject) {
            if (isset($_POST["idsubject"]) and ($subject['idsubject']==$_POST["idsubject"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$subject['idsubject'].'" '.$selected.'>'.$subject['name'].'</option>';
        }
        $str.='</select></div>';

        $str .= <<<FIELDS
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Дата:</label>
                <input type="text" name="date_score" id="form2Example1" class="form-control" required/>
                <div class="invalid-feedback">Поле обязательно к заполнению</div>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example1">Оценка:</label>
                <input type="text" name="score" id="form3Example1" class="form-control" required/>
                <div class="invalid-feedback">Поле обязательно к заполнению</div>
            </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Добавить</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        FIELDS;
        $resultTemplate =  sprintf($template, 'Добавление оценки', $str);
        return $resultTemplate;   
    }
}