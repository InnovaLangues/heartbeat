<?php

namespace Innova\Heartbeat\AppBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Server
 *
 * @MongoDB\Document
 */
class Server
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
    private $ip;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $name;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $os;

    /**
     * @var string
     *
     * @MongoDB\String
     */
    private $linuxDashUrl;


    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Server
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Server
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set os
     *
     * @param string $os
     * @return Server
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Get os
     *
     * @return string 
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Set linuxDashUrl
     *
     * @param string $linuxDashUrl
     * @return Server
     */
    public function setLinuxDashUrl($linuxDashUrl)
    {
        $this->linuxDashUrl = $linuxDashUrl;

        return $this;
    }

    /**
     * Get linuxDashUrl
     *
     * @return string 
     */
    public function getLinuxDashUrl()
    {
        return $this->linuxDashUrl;
    }
}