<?php
namespace App\Views;

use App\Views\BaseTemplate;

class MarkTemplate extends BaseTemplate {

    public function getMarkTemplate($rows, $groups, $students): string 
    {
    global $user_name;
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-10 offset-md-1">
            <h1>Журнал оценок</h1>
        END;
        $str .= <<<SELECT
        <form method="GET">
        <div class="m-3">
        <select class="form-select" aria-label="Default select example" name="select_group">
            <option selected>Выберите группу</option>
        SELECT;
        foreach($groups as $group) {
            if (isset($_GET["select_group"]) and ($group['id_group']==$_GET["select_group"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$group['id_group'].'" '.$selected.'>'.$group['name'].'</option>';
        }
        $str.='</select>';

        $str .= <<<SELECT
        <select class="form-select" aria-label="Default select example" name="select_student">
            <option selected>Выберите студента</option>
        SELECT;
        foreach($students as $student) {
            if (isset($_GET["select_student"]) and ($student['id_user']==$_GET["select_student"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$student['id_user'].'" '.$selected.'>'.$student['fio'].'</option>';
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
                <th scope="col">Студент</th>
                <th scope="col">Группа</th>
                <th scope="col">Операция</th>
            </tr>
        </thead>
        <tbody>
        END;

        foreach($rows as $row) {
            $mydate = mb_substr($row['dt_mark'],0,10);
            if (isset($_GET["select_group"]) and ($row['id_group']==$_GET["select_group"])) {
                $str .= <<<LINE
                    <tr>
                    <td>{$row['id_mark']}</td>
                    <td>{$row['name']}</td>
                    <td>{$mydate}</td>
                    <td>{$row['value_mark']}</td>
                    <td>{$row['fio']}</td>
                    <td>{$row['name_group']}</td>
                    <td>
                        <form action="/edit_mark" method="POST">
                            <input type="hidden" name="id_mark" value="{$row['id_mark']}">
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                    </td>
                    </tr>
                LINE;
            } else 
                if (isset($_GET["select_student"]) and ($row['id_user']==$_GET["select_student"])) {
                    $str .= <<<LINE
                        <tr>
                    <td>{$row['id_mark']}</td>
                    <td>{$row['name']}</td>
                    <td>{$mydate}</td>
                    <td>{$row['value_mark']}</td>
                    <td>{$row['fio']}</td>
                    <td>{$row['name_group']}</td>
                    <td>
                        <form action="/edit_mark" method="POST">
                            <input type="hidden" name="id_mark" value="{$row['id_mark']}">
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                    </td>                    
                        </tr>
                    LINE;
                } else 
                if (!isset($_GET["select_group"]) and !isset($_GET["select_student"])) {     
                    $str .= <<<LINE
                        <tr>
                    <td>{$row['id_mark']}</td>
                    <td>{$row['name']}</td>
                    <td>{$mydate}</td>
                    <td>{$row['value_mark']}</td>
                    <td>{$row['fio']}</td>
                    <td>{$row['name_group']}</td>
                    <td>
                        <form action="/edit_mark" method="POST">
                            <input type="hidden" name="id_mark" value="{$row['id_mark']}">
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                    </td>                    
                        </tr>
                    LINE;
                }
        }

        $str .= <<<END
                </tbody>
            </table>        

            <form action="/add_mark" method="POST">
                <button type="submit" class="btn btn-primary">Добавить запись</button>
            </form>


            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Журнал оценок', $str);
        return $resultTemplate;
    }

    public function getFormTemplate($row, $groups, $students, $subjects) 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        if ($row) {
            $title = "Изменение оценки";
            $fromUrl = "/edit_mark";
            $btnTitle = "Сохранить";
            $value_dt_mark = mb_substr($row['dt_mark'], 0, 10);
            $mark_value = $row['value_mark'];
        } else {
            $title = "Добавление оценки";
            $fromUrl = "/add_mark";
            $btnTitle = "Добавить";
            $value_dt_mark = date('Y-m-d');
            $mark_value = '';
        }   
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <h3 class="mb-3">{$title}</h3>
            <form method="post" action="{$fromUrl}">
        END;
        if ($row) {
            $str .= '<input type="hidden" name="id_mark" value="'.$row['id_mark'].'">';
            $str .= '<input type="hidden" name="id_teacher" value="'.$row['id_teacher'].'">';
        }
        // Выбор студента
        $str .= <<<SELECT1
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="id_user">
            <option selected>Выберите студента</option>
        SELECT1;
        foreach($students as $student) {
            if (isset($row["id_user"]) and ($student['id_user']==$row["id_user"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$student['id_user'].'" '.$selected.'>'.$student['fio'].'</option>';
        }
        $str.='</select></div>';

        // Выбор группы
        $str .= <<<SELECT
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="id_group">
            <option selected>Выберите группу</option>
        SELECT;
        foreach($groups as $group) {
            if (isset($row["id_group"]) and ($group['id_group']==$row["id_group"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$group['id_group'].'" '.$selected.'>'.$group['name'].'</option>';
        }
        $str.='</select></div>';

        // Выбор дисциплины
        $str .= <<<SELECT
        <div data-mdb-input-init class="form-outline mb-4">
        <select class="form-select" aria-label="Default select example" name="id_course">
            <option selected>Выберите дисциплину</option>
        SELECT;
        foreach($subjects as $subject) {
            if (isset($row["id_course"]) and ($subject['id_course']==$row["id_course"]))
                $selected= "selected";
            else
                $selected= "";
            $str .= '<option value="'.$subject['id_course'].'" '.$selected.'>'.$subject['name'].'</option>';
        }
        $str.='</select></div>';

        $str .= <<<FIELDS
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Дата:</label>
                <input type="text" name="dt_mark" id="form2Example1" 
                    class="form-control" required value="{$value_dt_mark}" />
                <div class="invalid-feedback">Поле обязательно к заполнению</div>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form3Example1">Оценка:</label>
                <input type="text" name="value_mark" id="form3Example1" 
                class="form-control" value="{$mark_value}" />
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