<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Innova\Heartbeat\AppBundle\Entity\Snapshot;
use Mmoreram\GearmanBundle\Service\GearmanClient;

/**
 * Manager for Snapshot Entity.
 */
class SnapshotManager
{
    protected $entityManager;
    protected $gearman;

    public function __construct(EntityManager $entityManager, GearmanClient $gearman)
    {
        $this->entityManager = $entityManager;
        $this->gearman = $gearman;
    }

    /**
     * get server connection.
     */
    public function getConnections()
    {
        $servers = $this->entityManager->getRepository('InnovaHeartbeatAppBundle:Server')->findAll();

        foreach ($servers as $server) {
            $this->gearman->doBackgroundJob(
                'InnovaHeartbeatAppBundleWorkersSshWorker~hasData',
                json_encode(
                    array(
                        'serverUid' => $server->getUid(),
                    )
                )
            );
        }
    }
}
