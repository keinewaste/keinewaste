<?php

namespace KeineWaste\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;

class ImportData extends Command
{
    /** @var EntityManagerInterface $em */
    protected $em;

    protected $fixtures = [];

    function __construct(EntityManagerInterface $em, $fixtures)
    {
        $this->em = $em;
        $this->fixtures = $fixtures;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import-data')
            ->setDescription('Import mock data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();
        foreach ($this->fixtures as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->em, $purger);

        $output->writeln('applying fixtures...');
        $executor->execute($loader->getFixtures());
        $output->writeln('done!');
    }
}