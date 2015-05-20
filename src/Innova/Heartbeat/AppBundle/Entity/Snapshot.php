<?php

namespace Innova\Heartbeat\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Snapshot
 *
 * @ORM\Table("snapshot")
 * @ORM\Entity
 */
class Snapshot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Server", inversedBy="snapshots")
     * @ORM\JoinColumn(name="server_uid", referencedColumnName="uid")
     **/
    private $server;

    /**
     * @ORM\OneToMany(targetEntity="Process", mappedBy="snapshot")
     **/
    private $processes;

    /**
     * @var string
     *
     * @ORM\Column(name="timestamp", type="string", length=255)
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="cpuCount", type="string", nullable=true, length=255)
     */
    private $cpuCount;

    /**
     * @var string
     *
     * @ORM\Column(name="cpuLoadMin1", type="string", nullable=true, length=255)
     */
    private $cpuLoadMin1;

    /**
     * @var string
     *
     * @ORM\Column(name="cpuLoadMin5", type="string", nullable=true, length=255)
     */
    private $cpuLoadMin5;

    /**
     * @var string
     *
     * @ORM\Column(name="cpuLoadMin15", type="string", nullable=true, length=255)
     */
    private $cpuLoadMin15;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryTotal", type="string", nullable=true, length=255)
     */
    private $memoryTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryUsed", type="string", nullable=true, length=255)
     */
    private $memoryUsed;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryFree", type="string", nullable=true, length=255)
     */
    private $memoryFree;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryBuffersCacheUsed", type="string", nullable=true, length=255)
     */
    private $memoryBuffersCacheUsed;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryBuffersCacheFree", type="string", nullable=true, length=255)
     */
    private $memoryBuffersCacheFree;

    /**
     * @var string
     *
     * @ORM\Column(name="memorySwapTotal", type="string", nullable=true, length=255)
     */
    private $memorySwapTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="memorySwapUsed", type="string", nullable=true, length=255)
     */
    private $memorySwapUsed;

    /**
     * @var string
     *
     * @ORM\Column(name="memorySwapFree", type="string", nullable=true, length=255)
     */
    private $memorySwapFree;

    /**
     * @var string
     *
     * @ORM\Column(name="diskTotal", type="string", nullable=true, length=255)
     */
    private $diskTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="diskUsed", type="string", nullable=true, length=255)
     */
    private $diskUsed;

    /**
     * @var string
     *
     * @ORM\Column(name="diskFree", type="string", nullable=true, length=255)
     */
    private $diskFree;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timestamp
     *
     * @param string $timestamp
     * @return Snapshot
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return string 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set cpuCount
     *
     * @param string $cpuCount
     * @return Snapshot
     */
    public function setCpuCount($cpuCount)
    {
        $this->cpuCount = $cpuCount;

        return $this;
    }

    /**
     * Get cpuCount
     *
     * @return string 
     */
    public function getCpuCount()
    {
        return $this->cpuCount;
    }

    /**
     * Set cpuLoadMin1
     *
     * @param string $cpuLoadMin1
     * @return Snapshot
     */
    public function setCpuLoadMin1($cpuLoadMin1)
    {
        $this->cpuLoadMin1 = $cpuLoadMin1;

        return $this;
    }

    /**
     * Get cpuLoadMin1
     *
     * @return string 
     */
    public function getCpuLoadMin1()
    {
        return $this->cpuLoadMin1;
    }

    /**
     * Set cpuLoadMin5
     *
     * @param string $cpuLoadMin5
     * @return Snapshot
     */
    public function setCpuLoadMin5($cpuLoadMin5)
    {
        $this->cpuLoadMin5 = $cpuLoadMin5;

        return $this;
    }

    /**
     * Get cpuLoadMin5
     *
     * @return string 
     */
    public function getCpuLoadMin5()
    {
        return $this->cpuLoadMin5;
    }

    /**
     * Set cpuLoadMin15
     *
     * @param string $cpuLoadMin15
     * @return Snapshot
     */
    public function setCpuLoadMin15($cpuLoadMin15)
    {
        $this->cpuLoadMin15 = $cpuLoadMin15;

        return $this;
    }

    /**
     * Get cpuLoadMin15
     *
     * @return string 
     */
    public function getCpuLoadMin15()
    {
        return $this->cpuLoadMin15;
    }

    /**
     * Set memoryTotal
     *
     * @param string $memoryTotal
     * @return Snapshot
     */
    public function setMemoryTotal($memoryTotal)
    {
        $this->memoryTotal = $memoryTotal;

        return $this;
    }

    /**
     * Get memoryTotal
     *
     * @return string 
     */
    public function getMemoryTotal()
    {
        return $this->memoryTotal;
    }

    /**
     * Set memoryUsed
     *
     * @param string $memoryUsed
     * @return Snapshot
     */
    public function setMemoryUsed($memoryUsed)
    {
        $this->memoryUsed = $memoryUsed;

        return $this;
    }

    /**
     * Get memoryUsed
     *
     * @return string 
     */
    public function getMemoryUsed()
    {
        return $this->memoryUsed;
    }

    /**
     * Set memoryFree
     *
     * @param string $memoryFree
     * @return Snapshot
     */
    public function setMemoryFree($memoryFree)
    {
        $this->memoryFree = $memoryFree;

        return $this;
    }

    /**
     * Get memoryFree
     *
     * @return string 
     */
    public function getMemoryFree()
    {
        return $this->memoryFree;
    }

    /**
     * Set memoryBuffersCacheUsed
     *
     * @param string $memoryBuffersCacheUsed
     * @return Snapshot
     */
    public function setMemoryBuffersCacheUsed($memoryBuffersCacheUsed)
    {
        $this->memoryBuffersCacheUsed = $memoryBuffersCacheUsed;

        return $this;
    }

    /**
     * Get memoryBuffersCacheUsed
     *
     * @return string 
     */
    public function getMemoryBuffersCacheUsed()
    {
        return $this->memoryBuffersCacheUsed;
    }

    /**
     * Set memoryBuffersCacheFree
     *
     * @param string $memoryBuffersCacheFree
     * @return Snapshot
     */
    public function setMemoryBuffersCacheFree($memoryBuffersCacheFree)
    {
        $this->memoryBuffersCacheFree = $memoryBuffersCacheFree;

        return $this;
    }

    /**
     * Get memoryBuffersCacheFree
     *
     * @return string 
     */
    public function getMemoryBuffersCacheFree()
    {
        return $this->memoryBuffersCacheFree;
    }

    /**
     * Set memorySwapTotal
     *
     * @param string $memorySwapTotal
     * @return Snapshot
     */
    public function setMemorySwapTotal($memorySwapTotal)
    {
        $this->memorySwapTotal = $memorySwapTotal;

        return $this;
    }

    /**
     * Get memorySwapTotal
     *
     * @return string 
     */
    public function getMemorySwapTotal()
    {
        return $this->memorySwapTotal;
    }

    /**
     * Set memorySwapUsed
     *
     * @param string $memorySwapUsed
     * @return Snapshot
     */
    public function setMemorySwapUsed($memorySwapUsed)
    {
        $this->memorySwapUsed = $memorySwapUsed;

        return $this;
    }

    /**
     * Get memorySwapUsed
     *
     * @return string 
     */
    public function getMemorySwapUsed()
    {
        return $this->memorySwapUsed;
    }

    /**
     * Set memorySwapFree
     *
     * @param string $memorySwapFree
     * @return Snapshot
     */
    public function setMemorySwapFree($memorySwapFree)
    {
        $this->memorySwapFree = $memorySwapFree;

        return $this;
    }

    /**
     * Get memorySwapFree
     *
     * @return string 
     */
    public function getMemorySwapFree()
    {
        return $this->memorySwapFree;
    }

    /**
     * Set diskTotal
     *
     * @param string $diskTotal
     * @return Snapshot
     */
    public function setDiskTotal($diskTotal)
    {
        $this->diskTotal = $diskTotal;

        return $this;
    }

    /**
     * Get diskTotal
     *
     * @return string 
     */
    public function getDiskTotal()
    {
        return $this->diskTotal;
    }

    /**
     * Set diskUsed
     *
     * @param string $diskUsed
     * @return Snapshot
     */
    public function setDiskUsed($diskUsed)
    {
        $this->diskUsed = $diskUsed;

        return $this;
    }

    /**
     * Get diskUsed
     *
     * @return string 
     */
    public function getDiskUsed()
    {
        return $this->diskUsed;
    }

    /**
     * Set diskFree
     *
     * @param string $diskFree
     * @return Snapshot
     */
    public function setDiskFree($diskFree)
    {
        $this->diskFree = $diskFree;

        return $this;
    }

    /**
     * Get diskFree
     *
     * @return string 
     */
    public function getDiskFree()
    {
        return $this->diskFree;
    }

    /**
     * Set server
     *
     * @param \Innova\Heartbeat\AppBundle\Entity\Server $server
     * @return Snapshot
     */
    public function setServer(\Innova\Heartbeat\AppBundle\Entity\Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return \Innova\Heartbeat\AppBundle\Entity\Server 
     */
    public function getServer()
    {
        return $this->server;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->processes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add processes
     *
     * @param \Innova\Heartbeat\AppBundle\Entity\Process $processes
     * @return Snapshot
     */
    public function addProcess(\Innova\Heartbeat\AppBundle\Entity\Process $processes)
    {
        $this->processes[] = $processes;

        return $this;
    }

    /**
     * Remove processes
     *
     * @param \Innova\Heartbeat\AppBundle\Entity\Process $processes
     */
    public function removeProcess(\Innova\Heartbeat\AppBundle\Entity\Process $processes)
    {
        $this->processes->removeElement($processes);
    }

    /**
     * Get processes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProcesses()
    {
        return $this->processes;
    }
}
