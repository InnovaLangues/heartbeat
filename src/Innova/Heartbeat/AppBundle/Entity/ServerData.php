<?php

namespace Innova\Heartbeat\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServerData
 *
 * @ORM\Table("serverData")
 * @ORM\Entity
 */
class ServerData
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
     * @var string
     *
     * @ORM\Column(name="serverId", type="string", length=255)
     */
    private $serverId;

    /**
     * @var string
     *
     * @ORM\Column(name="timestamp", type="string", length=255)
     */
    private $timestamp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="diskTotal", type="string", nullable=true, length=255)
     */
    private $diskTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="diskFree", type="string", nullable=true, length=255)
     */
    private $diskFree;

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
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set server id.
     *
     * @param string $id
     *
     * @return Server
     */
    public function setServerId($id)
    {
        $this->serverId = $id;
    }

    /**
     * @return Server
     */
    public function getServerId()
    {
        return $this->serverId;
    }
}
