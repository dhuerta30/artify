<?php

namespace App\Services;

use DotenvVault\DotenvVault;
use PDO;

class CrudService
{
    private $pdo;

    public function __construct()
    {
        $dotenv = DotenvVault::createImmutable(dirname(__DIR__, 3));
        $dotenv->safeLoad();

        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        $this->pdo = new PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
    }

    public function createCrud(
        $tableName, 
        $idTable = null, 
        $crudType, 
        $query = null, 
        $controllerName, 
        $nameview, 
        $template_html, 
        $active_filter, 
        $mostrar_campos_filtro,
        $clone_row, 
        $active_popup, 
        $active_search, 
        $activate_deleteMultipleBtn, 
        $button_add, 
        $actions_buttons_grid, 
        $modify_query = null, 
        $activate_nested_table, 
        $buttons_actions, 
        $refrescar_grilla, 
        $encryption, 
        $mostrar_campos_busqueda, 
        $mostrar_columnas_grilla, 
        $mostrar_campos_formulario, 
        $activar_recaptcha,
        $sitekey_recaptcha, 
        $sitesecret_repatcha,
        $function_filter_and_search,
        $activar_union_interna,
        $mostrar_campos_formulario_editar,
        $posicion_botones_accion_grilla,
        $mostrar_columna_acciones_grilla,
        $campos_requeridos,
        $mostrar_paginacion
        )
    {
        if($crudType == 'SQL'){
            $this->generateCrudControllerSQL(
                $tableName,
                $idTable,
                $query,
                $controllerName,
                $nameview,
                $template_html,
                $active_filter,
                $mostrar_campos_filtro,
                $clone_row,
                $active_popup,
                $active_search, 
                $activate_deleteMultipleBtn,
                $button_add,
                $actions_buttons_grid,
                $activate_nested_table,
                $buttons_actions,
                $refrescar_grilla,
                $encryption,
                $mostrar_campos_busqueda,
                $mostrar_campos_formulario,
                $activar_recaptcha,
                $sitekey_recaptcha,
                $sitesecret_repatcha,
                $function_filter_and_search,
                $mostrar_campos_formulario_editar,
                $posicion_botones_accion_grilla,
                $mostrar_columna_acciones_grilla,
                $campos_requeridos
            );
        }

        if ($crudType == 'CRUD') {
            $this->generateCrudControllerCRUD(
                $tableName, 
                $idTable, 
                $query, 
                $controllerName, 
                $nameview, 
                $template_html,
                $active_filter, 
                $mostrar_campos_filtro,
                $clone_row,
                $active_popup,
                $active_search, 
                $activate_deleteMultipleBtn,
                $button_add,
                $actions_buttons_grid,
                $activate_nested_table,
                $buttons_actions,
                $refrescar_grilla,
                $encryption,
                $mostrar_campos_busqueda,
                $mostrar_columnas_grilla,
                $mostrar_campos_formulario,
                $activar_recaptcha,
                $sitekey_recaptcha,
                $sitesecret_repatcha,
                $function_filter_and_search,
                $activar_union_interna,
                $mostrar_campos_formulario_editar,
                $posicion_botones_accion_grilla,
                $mostrar_columna_acciones_grilla,
                $campos_requeridos,
                $mostrar_paginacion
            );
            $this->generateView($nameview);
            //$this->generateViewAdd($nameview);
        }

        $this->generateTemplateCrud($nameview);
    }

    private function generateTemplateCrud($nameview)
    {
        $sourceDir = __DIR__ . '/../libs/artify/classes/templates/bootstrap4';
        $destinationDir = __DIR__ . '/../libs/artify/classes/templates/template_' . $nameview;

        if (!file_exists($destinationDir)) {
            $this->copyDirectory($sourceDir, $destinationDir);
        }
    }

