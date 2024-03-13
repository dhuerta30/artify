<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DotenvVault\DotenvVault;

class DropTableCommand extends Command
{
    protected function configure()
    {
        $this->setName('drop:table')
             ->setDescription('Eliminar una tabla de la base de datos. Ejemplo de uso ( php artify drop:table nombre_tabla )')
             ->addArgument('table', InputArgument::REQUIRED, 'Nombre de la tabla a eliminar');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Cargar variables de entorno desde el archivo .env
        $dotenv = DotenvVault::createImmutable(dirname(__DIR__, 3));
        $dotenv->safeLoad();

        $tableName = $input->getArgument('table');

        // Obtener variables de entorno
        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        // Lógica para generar la sentencia SQL de creación de la tabla
        $sql = "DROP TABLE IF EXISTS {$tableName}";

        // Ejecutar la sentencia SQL utilizando PDO
        try {
            $pdo = new \PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
            $pdo->exec($sql);

            $this->showSuccessMessage($output, "Tabla {$tableName} Eliminada con éxito");
            return Command::SUCCESS;  // Devuelve el código de éxito
        } catch (\PDOException $e) {
            $output->writeln("<error>Error al Eliminar la tabla: {$e->getMessage()}</error>");
            return Command::FAILURE;  // Devuelve el código de error
        }
    }

    private function showSuccessMessage(OutputInterface $output, $message)
    {
        $output->writeln("<info>{$message}</info>");
    }
}