<?php

namespace Innova\Heartbeat\AppBundle\Workers;

use Mmoreram\GearmanBundle\Driver\Gearman;
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
     * Test method to run as a job.
     *
     * @param \GearmanJob $job Object with job parameters
     *
     * @return bool
     *
     * @Gearman\Job(
     *     name = "hasData",
     *     description = "Gets Data from the client server"
     * )
     */
    public function hasData(\GearmanJob $job)
    {
        echo "Entering job \n";
        $data = json_decode($job->workload(), true);
        $serverUid = $data['serverUid'];
        $server = $this->getServer($serverUid);

        // connect to server
        $connection = $this->getConnection($serverUid, 'heartbeat');

        if ($connection !== null) {
            echo "Executing client.sh \n";
            
            // get data
            $stream = ssh2_exec($connection, '/home/heartbeat/HeartbeatClient/client.sh', 0700);

            echo "Set stream blocking \n";

            stream_set_blocking($stream, true);
            $streamOut = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $jsonResponse = stream_get_contents($streamOut);

            echo "Data returned \n";
            echo $jsonResponse;
            echo "\n";

            echo "Saving data to MongoDB \n";

            // save data in mongodb
            $serverData = new ServerData();
            $serverData->setServerId($server->getUid());
            $serverData->setDetails($jsonResponse);

            $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
            $documentManager->persist($serverData);
            $documentManager->flush();

            $pusher = $this->container->get('lopi_pusher.pusher');

            echo "Triggering push notification \n";

            // Push update
            $pusher->trigger(
                $serverData->getServerId(),
                'serverUpdate',
                $serverData->getDetails(),
                null,
                null,
                true
            );

            echo "Exiting \n \n";
        }
    }

    public function getConnection($serverUid, $user)
    {
        $server = $this->getServer($serverUid);

        echo "Attempting connection to " . $server->getIp() . "\n";

        $connection = ssh2_connect($server->getIp(), 22, array('hostkey' => 'ssh-rsa'));

        $server->setStatus(false);

        if (is_resource($connection)) {
            echo "Connected \n";
            if (ssh2_auth_pubkey_file($connection, $user, '/home/heartbeat/.ssh/id_rsa.pub', '/home/heartbeat/.ssh/id_rsa', '')) {
                echo "Authorized \n";
                $server->setStatus(true);
            }

            echo "Save \n";
            $this->container->get('doctrine.orm.entity_manager')->persist($server);
            $this->container->get('doctrine.orm.entity_manager')->flush();
        }

        return $connection;
    }

    public function getServer($serverUid)
    {
        $server = $this->container->get('doctrine.orm.entity_manager')->getRepository('InnovaHeartbeatAppBundle:Server')->findOneByUid($serverUid);

        return $server;
    }
}
