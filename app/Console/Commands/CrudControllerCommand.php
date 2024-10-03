<?php

namespace App\Console\Commands;

use App\core\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DotenvVault\DotenvVault;

class CrudControllerCommand extends Command
{
    protected function configure()
    {
        $this->setName('create:crud')
             ->setDescription('Crear una nueva tabla y generar un controlador CRUD asociado. Ejemplo de uso ( php artify create:crud nombre_tabla "columna1 INT, columna2 VARCHAR(255), columna3 DATE" nombre_vista )')
             ->addArgument('table', InputArgument::REQUIRED, 'Nombre de la tabla')
             ->addArgument('columns', InputArgument::REQUIRED, 'Columnas de la tabla (separadas por comas)')
             ->addArgument('name', InputArgument::REQUIRED, 'Nombre de la vista');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Obtener argumentos
        $tableName = $input->getArgument('table');
        $columns = $input->getArgument('columns');
        $nameview = $input->getArgument('name');
        $controllerName = $tableName . 'Controller';

        // Crear tabla en la base de datos
        $this->createTable($tableName, $columns, $output);

        // Generar controlador CRUD
        $this->generateCrudController($controllerName, $tableName, $nameview, $output);

        $output->writeln('<info>Tabla, controlador y vista CRUD generados con éxito.</info>');

        return Command::SUCCESS;
    }

    private function generateView($nameview)
    {
        $viewPath = __DIR__ . '/../../Views/' . $nameview . '.php';

        // Lógica para generar el contenido de la vista
        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h5>titulo</h5>
                                <hr>
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

        // Guarda el contenido en el archivo
        $resultModel = file_put_contents($viewPath, $viewContent);
    }

    private function createTable($tableName, $columns, $output)
    {
        $dotenv = DotenvVault::createImmutable(dirname(__DIR__, 3));
        $dotenv->safeLoad();

        // Obtener variables de entorno
        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        // Lógica para generar la sentencia SQL de creación de la tabla
        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} ({$columns})";

        // Ejecutar la sentencia SQL utilizando PDO
        try {
            $pdo = new \PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
            $pdo->exec($sql);

            $this->showSuccessMessage($output, "Tabla {$tableName} creada con éxito");
            return Command::SUCCESS;  // Devuelve el código de éxito
        } catch (\PDOException $e) {
            $output->writeln("<error>Error al crear la tabla: {$e->getMessage()}</error>");
            return Command::FAILURE;  // Devuelve el código de error
        }
    }

    private function generateCrudController($controllerName, $tableName, $nameview, $output)
    {
        // Ruta completa para el nuevo controlador
        $controllerPath = __DIR__ . '/../../Controllers/' . $controllerName . '.php';

        // Lógica para generar el contenido del controlador
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\Request;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;

        class {$controllerName}
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
                \$render = \$artify->dbTable('{$tableName}')->render();

                View::render(
                    '{$nameview}', 
                    [
                        'render' => \$render
                    ]
                );
            }
        }";

        // Guarda el contenido en el archivo
        $result = file_put_contents($controllerPath, $controllerContent);

        if ($result !== false) {
            $output->writeln("<info>Controlador {$controllerName} creado con éxito.</info>");
            // Generar la vista
            $this->generateView($nameview);
        } else {
            $output->writeln("<error>Error al crear el Controlador {$controllerName}.</error>");
            exit(Command::FAILURE);
        }
    }

    private function showSuccessMessage(OutputInterface $output, $message)
    {
        $output->writeln("<info>{$message}</info>");
    }
}
