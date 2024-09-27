<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DotenvVault\DotenvVault;

class CreateTemplatesCrudCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:templatecrud')
             ->setDescription('Crear una nueva plantilla para usar en PDOCrud con nombre personalizado. Ejemplo de uso ( php artify make:templatecrud nombre_template )')
             ->addArgument('name', InputArgument::REQUIRED, 'Name of the view');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $sourceDir = __DIR__ . '/../../libs/artify/classes/templates/solicitudes'; // Ruta de la carpeta base de plantillas
        $destinationDir = __DIR__ . '/../../libs/artify/classes/templates/' . $name; // Nueva carpeta de destino

        if (!file_exists($destinationDir)) {
            $this->copyDirectory($sourceDir, $destinationDir, $output);
            $this->showSuccessMessage($output, "Template '{$name}' creado con éxito.");
            return Command::SUCCESS;
        } else {
            $output->writeln("<error>La carpeta '{$name}' ya existe.</error>");
            return Command::FAILURE;
        }
    }

    private function copyDirectory($source, $destination, OutputInterface $output)
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
                    $this->copyDirectory($sourcePath, $destPath, $output);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }

        closedir($dir);
    }

    private function showSuccessMessage(OutputInterface $output, $message)
    {
        $output->writeln("<info>{$message}</info>");
    }
}
