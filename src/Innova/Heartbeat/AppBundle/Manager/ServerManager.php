<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Innova\Heartbeat\AppBundle\Entity\Server;

/**
 * Manager for Server Entity
 *
 * 
 */
class ServerManager {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function findOne($id) {
        return $this->getRepository()->find($id);
    }
    
    public function save(Server $server){
        $this->em->persist($server);
        $this->em->flush();
    }

    public function delete(Server $server) {
        $this->em->remove($server);
        $this->em->flush();
    }

    public function getRepository() {
        return $this->em->getRepository('InnovaHeartbeatAppBundle:Server');
    }

}
