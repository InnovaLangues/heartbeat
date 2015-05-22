<?php

namespace Innova\Heartbeat\AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Snapshot.
 *
 * @MongoDB\Document
 */
class Snapshot
{
    /**
     * @var string
     *
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $serverId;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $timestamp;

    /**
     * @var date
     * @MongoDB\Date
     */
    private $date;

    public function __construct()
    {
        $date = new \DateTime();
        $this->setDate($date);
    }
}
