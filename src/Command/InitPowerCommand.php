<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Power;

class InitPowerCommand extends Command
{
    protected static $defaultName = 'app:init-power';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Inits powers value');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $powers = [];
        $powers[0] = new Power("blast");
        $powers[1] = new Power("plague");
        $powers[2] = new Power("mind control");
        $powers[3] = new Power("ink fog");
        $powers[4] = new Power("force shield");
        $powers[5] = new Power("regeneration");

        foreach ($powers as $power) {
            $this->entityManager->persist($power);
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
