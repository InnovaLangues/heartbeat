<?php

namespace Innova\Heartbeat\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Process
 *
 * @ORM\Table("process")
 * @ORM\Entity
 */
class Process
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
     * @ORM\ManyToOne(targetEntity="Snapshot", inversedBy="processes")
     * @ORM\JoinColumn(name="snapshot_id", referencedColumnName="id")
     **/
    private $snapshot;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="percentCpu", type="string", length=255)
     */
    private $percentCpu;

    /**
     * @var string
     *
     * @ORM\Column(name="memoryUsed", type="string", length=255)
     */
    private $memoryUsed;


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
     * Set user
     *
     * @param string $user
     * @return Process
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set command
     *
     * @param string $command
     * @return Process
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return string 
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set percentCpu
     *
     * @param string $percentCpu
     * @return Process
     */
    public function setPercentCpu($percentCpu)
    {
        $this->percentCpu = $percentCpu;

        return $this;
    }

    /**
     * Get percentCpu
     *
     * @return string 
     */
    public function getPercentCpu()
    {
        return $this->percentCpu;
    }

    /**
     * Set memoryUsed
     *
     * @param string $memoryUsed
     * @return Process
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
     * Set snapshot
     *
     * @param \Innova\Heartbeat\AppBundle\Entity\Snapshot $snapshot
     * @return Process
     */
    public function setSnapshot(\Innova\Heartbeat\AppBundle\Entity\Snapshot $snapshot = null)
    {
        $this->snapshot = $snapshot;

        return $this;
    }

    /**
     * Get snapshot
     *
     * @return \Innova\Heartbeat\AppBundle\Entity\Snapshot 
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }
}
