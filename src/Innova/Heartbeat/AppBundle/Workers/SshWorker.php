<?php

namespace Innova\Heartbeat\AppBundle\Workers;

use Mmoreram\GearmanBundle\Driver\Gearman;
use Innova\Heartbeat\AppBundle\Entity\Snapshot;
use Innova\Heartbeat\AppBundle\Entity\Process;
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

        if ($server) {
            # code...
            echo "Attempting to connect to " . $server->getName() . " \n";

            // connect to server
            $connection = $this->getConnection($serverUid, 'heartbeat');

            if ($connection !== null) {
                echo "Conected"; 
                
                echo "Attempting to execute client.sh \n";
                
                // get data
                $stream = ssh2_exec($connection, '/home/heartbeat/HeartbeatClient/client.sh', 0700);

                if ($stream) {
                    echo "Data stream aquired \n";
                } else {
                    echo "Could not get data stream \n";
                }

                echo "Set stream blocking \n";

                stream_set_blocking($stream, true);

                $streamOut = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

                $response = stream_get_contents($streamOut);

                if ($response) {
                    # code...
                    echo "Data returned : \n";
                    echo $response;
                    echo "\n";
                } else {
                    echo "No data returned \n";
                }

                echo "Attempting to decode json \n";

                $jsonResponse = json_decode($response);

                if ($jsonResponse) {
                    echo "Json decoded \n";
                } else {
                    echo "Json not decoded \n";
                }

                echo "Attempting to save data \n";

                $snapshot = new Snapshot();

                echo "New snapshot object created \n";

                $snapshot->setServer($server);

                echo "Snapshot successfully bound to server \n";

                echo "Attempting to set timestamp \n";                
                if ($jsonResponse->timestamp) {
                    $snapshot->setTimestamp($jsonResponse->timestamp);
                    echo "Timestamp set \n";
                } else {
                    echo "Timestamp could not be set \n";
                }

                echo "Attempting to set CPU count \n";                
                if ($jsonResponse->cpu->count) {
                    $snapshot->setCpuCount($jsonResponse->cpu->count);
                    echo "CPU count set \n";
                } else {
                    echo "CPU count could not be set \n";
                }

                echo "Attempting to set CPU load (1min) \n";                
                if ($jsonResponse->cpu->load->min1) {
                    $snapshot->setCpuLoadMin1($jsonResponse->cpu->load->min1);
                    echo "CPU load set (1min) \n";
                } else {
                    echo "CPU load could not be set (1min) \n";
                }

                echo "Attempting to set CPU load (5min) \n";                
                if ($jsonResponse->cpu->load->min1) {
                    $snapshot->setCpuLoadMin1($jsonResponse->cpu->load->min5);
                    echo "CPU load set (5min) \n";
                } else {
                    echo "CPU load could not be set (5min) \n";
                }

                echo "Attempting to set CPU load (15min) \n";                
                if ($jsonResponse->cpu->load->min1) {
                    $snapshot->setCpuLoadMin1($jsonResponse->cpu->load->min15);
                    echo "CPU load set (15min) \n";
                } else {
                    echo "CPU load could not be set (15min) \n";
                }

                echo "Attempting to set Total Memory \n";                
                if ($jsonResponse->memory->total) {
                    $snapshot->setMemoryTotal($jsonResponse->memory->total);
                    echo "Total Memory set\n";
                } else {
                    echo "Total Memory could not be set \n";
                }

                echo "Attempting to set Used Memory \n";                
                if ($jsonResponse->memory->used) {
                    $snapshot->setMemoryUsed($jsonResponse->memory->used);
                    echo "Used Memory set\n";
                } else {
                    echo "Used Memory could not be set \n";
                }

                echo "Attempting to set Free Memory \n";                
                if ($jsonResponse->memory->free) {
                    $snapshot->setMemoryFree($jsonResponse->memory->free);
                    echo "Free Memory set\n";
                } else {
                    echo "Free Memory could not be set \n";
                }

                echo "Attempting to set Used Buffers Cache Memory \n";                
                if ($jsonResponse->memory->buffersCache->used) {
                    $snapshot->setMemoryBuffersCacheUsed($jsonResponse->memory->buffersCache->used);
                    echo "Used Buffers Cache Memory set\n";
                } else {
                    echo "Used Buffers Cache Memory could not be set \n";
                }

                echo "Attempting to set Free Buffers Cache Memory \n";                
                if ($jsonResponse->memory->buffersCache->free) {
                    $snapshot->setMemoryBuffersCacheFree($jsonResponse->memory->buffersCache->free);
                    echo "Free Buffers Cache Memory set\n";
                } else {
                    echo "Free Buffers Cache Memory could not be set \n";
                }

                echo "Attempting to set Total Swap Memory \n";                
                if ($jsonResponse->memory->swap->total) {
                    $snapshot->setMemorySwapTotal($jsonResponse->memory->swap->total);
                    echo "Total Swap Memory set\n";
                } else {
                    echo "Total Swap Memory could not be set \n";
                }

                echo "Attempting to set Used Swap Memory \n";                
                if ($jsonResponse->memory->swap->used) {
                    $snapshot->setMemorySwapUsed($jsonResponse->memory->swap->used);
                    echo "Used Swap Memory set\n";
                } else {
                    echo "Used Swap Memory could not be set \n";
                }

                echo "Attempting to set Free Swap Memory \n";                
                if ($jsonResponse->memory->swap->free) {
                    $snapshot->setMemorySwapFree($jsonResponse->memory->swap->free);
                    echo "Free Swap Memory set\n";
                } else {
                    echo "Free Swap Memory could not be set \n";
                }

                echo "Attempting to set Total Disk \n";                
                if ($jsonResponse->disk->total) {
                    $snapshot->setDiskTotal($jsonResponse->disk->total);
                    echo "Total Disk set\n";
                } else {
                    echo "Total Disk could not be set \n";
                }

                echo "Attempting to set Used Disk \n";                
                if ($jsonResponse->disk->used) {
                    $snapshot->setDiskUsed($jsonResponse->disk->used);
                    echo "Used Disk set\n";
                } else {
                    echo "Used Disk could not be set \n";
                }

                echo "Attempting to set Free Disk \n";                
                if ($jsonResponse->disk->free) {
                    $snapshot->setDiskFree($jsonResponse->disk->free);
                    echo "Free Disk set\n";
                } else {
                    echo "Free Disk could not be set \n";
                }

                echo "Creating entity manager \n";

                $entityManager = $this->container->get('doctrine.orm.entity_manager');
                
                echo "Persisting snapshot \n";

                $entityManager->persist($snapshot);

                echo "Checking for processes \n";

                if ($jsonResponse->processes) {
                    echo "Processes found, iterating \n";
                    foreach ($jsonResponse->processes as $proc) {
                        echo "Creating new process object \n";
                        $process = new Process();
                        echo "Testing if snapshot exists \n";
                        if ($snapshot) {
                            echo "Linking to snapshot \n";
                            $process->setSnapshot($snapshot);
                        }
                        else {
                            echo "No snapshot found \n";
                        }

                        if (isset($proc->user)) {
                            $process->setUser($proc->user);
                            echo "Process user set \n";
                        } else {
                            echo "Process user not set \n";
                        }

                        if (isset($proc->command)) {
                            $process->setCommand($proc->command);
                            echo "Process command set \n";
                        } else {
                            echo "Process command not set \n";
                        }

                        if (isset($proc->percent_cpu)) {
                            $process->setPercentCpu($proc->percent_cpu);
                            echo "Process percent CPU set \n";
                        } else {
                            echo "Process percent CPU not set \n";
                        }

                        if (isset($proc->memory_used)) {
                            $process->setMemoryUsed($proc->memory_used);
                            echo "Process memory used set \n";
                        } else {
                            echo "Process memory used not set \n";
                        }

                        echo "Persisting process \n";
                        $entityManager->persist($process);
                    }
                } else {
                    echo "Processes not found \n";
                }

                echo "Flushing objects \n";
                $entityManager->flush();

                echo "Attempting to instanciate pusher \n";
                $pusher = $this->container->get('lopi_pusher.pusher');

                echo "Triggering push notification \n";

                if ($pusher) {
                    // Push update
                    $pusher->trigger(
                        $snapshot->getServer()->getUid(),
                        'serverUpdate',
                        $jsonResponse,
                        null,
                        null,
                        true
                    );
                    echo "Push notification triggered \n";
                } else {
                    echo "Push notification failed \n";
                }

                echo "Exiting \n \n";
            }
        } else {
            echo "Server not found \n \n";
        }
    }

    public function getConnection($serverUid, $user)
    {
        $server = $this->getServer($serverUid);

        echo "Attempting connection to IP " . $server->getIp() . "\n";

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
