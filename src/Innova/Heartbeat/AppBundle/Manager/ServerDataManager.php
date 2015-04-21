<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\ServerData;
use Mmoreram\GearmanBundle\Service\GearmanClient;

/**
 * Manager for ServerData Entity
 *
 * 
 */
class ServerDataManager
{

    protected $documentManager;
    protected $entityManager;
    protected $gearman;

    public function __construct(DocumentManager $documentManager, EntityManager $entityManager, GearmanClient $gearman) {
        $this->documentManager = $documentManager;
        $this->entityManager = $entityManager;
        $this->mongoDataRepo = $this->documentManager->getRepository('InnovaHeartbeatAppBundle:ServerData');
        $this->dataRepo = $this->entityManager->getRepository('InnovaHeartbeatAppBundle:Server');
        $this->gearman = $gearman;
    }

    /**
     * get server connection
     */
    public function getConnections() { 
        $servers = $this->dataRepo->findAll();
        
        foreach ($servers as $server) {
            $this->gearman->doBackgroundJob(
                'InnovaHeartbeatAppBundleWorkersSshWorker~getData', 
                json_encode(
                    array(
                        'serverUid' => $server->getUid()
                    )
                )
            );
        }

    }
/*
    public function getConnection($server, $user, $pass){
        $connection = @ssh2_connect($server->getIp(), 22, array('hostkey' => 'ssh-rsa'));
        
        
        $server->setStatus(FALSE);
        
        if ($connection && ssh2_auth_pubkey_file($connection, $user, '/home/heartbeat/.ssh/id_rsa.pub', '/home/heartbeat/.ssh/id_rsa', '')) {
            $server->setStatus(TRUE);
        }

        $this->entityManager->persist($server);
        $this->entityManager->flush();

        return $connection;
    }
*/
    public function findByServerId($id){
        $result = $this->getRepository()->findBy(array('serverId' => $id), array('date' => 'desc'), 1, 0);
        if(isset($result[0])) {
            return  $result[0];
        }

        return null;
    }

    public function getRepository() {
        return $this->documentManager->getRepository('InnovaHeartbeatAppBundle:ServerData');
    }

    public function save(ServerData $serverData) {
        $this->documentManager->persist($serverData);
        $this->documentManager->flush();
    }

    public function delete(ServerData $serverData) {
        $this->documentManager->remove($serverData);
        $this->documentManager->flush();
    }
}
