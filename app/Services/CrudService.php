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

    public function createCrud($tableName, $crudType, $query = null, $controllerName, $columns, $nameview)
    {
        $this->createTable($tableName, $columns);
        $this->generateCrudController($tableName, $crudType, $query, $controllerName, $nameview, $crudType);
        $this->generateView($nameview);
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

    private function generateCrudController($tableName, $crudType, $query = null, $controllerName, $nameview)
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';

        if($crudType == 'SQL'){
            $crudType = 'SQL';

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
                    \$id = strtoupper(\$columnDB[0]);

                    \$tabla = \$pdocrud->getLangData('{$tableName}');
                    \$pk = \$pdocrud->getLangData(\$id);
                    \$columnVal = \$pdocrud->getLangData(\$id);

                    \$pdocrud->setSettings('encryption', false);
                    \$pdocrud->setLangData('no_data', 'Sin Resultados');
                
                    \$pdocrud->setLangData('tabla', '{$tableName}')
                        ->setLangData('pk', \$pk)
                        ->setLangData('columnVal', \$columnVal);
                    \$pdocrud->tableHeading('{$tableName}');
                    \$pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');

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
}
