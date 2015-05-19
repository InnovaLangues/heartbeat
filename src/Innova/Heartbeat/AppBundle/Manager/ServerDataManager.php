<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\ServerData;
use Mmoreram\GearmanBundle\Service\GearmanClient;

/**
 * Manager for ServerData Entity.
 */
class ServerDataManager
{
    protected $documentManager;
    protected $entityManager;
    protected $gearman;

    public function __construct(DocumentManager $documentManager, EntityManager $entityManager, GearmanClient $gearman)
    {
        $this->documentManager = $documentManager;
        $this->entityManager = $entityManager;
        $this->mongoDataRepo = $this->documentManager->getRepository('InnovaHeartbeatAppBundle:ServerData');
        $this->dataRepo = $this->entityManager->getRepository('InnovaHeartbeatAppBundle:Server');
        $this->gearman = $gearman;
    }

    /**
     * get server connection.
     */
    public function getConnections()
    {
        $servers = $this->dataRepo->findAll();

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

    public function findByServerId($id, $limit = 1)
    {
        return $this->getRepository()->findBy(array('serverId' => $id), array('timestamp' => 'desc'), $limit, 0);
    }

    public function getRepository()
    {
        return $this->documentManager->getRepository('InnovaHeartbeatAppBundle:ServerData');
    }

    public function save(ServerData $serverData)
    {
        $this->documentManager->persist($serverData);
        $this->documentManager->flush();
    }

    public function delete(ServerData $serverData)
    {
        $this->documentManager->remove($serverData);
        $this->documentManager->flush();
    }
}
