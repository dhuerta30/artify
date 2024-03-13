<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DotenvVault\DotenvVault;

class CreateTableCommand extends Command
{
    protected function configure()
    {
        $this->setName('create:table')
             ->setDescription('Crear una nueva tabla en la base de datos. Ejemplo de uso ( php artify create:table nombre_tabla "columna1 INT, columna2 VARCHAR(255), columna3 DATE" )')
             ->addArgument('table', InputArgument::REQUIRED, 'Nombre de la tabla')
             ->addArgument('columns', InputArgument::REQUIRED, 'Columnas de la tabla (separadas por comas)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Cargar variables de entorno desde el archivo .env
        $dotenv = DotenvVault::createImmutable(dirname(__DIR__, 3));
        $dotenv->safeLoad();

        $tableName = $input->getArgument('table');
        $columns = $input->getArgument('columns');

        // Obtener variables de entorno
        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        // Lógica para generar la sentencia SQL de creación de la tabla
        $sql = "CREATE TABLE {$tableName} ({$columns})";

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

    private function showSuccessMessage(OutputInterface $output, $message)
    {
        $output->writeln("<info>{$message}</info>");
    }
}
