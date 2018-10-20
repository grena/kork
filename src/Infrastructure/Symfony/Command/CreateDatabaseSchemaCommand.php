<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Infrastructure\Persistence\Sql\Installation\SchemaCreator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Adrien Pétremann <hello@grena.fr>
 */
class CreateDatabaseSchemaCommand extends Command
{
    public const CREATE_SCHEMA_COMMAND_NAME = 'kork:schema:create';

    /** @var SchemaCreator */
    private $schemaCreator;

    public function __construct(SchemaCreator $schemaCreator)
    {
        $this->schemaCreator = $schemaCreator;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::CREATE_SCHEMA_COMMAND_NAME)
            ->addOption(
                'force',
                true,
                InputOption::VALUE_NONE,
                'Drop current schema before creating it.'
            )
            ->setDescription('Create database schema.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $force = $input->getOption('force');

        if ($force) {
            $this->schemaCreator->drop();
        }

        $this->schemaCreator->create();

        $output->writeln('<info>Database schema created!</info>');
    }
}
