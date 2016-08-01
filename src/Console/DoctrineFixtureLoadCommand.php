<?php
declare(strict_types = 1);

namespace App\Console;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DoctrineFixtureLoadCommand
 * @package App\Console
 */
class DoctrineFixtureLoadCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $defaultPath = __DIR__ . '/../Fixtures';

    /**
     * DoctrineFixtureLoadCommand constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('fixtures:load')
            ->setDescription('Load data fixtures into database')
            ->addArgument('path', InputArgument::OPTIONAL, 'Path to data fixtures directory')
            ->setHelp('%command.full_name% <your-path-to-data-fixtures>');

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->defaultPath;
        if ($input->hasArgument('path')) {
            $path = $input->getArgument('path');
        }

        $loader = new Loader();
        $loader->loadFromDirectory($path);

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());

        $output->writeln('Fixture has been loaded into database');
    }
}
