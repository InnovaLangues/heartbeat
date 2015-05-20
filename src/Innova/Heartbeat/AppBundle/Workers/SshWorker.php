<?php

namespace Innova\Heartbeat\AppBundle\Workers;

use Mmoreram\GearmanBundle\Driver\Gearman;
use Innova\Heartbeat\AppBundle\Entity\Snapshot;
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
            $response = stream_get_contents($streamOut);

            echo "Data returned \n";
            echo $response;
            $jsonResponse = json_decode($response);
            echo "\n";

            echo "Saving data \n";

            $snapshot = new snapshot();
            $snapshot->setServer($server);
            $snapshot->setTimestamp($jsonResponse->timestamp);
            $snapshot->setCpuCount($jsonResponse->cpu->count);
            $snapshot->setCpuLoadMin1($jsonResponse->cpu->load->min1);
            $snapshot->setCpuLoadMin5($jsonResponse->cpu->load->min5);
            $snapshot->setCpuLoadMin15($jsonResponse->cpu->load->min15);
            $snapshot->setMemoryTotal($jsonResponse->memory->total);
            $snapshot->setMemoryUsed($jsonResponse->memory->used);
            $snapshot->setMemoryFree($jsonResponse->memory->free);
            $snapshot->setMemoryBuffersCacheUsed($jsonResponse->memory->buffersCache->used);
            $snapshot->setMemoryBuffersCacheFree($jsonResponse->memory->buffersCache->free);
            $snapshot->setMemorySwapTotal($jsonResponse->memory->swap->total);
            $snapshot->setMemorySwapUsed($jsonResponse->memory->swap->used);
            $snapshot->setMemorySwapFree($jsonResponse->memory->swap->free);
            $snapshot->setDiskTotal($jsonResponse->disk->total);
            $snapshot->setDiskUsed($jsonResponse->disk->used);
            $snapshot->setDiskFree($jsonResponse->disk->free);

            $entityManager = $this->container->get('doctrine.orm.entity_manager');
            $entityManager->persist($snapshot);
            $entityManager->flush();



            $pusher = $this->container->get('lopi_pusher.pusher');

            echo "Triggering push notification \n";

            // Push update
            $pusher->trigger(
                $snapshot->getServer()->getUid(),
                'serverUpdate',
                $jsonResponse,
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
