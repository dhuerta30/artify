<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MakeViewCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:view')
             ->setDescription('Crear una nueva vista. Ejemplo de uso ( php artify make:view nombre_vista )')
             ->addArgument('name', InputArgument::REQUIRED, 'Name of the view');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        // Ruta completa para la nueva vista
        $viewPath = __DIR__ . '/../../Views/' . $name . '.php';

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

        if ($resultModel !== false) {
            $this->showSuccessMessage($output, "Vista creada con éxito");
            return Command::SUCCESS;  // Devuelve el código de éxito
        } else {
            $errorMessage = error_get_last();
            $output->writeln("<error>Error Error al crear la vista: {$errorMessage['message']}</error>");
            return Command::FAILURE;  // Devuelve el código de error
        }
    }
}
