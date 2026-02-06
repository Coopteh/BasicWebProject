<?php
namespace App\Views;

use App\Views\BaseTemplate;

class SubjectsTemplate extends BaseTemplate {

    public function getSubjectsTemplate($rows): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-8 offset-md-2">
            
            <h1>Дисциплины</h1>            
        END;

        $str .= <<<END
        <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Наименование</th>
          </tr>
        </thead>
        <tbody>
        END;

        foreach($rows as $row)
            $str .= <<<LINE
                <tr>
                <td>{$row['idsubject']}</td>
                <td>{$row['name']}</td>
                </tr>
            LINE;

        $str .= <<<END
                </tbody>
            </table>        
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Дисциплины', $str);
        return $resultTemplate;
    }

}