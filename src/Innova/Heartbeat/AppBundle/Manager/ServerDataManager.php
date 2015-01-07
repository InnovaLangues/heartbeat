<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\ServerData;

/**
 * Manager for ServerData Entity
 *
 * 
 */
class ServerDataManager {

    protected $dm;

    public function __construct(DocumentManager $dm) {
        $this->dm = $dm;
    }

    /**
     * get server connection
     */
    public function getConnection($url, $user, $pass) {
        
        try{
            $connection = ssh2_connect($url, 22, array('hostkey' => 'ssh-rsa'));
            if (ssh2_auth_pubkey_file($connection, $user, '/home/heartbeat/.ssh/id_rsa.pub', '/home/heartbeat/.ssh/id_rsa', '')) {                
                return $connection;
            } else {
                return null;
            }
        } catch (Exception $e){
            return null;
        }
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function findOne($id) {
        return $this->getRepository()->find($id);
    }
    
    public function findByServerId($id){
        $result = $this->getRepository()->findBy(array('serverId' => $id), array('date' => 'desc'), 1, 0);
        return  $result[0];
    }

    public function save(ServerData $serverData) {
        $this->dm->persist($serverData);
        $this->dm->flush();
    }

    public function delete(ServerData $serverData) {
        $this->dm->remove($serverData);
        $this->dm->flush();
    }

    public function getRepository() {
        return $this->dm->getRepository('InnovaHeartbeatAppBundle:ServerData');
    }

}
