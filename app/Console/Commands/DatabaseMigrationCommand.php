<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Schema\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;

class DatabaseMigrationCommand extends Command
{
    private $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this->setName('database:migrate')
            ->setDescription('Ejecutar migraciones de bases de datos Ejemplo de uso ( php artify database:migrate )');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Obtener el gestor de esquemas
        $schemaManager = $this->connection->createSchemaManager();

        // Lógica de migración aquí
        $this->createUsersTable($schemaManager, $output);

        $output->writeln('Migraciones completadas.');
        return Command::SUCCESS;
    }

    private function createUsersTable($schemaManager, $output)
    {
        $tableName = 'users';

        try {
            // Obtener la lista de tablas
            $tables = $schemaManager->listTableNames();

            // Lógica de migración aquí
            if (!in_array($tableName, $tables)) {
                $output->writeln("Creando la tabla $tableName");

                $table = new Table($tableName); 
                $table->addColumn('id', 'integer', ['autoincrement' => true]);
                $table->addColumn('name', 'string', ['length' => 255]);
                $table->addColumn('email', 'string', ['length' => 255]);
                $table->setPrimaryKey(['id']);
                $table->addUniqueIndex(['email']);

                // Aplicar la tabla a la base de datos
                $schemaManager->createTable($table);
            } else {
                $output->writeln("La tabla $tableName ya existe.");
            }
        } catch (SchemaException $e) {
            $output->writeln("Error al acceder al esquema: " . $e->getMessage());
        }
    }
}
