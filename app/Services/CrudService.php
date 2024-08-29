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

        // Obtener variables de entorno
        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        // Configurar PDO
        $this->pdo = new PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
    }

    public function createCrud($tableName, $idTable, $crudType, $query = null, $controllerName, $columns, $nameview)
    {
        $this->createTable($tableName, $columns);
        $this->generateCrudController($tableName, $idTable, $crudType, $query, $controllerName, $nameview, $crudType);
        $this->generateView($nameview);
        $this->generateViewEdit($nameview);
        $this->generateViewAdd($nameview);
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

    private function generateCrudController($tableName, $idTable, $crudType, $query = null, $controllerName, $nameview)
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';

        if($crudType == 'SQL'){
            $crudType = 'SQL';

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
                    \$pdocrud->setSettings('addbtn', false);
                    \$pdocrud->setSettings('editbtn', false);
                    \$pdocrud->setSettings('refresh', false);
                    \$pdocrud->setSettings('numberCol', true);
                    \$pdocrud->setSettings('printBtn', true);
                    \$pdocrud->setSettings('pdfBtn', true);
                    \$pdocrud->setSettings('csvBtn', true);
                    \$pdocrud->setSettings('excelBtn', true);
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
                    \$pdocrud->formStaticFields('botones', 'html', '
                        <div class=\"col-md-12 text-center\">
                            <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                            <a href=\"'.\$_ENV['BASE_URL'].'Demo/index\" class=\"btn btn-danger\">Regresar</a>
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
                    \$pdocrud->buttonHide('submitBtn');
                    \$pdocrud->buttonHide('cancel');
                    \$pdocrud->formStaticFields('botones', 'html', '
                        <div class=\"col-md-12 text-center\">
                            <input type=\"submit\" class=\"btn btn-primary pdocrud-form-control pdocrud-submit\" data-action=\"insert\" value=\"Guardar\"> 
                            <a href=\"'.\$_ENV['BASE_URL'].'Demo/index\" class=\"btn btn-danger\">Regresar</a>
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
        } else {
            $crudType = 'CRUD';

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
                    \$render = \$pdocrud->dbTable('{$tableName}')->render();

                    View::render(
                        '{$nameview}', 
                        [
                            'render' => \$render
                        ]
                    );
                }
            }";
        }

        file_put_contents($controllerPath, $controllerContent);
    }

    private function generateView($nameview)
    {
        $viewPath = __DIR__ . '/../Views/' . $nameview . '.php';

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

    private function generateViewEdit($nameview)
    {
        $viewPath = __DIR__ . '/../Views/editar_' . $nameview . '.php';

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
