<?php

namespace Innova\Heartbeat\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('heartbeat:fetch')
             ->setDescription('Get data from servers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting script');
        $this->getContainer()->get('innova.snapshot.manager')->getConnections();
        $output->writeln('Done');
    }
}
