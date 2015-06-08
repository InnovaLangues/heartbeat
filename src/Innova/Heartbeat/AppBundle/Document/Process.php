<?php

namespace Innova\Heartbeat\AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Process.
 *
 * @MongoDB\Document
 */
class Process
{
    /**
     * @var string
     *
     *
     * @MongoDB\Id
     */
    private $id;

    /** 
     * @MongoDB\ReferenceOne(targetDocument="Snapshot") 
     */
    private $snapshot;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $user;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $comm;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $pcpu;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $vsz;

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
     * Set snapshot
     *
     * @param Innova\Heartbeat\AppBundle\Document\Snapshot $snapshot
     * @return self
     */
    public function setSnapshot(\Innova\Heartbeat\AppBundle\Document\Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;
        return $this;
    }

    /**
     * Get snapshot
     *
     * @return Innova\Heartbeat\AppBundle\Document\Snapshot $snapshot
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comm
     *
     * @param string $comm
     * @return self
     */
    public function setComm($comm)
    {
        $this->comm = $comm;
        return $this;
    }

    /**
     * Get comm
     *
     * @return string $comm
     */
    public function getComm()
    {
        return $this->comm;
    }

    /**
     * Set pcpu
     *
     * @param string $pcpu
     * @return self
     */
    public function setPcpu($pcpu)
    {
        $this->pcpu = $pcpu;
        return $this;
    }

    /**
     * Get pcpu
     *
     * @return string $pcpu
     */
    public function getPcpu()
    {
        return $this->pcpu;
    }

    /**
     * Set vsz
     *
     * @param string $vsz
     * @return self
     */
    public function setVsz($vsz)
    {
        $this->vsz = $vsz;
        return $this;
    }

    /**
     * Get vsz
     *
     * @return string $vsz
     */
    public function getVsz()
    {
        return $this->vsz;
    }
}
