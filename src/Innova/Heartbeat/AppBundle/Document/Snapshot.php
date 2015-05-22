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
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set serverId
     *
     * @param string $serverId
     * @return self
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;
        return $this;
    }

    /**
     * Get serverId
     *
     * @return string $serverId
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set timestamp
     *
     * @param string $timestamp
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return string $timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
