<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    // Puedes agregar métodos comunes aquí

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Este método se puede utilizar para ejecutar acciones comunes
        // antes o después de la ejecución de un comando específico.
    }

    protected function getConfig($key)
    {
        // Lógica para obtener configuración común
    }

    protected function showSuccessMessage(OutputInterface $output, $message)
    {
        $output->writeln("<info>$message</info>");
    }
}