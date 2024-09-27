<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MakeControllerCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:controller')
             ->setDescription('Crear un nuevo controlador. Ejemplo de uso ( php artify make:controller NombreControlador )')
             ->addArgument('name', InputArgument::REQUIRED, 'Name of the controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $controllerName = $input->getArgument('name');

        // Ruta completa para el nuevo controlador
        $controllerPath = __DIR__ . '/../../Controllers/' . $controllerName . 'Controller.php';

        // Lógica para generar el contenido del controlador
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\Request;
        use App\core\View;
        use App\core\Redirect;
        use App\core\DB;
        
        class " . $controllerName . "Controller
        {
            public function index()
            {
                // Implementa la lógica del controlador aquí
                View::render('nombre_vista');
            }
        }";

        // Guarda el contenido en el archivo
        $result = file_put_contents($controllerPath, $controllerContent);

        if ($result !== false) {
            $this->showSuccessMessage($output, "Controlador creado con éxito");
            return Command::SUCCESS;  // Devuelve el código de éxito
        } else {
            $errorMessage = error_get_last();
            $output->writeln("<error>Error al crear el Controlador: {$errorMessage['message']}</error>");
            return Command::FAILURE;  // Devuelve el código de error
        }
    }
}
