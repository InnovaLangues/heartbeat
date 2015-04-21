<?php

namespace Innova\Heartbeat\AppBundle\Workers;

use Mmoreram\GearmanBundle\Driver\Gearman;
use Doctrine\ORM\EntityManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\ServerData;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @Gearman\Work(
 *     description = "SSH Worker"
 * )
 */
class SshWorker extends ContainerAware
{
    /**
     * Test method to run as a job
     *
     * @param \GearmanJob $job Object with job parameters
     *
     * @return boolean
     *
     * @Gearman\Job(
     *     name = "getData",
     *     description = "Gets Data from the client server"
     * )
     */
    public function getData(\GearmanJob $job)
    {
        $data = json_decode($job->workload(), true);
        print_r($data);

        $serverUid = $data['serverUid'];

        $server = $this->getServer($serverUid);

        // connect to server
        $connection = $this->getConnection($serverUid, 'heartbeat', '');

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

            echo $jsonResponse;

            $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
            $documentManager->persist($serverData);
            $documentManager->flush();
        }
    }

    public function getConnection($serverUid, $user, $pass){

        $server = $this->getServer($serverUid);
        
        $connection = @ssh2_connect($server->getIp(), 22, array('hostkey' => 'ssh-rsa'));

        $server->setStatus(FALSE);
        
        if ($connection && ssh2_auth_pubkey_file($connection, $user, '/home/heartbeat/.ssh/id_rsa.pub', '/home/heartbeat/.ssh/id_rsa', '')) {
            $server->setStatus(TRUE);
        }

        $this->container->get('doctrine.orm.entity_manager')->persist($server);
        $this->container->get('doctrine.orm.entity_manager')->flush();

        return $connection;
    }

    public function getServer($serverUid) {
        $server = $this->container->get('doctrine.orm.entity_manager')->getRepository('InnovaHeartbeatAppBundle:Server')->findOneByUid($serverUid);

        return $server;
    }

}