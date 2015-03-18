<?php

namespace Innova\Heartbeat\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Innova\Heartbeat\AppBundle\Document\ServerData;

class FetchDataCommand extends ContainerAwareCommand 
{

    protected function configure() {
        $this->setName('heartbeat:fetch')
             ->setDescription('Get data from servers');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->getContainer()->get('innova.serverdata.manager')->getConnections();
        $output->writeln("Done");
    }
}