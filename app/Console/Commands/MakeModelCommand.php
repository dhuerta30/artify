<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:model')
             ->setDescription('Crear un nuevo Modelo. ( php artify make:model NombreModelo )')
             ->addArgument('name', InputArgument::REQUIRED, 'Name of the model');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        // Ruta completa para el nuevo modelo
        $modelPath = __DIR__ . '/../../Models/' . $name . 'Model.php';

        // Lógica para generar el contenido del modelo
        $modelContent = "<?php

        namespace App\Models;

        use App\core\DB;
        
        class " . $name . "Model
        {
            private \$table;

            public function __construct()
            {
                \$this->table = '';
            }

            public function mi_metodo(\$data = array())
            {
                \$queryfy = DB::Queryfy();
                \$queryfy->insert(\$this->table, \$data);
                return \$queryfy;
            }

        }";

        // Guarda el contenido en el archivo
        $resultModel = file_put_contents($modelPath, $modelContent);

        if ($resultModel !== false) {
            $this->showSuccessMessage($output, "Model creado con éxito");
            return Command::SUCCESS;  // Devuelve el código de éxito
        } else {
            $errorMessage = error_get_last();
            $output->writeln("<error>Error Error al crear el modelo: {$errorMessage['message']}</error>");
            return Command::FAILURE;  // Devuelve el código de error
        }
    }
}
