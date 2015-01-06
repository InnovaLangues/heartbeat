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
        $servers = $this->getContainer()->get('innova.server.manager')->getAll();
        $results = array();
        foreach ($servers as $server) {
            // connect to server
            $connection = $this->getContainer()->get('innova.serverdata.manager')->getConnection($server->getIP(), 'heartbeat', '');

            if ($connection != null) {
                // get data
                $stream = ssh2_exec($connection, '/home/heartbeat/HeartbeatClient/client.sh', 0700);
                stream_set_blocking($stream, true);
                $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                $jsonResponse = stream_get_contents($stream_out);
                $result = json_decode($jsonResponse);
                
                $results[$server->getUid()] = $result;

                // save data in mongodb
                $serverData = new ServerData();
                $serverData->setServerId($server->getUid());
                $serverData->setDetails($jsonResponse);
                
               $this->getContainer()->get('innova.serverdata.manager')->save($serverData);
            }
        }
        $output->writeln("Done");
    }
}