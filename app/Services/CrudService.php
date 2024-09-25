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

    public function createCrud($tableName, $idTable = null, $crudType, $query = null, $controllerName, $columns = null, $nameview, $template_html, $active_filter, $clone_row, $active_popup, $active_search, $activate_deleteMultipleBtn, $button_add, $actions_buttons_grid, $modify_query = null, $activate_nested_table, $buttons_actions)
    {
        $this->createTable($tableName, $columns);
        $this->modifyTable($tableName, $modify_query);

        /*if ($crudType == 'SQL') {
            if ($template_html == 'No' && $active_filter == 'No' && $clone_row == 'No') {
                $this->generateCrudControllerSQL($tableName, $idTable, $query, $controllerName, $nameview);
            } elseif ($template_html == 'Si' && $active_filter == 'Si' && $clone_row == 'Si') {
                $this->generateCrudControllerSQLTemplateFields($tableName, $idTable, $query, $controllerName, $nameview, $template_html, $active_filter, $clone_row);
            }
        }*/

        if ($crudType == 'CRUD') {
            $this->generateCrudControllerCRUD(
                $tableName, 
                $idTable, 
                $query, 
                $controllerName, 
                $nameview, 
                $template_html, 
                $active_filter, 
                $clone_row, 
                $active_popup, 
                $active_search, 
                $activate_deleteMultipleBtn, 
                $button_add, 
                $actions_buttons_grid,
                $activate_nested_table,
                $buttons_actions
            );
            $this->generateView($nameview);
            //$this->generateViewAdd($nameview);
        }

        $this->generateTemplateCrud($nameview);
    }


    private function generateTemplateCrud($nameview)
    {
        $sourceDir = __DIR__ . '/../libs/script/classes/templates/bootstrap4';
        $destinationDir = __DIR__ . '/../libs/script/classes/templates/template_' . $nameview;

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

    private function createTable($tableName, $columns)
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} ({$columns})";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception("Error al crear la tabla: {$e->getMessage()}");
        }
    }

    private function modifyTable($tableName, $modify_query)
    {
        $sql = "ALTER TABLE {$tableName} {$modify_query}";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception("Error al modificar la tabla: {$e->getMessage()}");
        }
    }

    private function generateCrudControllerSQL($tableName, $idTable, $query = null, $controllerName, $nameview)
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
                \$pdocrud = DB::PDOCrud();

                \$pdomodel = \$pdocrud->getPDOModelObj();
                \$columnDB = \$pdomodel->columnNames('{$tableName}');
                \$id = strtoupper(\$columnDB[0]);

                \$tabla = \$pdocrud->getLangData('{$tableName}');
                \$pk = \$pdocrud->getLangData(\$id);
                \$columnVal = \$pdocrud->getLangData(\$pk);

                \$pdocrud->enqueueBtnTopActions('Report',  \"<i class='fa fa-plus'></i> Agregar\", \$_ENV['BASE_URL'].'{$controllerName}/agregar', array(), 'btn-report');

                \$action = \$_ENV['BASE_URL'].'{$controllerName}/editar/id/{{$idTable}}';
                \$text = '<i class=\"fa fa-edit\"></i>';
                \$attr = array('title'=> 'Editar');
                \$pdocrud->enqueueBtnActions('url', \$action, 'url', \$text, \$pk, \$attr, 'btn-warning', array(array()));

                \$pdocrud->setSettings('encryption', false);
                \$pdocrud->setSettings('pagination', true);
                \$pdocrud->setSettings('searchbox', true);
                \$pdocrud->setSettings('deleteMultipleBtn', true);
                \$pdocrud->setSettings('checkboxCol', true);
                \$pdocrud->setSettings('recordsPerPageDropdown', true);
                \$pdocrud->setSettings('totalRecordsInfo', true);
                \$pdocrud->setSettings('addbtn', false);
                \$pdocrud->setSettings('editbtn', false);
                \$pdocrud->setSettings('delbtn', true);
                \$pdocrud->setSettings('actionbtn', true);
                \$pdocrud->setSettings('refresh', false);
                \$pdocrud->setSettings('numberCol', true);
                \$pdocrud->setSettings('printBtn', true);
                \$pdocrud->setSettings('pdfBtn', true);
                \$pdocrud->setSettings('csvBtn', true);
                \$pdocrud->setSettings('excelBtn', true);
                \$pdocrud->setSettings('clonebtn', false);
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->setLangData('no_data', 'Sin Resultados');
            
                \$pdocrud->setLangData('tabla', '{$tableName}')
                    ->setLangData('pk', \$pk)
                    ->setLangData('columnVal', \$columnVal);
                \$pdocrud->tableHeading('{$tableName}');
                \$pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                \$pdocrud->addCallback('before_sql_data', 'buscador_tabla', array(\$columnDB));
                \$pdocrud->addCallback('before_delete', 'eliminar_tabla');

                \$pdocrud->setSettings('viewbtn', false);
                \$pdocrud->addCallback('format_sql_col', 'format_sql_col_tabla', array(\$columnDB));
                \$render = \$pdocrud->setQuery('{$query}')->render('SQL');

                View::render(
                    '{$nameview}', 
                    [
                        'render' => \$render
                    ]
                );
            }

            public function agregar(){
                \$pdocrud = DB::PDOCrud();
                \$pdocrud->buttonHide('submitBtn');
                \$pdocrud->buttonHide('cancel');
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$pdocrud->dbTable('{$tableName}')->render('insertform');
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

                \$pdocrud = DB::PDOCrud();

                \$pdomodel = \$pdocrud->getPDOModelObj();
                \$columnDB = \$pdomodel->columnNames('{$tableName}');
                \$id_tabla = strtoupper(\$columnDB[0]);

                \$pdocrud->setPK(\$id_tabla);
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->buttonHide('submitBtn');
                \$pdocrud->buttonHide('cancel');
                \$pdocrud->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$pdocrud->dbTable('{$tableName}')->render('editform', array('id' => \$id));

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

    private function generateCrudControllerSQLTemplateFields($tableName, $idTable, $query = null, $controllerName, $nameview, $template_html, $active_filter = "Si", $clone_row = "Si")
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
                \$pdocrud = DB::PDOCrud();
                \$pdomodel = \$pdocrud->getPDOModelObj();
                \$columnDB = \$pdomodel->columnNames('{$tableName}');
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
                                <p class=\"pdocrud_help_block help-block form-text with-errors\"></p>
                            </div>
                        </div>
                    </div>';
                }

                \$html_template .= '
                </div>'; // Cierre del div de formulario

                \$pdocrud->set_template(\$html_template);
                \$tabla = \$pdocrud->getLangData('{$tableName}');
                \$pk = \$pdocrud->getLangData(\$id);
                \$columnVal = \$pdocrud->getLangData(\$pk);

                \$pdocrud->enqueueBtnTopActions('Report',  \"<i class='fa fa-plus'></i> Agregar\", \$_ENV['BASE_URL'].'{$controllerName}/agregar', array(), 'btn-report');

                \$action = \$_ENV['BASE_URL'].'{$controllerName}/editar/id/{{$idTable}}';
                \$text = '<i class=\"fa fa-edit\"></i>';
                \$attr = array('title'=> 'Editar');
                \$pdocrud->enqueueBtnActions('url', \$action, 'url', \$text, \$pk, \$attr, 'btn-warning', array(array()));

                \$pdocrud->setSettings('encryption', false);
                \$pdocrud->setSettings('pagination', true);
                \$pdocrud->setSettings('searchbox', true);
                \$pdocrud->setSettings('clonebtn', true);
                \$pdocrud->setSettings('deleteMultipleBtn', true);
                \$pdocrud->setSettings('checkboxCol', true);
                \$pdocrud->setSettings('recordsPerPageDropdown', true);
                \$pdocrud->setSettings('totalRecordsInfo', true);
                \$pdocrud->setSettings('addbtn', false);
                \$pdocrud->setSettings('editbtn', false);
                \$pdocrud->setSettings('delbtn', true);
                \$pdocrud->setSettings('actionbtn', true);
                \$pdocrud->setSettings('refresh', false);
                \$pdocrud->setSettings('numberCol', true);
                \$pdocrud->setSettings('printBtn', true);
                \$pdocrud->setSettings('pdfBtn', true);
                \$pdocrud->setSettings('csvBtn', true);
                \$pdocrud->setSettings('excelBtn', true);
                \$pdocrud->setSettings('clonebtn', false);
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->setLangData('no_data', 'Sin Resultados');
            
                \$pdocrud->setLangData('tabla', '{$tableName}')
                    ->setLangData('pk', \$pk)
                    ->setLangData('columnVal', \$columnVal);
                \$pdocrud->tableHeading('{$tableName}');
                \$pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                \$pdocrud->addCallback('before_sql_data', 'buscador_tabla', array(\$columnDB));
                \$pdocrud->addCallback('before_delete', 'eliminar_tabla');

                \$pdocrud->setSettings('viewbtn', false);
                \$pdocrud->addCallback('format_sql_col', 'format_sql_col_tabla', array(\$columnDB));
                \$render = \$pdocrud->setQuery('{$query}')->render('SQL');

                View::render(
                    '{$nameview}', 
                    [
                        'render' => \$render
                    ]
                );
            }

            public function agregar(){
                \$pdocrud = DB::PDOCrud();
                \$pdocrud->buttonHide('submitBtn');
                \$pdocrud->buttonHide('cancel');
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$pdocrud->dbTable('{$tableName}')->render('insertform');
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

                \$pdocrud = DB::PDOCrud();

                \$pdomodel = \$pdocrud->getPDOModelObj();
                \$columnDB = \$pdomodel->columnNames('{$tableName}');
                \$id_tabla = strtoupper(\$columnDB[0]);

                \$pdocrud->setPK(\$id_tabla);
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$pdocrud->buttonHide('submitBtn');
                \$pdocrud->buttonHide('cancel');
                \$pdocrud->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$pdocrud->dbTable('{$tableName}')->render('editform', array('id' => \$id));

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

    private function generateCrudControllerCRUD($tableName, $idTable = null, $query = null, $controllerName, $nameview, $template_html, $active_filter, $clone_row, $active_popup, $active_search, $activate_deleteMultipleBtn, $button_add, $actions_buttons_grid, $activate_nested_table, $buttons_actions)
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
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
                \$pdocrud = DB::PDOCrud();
                \$pdomodel = \$pdocrud->getPDOModelObj();
                \$columnDB = \$pdomodel->columnNames('{$tableName}');
                unset(\$columnDB[0]);

                ";

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
                            <p class=\"pdocrud_help_block help-block form-text with-errors\"></p>
                        </div>
                    </div>';

                    \$sizeIndex++;
                }

                \$html_template .= '</div></div>';

                \$pdocrud->set_template(\$html_template);
                ";
        }

        // Check if active_filter is "Si"
        if ($active_filter == "Si") {
            $controllerContent .= "
                foreach (\$columnDB as \$column) {
                    \$columnName = ucfirst(str_replace('_', ' ', \$column));
                    
                    \$pdocrud->addFilter('filterAdd'.\$column, 'Filtrar por '.\$columnName.' ', '', 'dropdown');
                    \$pdocrud->setFilterSource('filterAdd'.\$column, '{$tableName}', \$column, \$column.' as pl', 'db');
                }
                ";
        }

        if($activate_nested_table == "Si"){
            $controllerContent .= "

            ";
        }

        $buttons_actions_array = explode(',', $buttons_actions);
       
        foreach ($buttons_actions_array as $Btnaction) {
            if ($Btnaction === 'Ver') {
                $controllerContent .= "
                    \$pdocrud->setSettings('viewbtn', false);
                ";
            } else if ($Btnaction === 'Editar') {
                $controllerContent .= "
                    \$pdocrud->setSettings('editbtn', true);
                ";
            } else if ($Btnaction === 'Eliminar') {
                $controllerContent .= "
                    \$pdocrud->setSettings('delbtn', true);
                ";
            } else if ($Btnaction === 'Personalizado') {
                $controllerContent .= "
            
                ";
            }
        }


        $actions_buttons_grid_array = explode(',', $actions_buttons_grid);
       
        foreach ($actions_buttons_grid_array as $action) {
            if ($action === 'Imprimir') {
                    $controllerContent .= "
                    \$pdocrud->setSettings('printBtn', true);
                ";
            } else if ($action === 'PDF') {
                    $controllerContent .= "
                    \$pdocrud->setSettings('pdfBtn', true);
                ";
            } else if ($action === 'CSV') {
                    $controllerContent .= "
                    \$pdocrud->setSettings('csvBtn', true);
                ";
            } else if ($action === 'Excel') {
                    $controllerContent .= "
                    \$pdocrud->setSettings('excelBtn', true);
                ";
            }
        }
    
        
        if($active_popup == 'Si'){
            $controllerContent .= "
                \$pdocrud->formDisplayInPopup();
            ";
        }

        if($active_search == 'Si'){
            $controllerContent .= "
                \$pdocrud->setSettings('searchbox', true);
            ";
        } else {
            $controllerContent .= "
                \$pdocrud->setSettings('searchbox', false);
            ";
        }

        // Continue with the remaining settings
        if ($clone_row == 'Si') {
        $controllerContent .= "
                \$pdocrud->setSettings('clonebtn', true);
            ";
        } else {
            $controllerContent .= "
                \$pdocrud->setSettings('clonebtn', false);
            ";
        }

        if($activate_deleteMultipleBtn == 'Si'){
            $controllerContent .= "
                \$pdocrud->setSettings('checkboxCol', true);
                \$pdocrud->setSettings('deleteMultipleBtn', true);
            ";
        } else {
            $controllerContent .= "
                \$pdocrud->setSettings('checkboxCol', false);
                \$pdocrud->setSettings('deleteMultipleBtn', false);
            ";
        }

        if($button_add == 'Si'){
            $controllerContent .= "
                \$pdocrud->setSettings('addbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$pdocrud->setSettings('addbtn', false);
            ";
        }

        $controllerContent .= "
                \$pdocrud->setSettings('encryption', true);
                \$pdocrud->setSettings('pagination', true);
                \$pdocrud->setSettings('function_filter_and_search', true);
                \$pdocrud->setSettings('recordsPerPageDropdown', true);
                \$pdocrud->setSettings('totalRecordsInfo', true);
                \$pdocrud->setSettings('actionbtn', true);
                \$pdocrud->setSettings('refresh', false);
                \$pdocrud->setSettings('numberCol', true);
                \$pdocrud->buttonHide('submitBtnSaveBack');
                \$pdocrud->setSettings('template', 'template_{$nameview}');
                \$render = \$pdocrud->dbTable('{$tableName}')->render();

                View::render(
                    '{$nameview}', ['render' => \$render]
                    );
                }
            }";

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

                        <div class="row procedimiento">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="pdocrud-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>
        <script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
        <script>
            $(document).on("pdocrud_after_submission", function(event, obj, data) {
                let json = JSON.parse(data);

                if (json.message) {
                    Swal.fire({
                        icon: "success",
                        text: json["message"],
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".pdocrud-back").click();
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

                        <div class="row procedimiento">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="pdocrud-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>';

        file_put_contents($viewPath, $viewContent);
    }
}
