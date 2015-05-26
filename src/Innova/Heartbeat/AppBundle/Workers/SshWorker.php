<?php

namespace Innova\Heartbeat\AppBundle\Workers;

use Mmoreram\GearmanBundle\Driver\Gearman;
use Innova\Heartbeat\AppBundle\Document\Snapshot;
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
            $json = json_decode($jsonResponse);

            echo "Data returned \n";
            echo $jsonResponse;
            echo "\n\n";


            // save data in mongodb
            echo "Building snapshot \n";
            $snapshot = new Snapshot();

            echo "Setting server UID \n";
            $snapshot->setServerId($server->getUid());

            echo "Setting timestamp \n";
            $snapshot->setTimestamp($json->timestamp);

            echo "Setting total disk \n";
            $snapshot->setDiskTotal($json->disk->total);

            echo "Setting used disk \n";
            $snapshot->setDiskUsed($json->disk->used);

            echo "Setting free disk \n";
            $snapshot->setDiskFree($json->disk->free);
            
            echo "Setting CPU count \n";
            $snapshot->setCpuCount($json->cpu->count);

            echo "Setting CPU load min1 \n";
            $snapshot->setCpuLoadMin1($json->cpu->load->min1);

            echo "Setting CPU load min5 \n";
            $snapshot->setCpuLoadMin5($json->cpu->load->min5);

            echo "Setting CPU load min15 \n";
            $snapshot->setCpuLoadMin15($json->cpu->load->min15);

            echo "Setting memory total \n";
            $snapshot->setMemoryTotal($json->memory->total);

            echo "Setting memory used \n";
            $snapshot->setMemoryUsed($json->memory->used);

            echo "Setting memory free \n";
            $snapshot->setMemoryFree($json->memory->free);

            echo "Setting memory buffersCache used \n";
            $snapshot->setMemoryBuffersCacheUsed($json->memory->buffersCache->used);

            echo "Setting memory buffersCache free \n";
            $snapshot->setMemoryBuffersCacheFree($json->memory->buffersCache->free);

            echo "Setting memory swap total \n";
            $snapshot->setMemorySwapTotal($json->memory->swap->total);

            echo "Setting memory swap used \n";
            $snapshot->setMemorySwapUsed($json->memory->swap->used);

            echo "Setting memory swap free \n";
            $snapshot->setMemorySwapFree($json->memory->swap->free);

            //$snapshot->setDetails(json_decode($jsonResponse));

            $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
            
            echo "Saving data to MongoDB \n";
            $documentManager->persist($snapshot);
            $documentManager->flush();

            /*
            $pusher = $this->container->get('lopi_pusher.pusher');

            echo "Triggering push notification \n";

            // Push update
            $pusher->trigger(
                $snapshot->getServerId(),
                'serverUpdate',
                $snapshot->getDetails(),
                null,
                null,
                true
            );
            */

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
