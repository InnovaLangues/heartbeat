<?php

namespace Innova\Heartbeat\AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Innova\Heartbeat\AppBundle\Document\Process;

/**
 * Manager for Process Entity.
 */
class ProcessManager
{
    protected $documentManager;

    public function getRepository()
    {
        return $this->documentManager->getRepository('InnovaHeartbeatAppBundle:Process');
    }
}
