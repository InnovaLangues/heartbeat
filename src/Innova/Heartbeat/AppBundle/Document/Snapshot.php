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
     * @var string
     *
     * @MongoDB\Int
     */
    private $diskTotal;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $diskUsed;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $diskFree;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $cpuCount;

    /**
     * @var string
     *
     * @MongoDB\Float
     */
    private $cpuLoadMin1;

    /**
     * @var string
     *
     * @MongoDB\Float
     */
    private $cpuLoadMin5;

    /**
     * @var string
     *
     * @MongoDB\Float
     */
    private $cpuLoadMin15;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memoryTotal;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memoryUsed;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memoryFree;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memoryBuffersCacheUsed;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memoryBuffersCacheFree;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memorySwapTotal;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memorySwapUsed;

    /**
     * @var string
     *
     * @MongoDB\Int
     */
    private $memorySwapFree;

    /** 
     * @MongoDB\ReferenceMany(targetDocument="Process") 
     */
    private $processes;

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

    /**
     * Set diskTotal
     *
     * @param int $diskTotal
     * @return self
     */
    public function setDiskTotal($diskTotal)
    {
        $this->diskTotal = $diskTotal;
        return $this;
    }

    /**
     * Get diskTotal
     *
     * @return int $diskTotal
     */
    public function getDiskTotal()
    {
        return $this->diskTotal;
    }

    /**
     * Set diskUsed
     *
     * @param int $diskUsed
     * @return self
     */
    public function setDiskUsed($diskUsed)
    {
        $this->diskUsed = $diskUsed;
        return $this;
    }

    /**
     * Get diskUsed
     *
     * @return int $diskUsed
     */
    public function getDiskUsed()
    {
        return $this->diskUsed;
    }

    /**
     * Set diskFree
     *
     * @param int $diskFree
     * @return self
     */
    public function setDiskFree($diskFree)
    {
        $this->diskFree = $diskFree;
        return $this;
    }

    /**
     * Get diskFree
     *
     * @return int $diskFree
     */
    public function getDiskFree()
    {
        return $this->diskFree;
    }

    /**
     * Set cpuCount
     *
     * @param int $cpuCount
     * @return self
     */
    public function setCpuCount($cpuCount)
    {
        $this->cpuCount = $cpuCount;
        return $this;
    }

    /**
     * Get cpuCount
     *
     * @return int $cpuCount
     */
    public function getCpuCount()
    {
        return $this->cpuCount;
    }

    /**
     * Set cpuLoadMin1
     *
     * @param float $cpuLoadMin1
     * @return self
     */
    public function setCpuLoadMin1($cpuLoadMin1)
    {
        $this->cpuLoadMin1 = $cpuLoadMin1;
        return $this;
    }

    /**
     * Get cpuLoadMin1
     *
     * @return float $cpuLoadMin1
     */
    public function getCpuLoadMin1()
    {
        return $this->cpuLoadMin1;
    }

    /**
     * Set cpuLoadMin5
     *
     * @param float $cpuLoadMin5
     * @return self
     */
    public function setCpuLoadMin5($cpuLoadMin5)
    {
        $this->cpuLoadMin5 = $cpuLoadMin5;
        return $this;
    }

    /**
     * Get cpuLoadMin5
     *
     * @return float $cpuLoadMin5
     */
    public function getCpuLoadMin5()
    {
        return $this->cpuLoadMin5;
    }

    /**
     * Set cpuLoadMin15
     *
     * @param float $cpuLoadMin15
     * @return self
     */
    public function setCpuLoadMin15($cpuLoadMin15)
    {
        $this->cpuLoadMin15 = $cpuLoadMin15;
        return $this;
    }

    /**
     * Get cpuLoadMin15
     *
     * @return float $cpuLoadMin15
     */
    public function getCpuLoadMin15()
    {
        return $this->cpuLoadMin15;
    }

    /**
     * Set memoryTotal
     *
     * @param int $memoryTotal
     * @return self
     */
    public function setMemoryTotal($memoryTotal)
    {
        $this->memoryTotal = $memoryTotal;
        return $this;
    }

    /**
     * Get memoryTotal
     *
     * @return int $memoryTotal
     */
    public function getMemoryTotal()
    {
        return $this->memoryTotal;
    }

    /**
     * Set memoryUsed
     *
     * @param int $memoryUsed
     * @return self
     */
    public function setMemoryUsed($memoryUsed)
    {
        $this->memoryUsed = $memoryUsed;
        return $this;
    }

    /**
     * Get memoryUsed
     *
     * @return int $memoryUsed
     */
    public function getMemoryUsed()
    {
        return $this->memoryUsed;
    }

    /**
     * Set memoryFree
     *
     * @param int $memoryFree
     * @return self
     */
    public function setMemoryFree($memoryFree)
    {
        $this->memoryFree = $memoryFree;
        return $this;
    }

    /**
     * Get memoryFree
     *
     * @return int $memoryFree
     */
    public function getMemoryFree()
    {
        return $this->memoryFree;
    }

    /**
     * Set memoryBuffersCacheUsed
     *
     * @param int $memoryBuffersCacheUsed
     * @return self
     */
    public function setMemoryBuffersCacheUsed($memoryBuffersCacheUsed)
    {
        $this->memoryBuffersCacheUsed = $memoryBuffersCacheUsed;
        return $this;
    }

    /**
     * Get memoryBuffersCacheUsed
     *
     * @return int $memoryBuffersCacheUsed
     */
    public function getMemoryBuffersCacheUsed()
    {
        return $this->memoryBuffersCacheUsed;
    }

    /**
     * Set memoryBuffersCacheFree
     *
     * @param int $memoryBuffersCacheFree
     * @return self
     */
    public function setMemoryBuffersCacheFree($memoryBuffersCacheFree)
    {
        $this->memoryBuffersCacheFree = $memoryBuffersCacheFree;
        return $this;
    }

    /**
     * Get memoryBuffersCacheFree
     *
     * @return int $memoryBuffersCacheFree
     */
    public function getMemoryBuffersCacheFree()
    {
        return $this->memoryBuffersCacheFree;
    }

    /**
     * Set memorySwapTotal
     *
     * @param int $memorySwapTotal
     * @return self
     */
    public function setMemorySwapTotal($memorySwapTotal)
    {
        $this->memorySwapTotal = $memorySwapTotal;
        return $this;
    }

    /**
     * Get memorySwapTotal
     *
     * @return int $memorySwapTotal
     */
    public function getMemorySwapTotal()
    {
        return $this->memorySwapTotal;
    }

    /**
     * Set memorySwapUsed
     *
     * @param int $memorySwapUsed
     * @return self
     */
    public function setMemorySwapUsed($memorySwapUsed)
    {
        $this->memorySwapUsed = $memorySwapUsed;
        return $this;
    }

    /**
     * Get memorySwapUsed
     *
     * @return int $memorySwapUsed
     */
    public function getMemorySwapUsed()
    {
        return $this->memorySwapUsed;
    }

    /**
     * Set memorySwapFree
     *
     * @param int $memorySwapFree
     * @return self
     */
    public function setMemorySwapFree($memorySwapFree)
    {
        $this->memorySwapFree = $memorySwapFree;
        return $this;
    }

    /**
     * Get memorySwapFree
     *
     * @return int $memorySwapFree
     */
    public function getMemorySwapFree()
    {
        return $this->memorySwapFree;
    }
    public function __construct()
    {
        $this->processes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add process
     *
     * @param Innova\Heartbeat\AppBundle\Document\Process $process
     */
    public function addProcess(\Innova\Heartbeat\AppBundle\Document\Process $process)
    {
        $this->processes[] = $process;
    }

    /**
     * Remove process
     *
     * @param Innova\Heartbeat\AppBundle\Document\Process $process
     */
    public function removeProcess(\Innova\Heartbeat\AppBundle\Document\Process $process)
    {
        $this->processes->removeElement($process);
    }

    /**
     * Get processes
     *
     * @return \Doctrine\Common\Collections\Collection $processes
     */
    public function getProcesses()
    {
        return $this->processes;
    }
}
