<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\ServerData;

/**
 * Manager for ServerData Entity
 *
 * 
 */
class ServerDataManager {

    protected $documentManager;
    protected $entityManager;

    public function __construct(DocumentManager $documentManager, EntityManager $entityManager) {
        $this->documentManager = $documentManager;
        $this->entityManager = $entityManager;
        $this->mongoDataRepo = $this->documentManager->getRepository('InnovaHeartbeatAppBundle:ServerData');
        $this->dataRepo = $this->entityManager->getRepository('InnovaHeartbeatAppBundle:Server');
    }

    /**
     * get server connection
     */
    public function getConnections() {   
        $servers = $this->dataRepo->findAll();
        $results = array();
        
        foreach ($servers as $server) {
            // connect to server
            $connection = $this->getConnection($server, 'heartbeat', '');

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
                
               $this->save($serverData);
            }
        }

    }

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