    private function copyDirectory($source, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true); // Crear la carpeta de destino
        }

        $dir = opendir($source);

        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $source . DIRECTORY_SEPARATOR . $file;
                $destPath = $destination . DIRECTORY_SEPARATOR . $file;

                if (is_dir($sourcePath)) {
                    $this->copyDirectory($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }

        closedir($dir);
    }

    /*private function createTable($tableName, $columns)
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} ({$columns})";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception("Error al crear la tabla: {$e->getMessage()}");
        }
    }*/

    /*private function modifyTable($tableName, $modify_query)
    {
        $sql = "ALTER TABLE {$tableName} {$modify_query}";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception("Error al modificar la tabla: {$e->getMessage()}");
        }
    }*/

    private function generateCrudControllerSQL($tableName, $idTable = null, $query = null, $controllerName, $nameview, $template_html, $active_filter, $clone_row, $active_popup, $active_search, $activate_deleteMultipleBtn, $button_add, $actions_buttons_grid, $activate_nested_table, $buttons_actions, $refrescar_grilla, $encryption, $mostrar_campos_busqueda)
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\Request;
        use App\core\View;
        use App\core\Redirect;

        class {$controllerName}Controller
        {
            public \$token;

            public function __construct()
            {
                SessionManager::startSession();
                \$Sesusuario = SessionManager::get('usuario');
                if (!isset(\$Sesusuario)) {
                    Redirect::to('login/index');
                }
                \$this->token = Token::generateFormToken('send_message');
            }

            public function index()
            {
                \$artify = DB::ArtifyCrud();
                \$queryfy = \$artify->getQueryfyObj();
                \$columnDB = \$queryfy->columnNames('{$tableName}');
                \$id = strtoupper(\$columnDB[0]);

                \$html_template = '<div class=\"form\">
                <h5>Agregar Módulo</h5>
                <hr>';

                foreach (\$columns as \$column) {
                    \$columnName = ucfirst(str_replace('_', ' ', \$column)); // Opcional: transformar el nombre de la columna
                    \$html_template .= '
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <div class=\"form-group\">
                                <label class=\"form-label\">' . \$columnName . ':</label>
                                {' . \$column . '}
                                <p class=\"artify_help_block help-block form-text with-errors\"></p>
                            </div>
                        </div>
                    </div>';
                }

                \$html_template .= '
                </div>'; // Cierre del div de formulario

                \$artify->set_template(\$html_template);
                \$tabla = \$artify->getLangData('{$tableName}');
                \$pk = \$artify->getLangData(\$id);
                \$columnVal = \$artify->getLangData(\$pk);

                \$artify->enqueueBtnTopActions('Report',  \"<i class='fa fa-plus'></i> Agregar\", \$_ENV['BASE_URL'].'{$controllerName}/agregar', array(), 'btn-report');

                \$action = \$_ENV['BASE_URL'].'{$controllerName}/editar/id/{{$idTable}}';
                \$text = '<i class=\"fa fa-edit\"></i>';
                \$attr = array('title'=> 'Editar');
                \$artify->enqueueBtnActions('url', \$action, 'url', \$text, \$pk, \$attr, 'btn-warning', array(array()));
                ";

                if ($active_filter == "Si") {
                    $controllerContent .= "
                        foreach (\$columnDB as \$column) {
                            \$columnName = ucfirst(str_replace('_', ' ', \$column));
                            
                            \$artify->addFilter('filterAdd'.\$column, 'Filtrar por '.\$columnName.' ', '', 'dropdown');
                            \$artify->setFilterSource('filterAdd'.\$column, '{$tableName}', \$column, \$column.' as pl', 'db');
                        }
                        ";
                }
        
                $actions_buttons_grid_array = explode(',', $actions_buttons_grid);
       
                foreach ($actions_buttons_grid_array as $action) {
                    if ($action === 'Imprimir') {
                            $controllerContent .= "
                            \$artify->setSettings('printBtn', true);
                        ";
                    } else if ($action === 'PDF') {
                            $controllerContent .= "
                            \$artify->setSettings('pdfBtn', true);
                        ";
                    } else if ($action === 'CSV') {
                            $controllerContent .= "
                            \$artify->setSettings('csvBtn', true);
                        ";
                    } else if ($action === 'Excel') {
                            $controllerContent .= "
                            \$artify->setSettings('excelBtn', true);
                        ";
                    }
                }


                if($active_popup == 'Si'){
                    $controllerContent .= "
                        \$artify->formDisplayInPopup();
                    ";
                }
        
                if($active_search == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('searchbox', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('searchbox', false);
                    ";
                }
        
                // Continue with the remaining settings
                if ($clone_row == 'Si') {
                $controllerContent .= "
                        \$artify->setSettings('clonebtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('clonebtn', false);
                    ";
                }
        
                if($activate_deleteMultipleBtn == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('checkboxCol', true);
                        \$artify->setSettings('deleteMultipleBtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('checkboxCol', false);
                        \$artify->setSettings('deleteMultipleBtn', false);
                    ";
                }
        
                if($refrescar_grilla == "Si"){
                    $controllerContent .= "
                        \$artify->setSettings('refresh', true);
                    ";
                } else {
                    $controllerContent .= "
                    \$artify->setSettings('refresh', false);
                ";
                }
        
                if($button_add == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('addbtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('addbtn', false);
                    ";
                }

                $controllerContent .= "\$artify->setSettings('encryption', false);
                \$artify->setSettings('pagination', true);
                \$artify->setSettings('recordsPerPageDropdown', true);
                \$artify->setSettings('totalRecordsInfo', true);
                \$artify->setSettings('editbtn', false);
                \$artify->setSettings('delbtn', true);
                \$artify->setSettings('actionbtn', true);
                \$artify->setSettings('numberCol', true);
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->setLangData('no_data', 'Sin Resultados');
            
                \$artify->setLangData('tabla', '{$tableName}')
                    ->setLangData('pk', \$pk)
                    ->setLangData('columnVal', \$columnVal);
                \$artify->tableHeading('{$tableName}');
                \$artify->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                \$artify->addCallback('before_sql_data', 'buscador_tabla', array(\$columnDB));
                \$artify->addCallback('before_delete', 'eliminar_tabla');

                \$artify->setSettings('viewbtn', false);
                \$artify->addCallback('format_sql_col', 'format_sql_col_tabla', array(\$columnDB));
                \$render = \$artify->setQuery('{$query}')->render('SQL');

                View::render(
                    '{$nameview}', 
                    [
                        'render' => \$render
                    ]
                );
            }

            public function agregar(){
                \$artify = DB::ArtifyCrud();
                \$artify->buttonHide('submitBtn');
                \$artify->buttonHide('cancel');
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary artify-form-control artify-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$artify->dbTable('{$tableName}')->render('insertform');
                View::render(
                    'agregar_{$nameview}',
                    [
                        'render' => \$render
                    ]
                );
            }

            public function editar(){
                \$request = new Request();
                \$id = \$request->get('id');

                \$artify = DB::ArtifyCrud();

                \$queryfy = \$artify->getQueryfyObj();
                \$columnDB = \$queryfy->columnNames('{$tableName}');
                \$id_tabla = strtoupper(\$columnDB[0]);

                \$artify->setPK(\$id_tabla);
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->buttonHide('submitBtn');
                \$artify->buttonHide('cancel');
                \$artify->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary artify-form-control artify-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$artify->dbTable('{$tableName}')->render('editform', array('id' => \$id));

                View::render(
                    'editar_{$nameview}',
                    [
                        'render' => \$render
                    ]
                );
            }
        }";
     
        file_put_contents($controllerPath, $controllerContent);
    }

    private function generateCrudControllerCRUD(
        $tableName, 
        $idTable = null, 
        $query = null, 
        $controllerName, 
        $nameview, 
        $template_html, 
        $active_filter, 
        $mostrar_campos_filtro, 
        $clone_row, 
        $active_popup, 
        $active_search, 
        $activate_deleteMultipleBtn, 
        $button_add, 
        $actions_buttons_grid, 
        $activate_nested_table, 
        $buttons_actions, 
        $refrescar_grilla,
        $encryption, 
        $mostrar_campos_busqueda, 
        $mostrar_columnas_grilla, 
        $mostrar_campos_formulario, 
        $activar_recaptcha, 
        $sitekey_recaptcha, 
        $sitesecret_repatcha,
        $function_filter_and_search,
        $activar_union_interna,
        $mostrar_campos_formulario_editar,
        $posicion_botones_accion_grilla,
        $mostrar_columna_acciones_grilla,
        $campos_requeridos,
        $mostrar_paginacion
        )
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;
        use Docufy;

        class {$controllerName}Controller
        {
            public \$token;

            public function __construct()
            {
                SessionManager::startSession();
                \$Sesusuario = SessionManager::get('usuario');
                if (!isset(\$Sesusuario)) {
                    Redirect::to('login/index');
                }
                \$this->token = Token::generateFormToken('send_message');
            }

            public function index()
            {
                \$artify = DB::ArtifyCrud();
                \$queryfy = \$artify->getQueryfyObj();
                \$columnDB = \$queryfy->columnNames('{$tableName}');
                unset(\$columnDB[0]);

                ";

                 if(isset($mostrar_campos_busqueda)){

                    $values = explode(',', $mostrar_campos_busqueda);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });

                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->setSearchCols(array({$valuesString}));
                    ";
                }

                if($activar_recaptcha == "Si"){
                    $controllerContent .= "
                        \$artify->recaptcha(\"{$sitekey_recaptcha}\", \"{$sitesecret_repatcha}\");
                    ";
                }

                if(isset($mostrar_columnas_grilla)){

                    $values = explode(',', $mostrar_columnas_grilla);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->crudTableCol(array({$valuesString}));
                    ";
                }

                if(isset($mostrar_campos_formulario)){

                    $values = explode(',', $mostrar_campos_formulario);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->formFields(array({$valuesString}));
                    ";
                }

                if(isset($mostrar_campos_formulario_editar)){

                    $values = explode(',', $mostrar_campos_formulario_editar);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->editFormFields(array({$valuesString}));
                    ";
                }


                if ($active_filter == "Si") {

                    $values = explode(',', $mostrar_campos_filtro);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $controllerContent .= "
                        foreach (\$values as \$column) {
                            \$columnName = ucfirst(str_replace('_', ' ', \$column));
                            
                            \$artify->addFilter('filterAdd'.\$column, 'Filtrar por '.\$columnName.' ', '', 'dropdown');
                            \$artify->setFilterSource('filterAdd'.\$column, '{$tableName}', \$column, \$column.' as pl', 'db');
                        }
                    ";
                }

        if ($template_html == "Si") {
            $controllerContent .= "
                \$html_template = '<div class=\"form\">
                <h5>Agregar Módulo</h5>
                <hr>
                <div class=\"row\">';

                \$columnSizes = [
                    'col-md-4',
                    'col-md-4',
                    'col-md-4',
                    'col-md-12'
                ];

                \$sizeIndex = 0;

                foreach (\$columnDB as \$column) {
                    \$columnName = ucfirst(str_replace('_', ' ', \$column));
                    
                    \$colClass = \$columnSizes[\$sizeIndex % count(\$columnSizes)];
                    
                    \$html_template .= '
                    <div class=\"' . \$colClass . '\">
                        <div class=\"form-group\">
                            <label class=\"form-label\">' . \$columnName . ':</label>
                            {' . \$column . '}
                            <p class=\"artify_help_block help-block form-text with-errors\"></p>
                        </div>
                    </div>';

                    \$sizeIndex++;
                }

                \$html_template .= '</div></div>';

                \$artify->set_template(\$html_template);
                ";
        }

        if($activate_nested_table == "Si"){
            $controllerContent .= "

            ";
        }

        if($activar_union_interna == "Si"){
            $controllerContent .= "

            ";
        }

        if($posicion_botones_accion_grilla == "Izquierda"){
            $controllerContent .= "
                \$artify->setSettings(\"actionBtnPosition\", \"left\");
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings(\"actionBtnPosition\", \"right\");
            ";
        }

        $buttons_actions_array = explode(',', $buttons_actions);
       
        foreach ($buttons_actions_array as $Btnaction) {
            if ($Btnaction === 'Ver') {
                $controllerContent .= "
                    \$artify->setSettings('viewbtn', true);
                ";
            } else if ($Btnaction === 'Editar') {
                $controllerContent .= "
                    \$artify->setSettings('editbtn', true);
                ";
            } else if ($Btnaction === 'Eliminar') {
                $controllerContent .= "
                    \$artify->setSettings('delbtn', true);
                ";
            } else if ($Btnaction === 'Guardar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtn\");
                ";
            } else if ($Btnaction === 'Guardar y regresar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtnSaveBack\");
                ";
            } else if ($Btnaction === 'Regresar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtnBack\");
                ";
            } else if ($Btnaction === 'Cancelar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"cancel\");
                ";
            } else if ($Btnaction === 'Personalizado PDF') {
                $controllerContent .= "
                    \$action = \$_ENV['BASE_URL'].'{$controllerName}/{$tableName}_pdf/id/{{$idTable}}';
                    \$text = \"<i class='fa fa-file-pdf-o'></i>\";
                    \$attr = array('title'=> 'Ver PDF', 'target'=> '_blank');
                    \$artify->enqueueBtnActions('artify-button-url', \$action, 'url', \$text, '', \$attr);
                ";
            }
        }

        $actions_buttons_grid_array = explode(',', $actions_buttons_grid);
       
        foreach ($actions_buttons_grid_array as $action) {
            if ($action === 'Imprimir') {
                    $controllerContent .= "
                    \$artify->setSettings('printBtn', true);
                ";
            } else if ($action === 'PDF') {
                    $controllerContent .= "
                    \$artify->setSettings('pdfBtn', true);
                ";
            } else if ($action === 'CSV') {
                    $controllerContent .= "
                    \$artify->setSettings('csvBtn', true);
                ";
            } else if ($action === 'Excel') {
                    $controllerContent .= "
                    \$artify->setSettings('excelBtn', true);
                ";
            }
        }
        
        if($active_popup == 'Si'){
            $controllerContent .= "
                \$artify->formDisplayInPopup();
            ";
        }

        if($mostrar_columna_acciones_grilla == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('actionbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('actionbtn', false);
            ";
        }

        if( $function_filter_and_search == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('function_filter_and_search', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('function_filter_and_search', false);
            ";
        }

        if($active_search == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('searchbox', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('searchbox', false);
            ";
        }

        // Continue with the remaining settings
        if ($clone_row == 'Si') {
        $controllerContent .= "
                \$artify->setSettings('clonebtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('clonebtn', false);
            ";
        }

        if($activate_deleteMultipleBtn == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('checkboxCol', true);
                \$artify->setSettings('deleteMultipleBtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('checkboxCol', false);
                \$artify->setSettings('deleteMultipleBtn', false);
            ";
        }

        if($refrescar_grilla == "Si"){
            $controllerContent .= "
                \$artify->setSettings('refresh', true);
            ";
        } else {
            $controllerContent .= "
            \$artify->setSettings('refresh', false);
        ";
        }

        if($button_add == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('addbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('addbtn', false);
            ";
        }

        if($encryption == "Si"){
            $controllerContent .= "
                \$artify->setSettings('encryption', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('encryption', false);
            ";
        }

        if($campos_requeridos == "Si"){
            $controllerContent .= "
                \$artify->setSettings('required', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('required', false);
            ";
        }

        if($mostrar_paginacion == "Si"){
            $controllerContent .= "
                \$artify->setSettings('pagination', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('pagination', false);
            ";
        }

        $controllerContent .= "
            \$artify->setSettings('recordsPerPageDropdown', true);
            \$artify->setSettings('totalRecordsInfo', true);
            \$artify->setSettings('numberCol', true);
            \$artify->setSettings('template', 'template_{$nameview}');
            \$render = \$artify->dbTable('{$tableName}')->render();

            View::render('{$nameview}', ['render' => \$render]);
        }";

        foreach ($buttons_actions_array as $Btnaction) {
            if ($Btnaction === 'Personalizado PDF') {
                $controllerContent .= "
                    public function {$tableName}_pdf(){
                        
                        \$docufy = DB::Docufy();
                        \$docufy->setInvoiceDisplaySettings(\"header\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"to\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"from\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"footer\",  \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"payment\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"message\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"subtotal\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"discount\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"tax\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"shipping\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"grandtotal\", false);
                        echo \$docufy->render();
                    }
                ";
            }
        }

        $controllerContent .= 
        "}";

        // Save the generated controller content to a file
        file_put_contents($controllerPath, $controllerContent);
    }


    private function generateView($nameview)
    {
        $viewPath = __DIR__ . '/../Views/' . $nameview . '.php';

        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="artify-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>
        <script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
        <script>
            $(document).on("artify_after_submission", function(event, obj, data) {
                let json = JSON.parse(data);

                if (json.message) {
                    Swal.fire({
                        icon: "success",
                        text: json["message"],
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".artify-back").click();
                        }
                    });
                }
            });
        </script>';

        file_put_contents($viewPath, $viewContent);
    }

    private function generateViewAdd($nameview)
    {
        $viewPath = __DIR__ . '/../Views/agregar_' . $nameview . '.php';

        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="artify-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>';

        file_put_contents($viewPath, $viewContent);
    }
}
