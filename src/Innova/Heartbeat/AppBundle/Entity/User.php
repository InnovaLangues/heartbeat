<?php

namespace Innova\Heartbeat\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * App.
 *
 * @ORM\Table("user")
 * @ORM\Entity
 */
class User extends BaseUser
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
     * @ORM\Column(name="githubId", type="string", nullable=true)
     */
    private $githubId;

    /**
     * @var string
     *
     * @ORM\Column(name="preferedUID", type="string", nullable=true, length=255)
     */
    private $preferedUID;

    /**
     * @var string
     *
     * @ORM\Column(name="preferedGID", type="string", nullable=true, length=255)
     */
    private $preferedGID;

    public function __construct()
    {
        parent::__construct();
    }


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
     * Set githubId
     *
     * @param string $githubId
     * @return User
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }

    /**
     * Get githubId
     *
     * @return string 
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * Set preferedUID
     *
     * @param string $preferedUID
     * @return User
     */
    public function setPreferedUID($preferedUID)
    {
        $this->preferedUID = $preferedUID;

        return $this;
    }

    /**
     * Get preferedUID
     *
     * @return string 
     */
    public function getPreferedUID()
    {
        return $this->preferedUID;
    }

    /**
     * Set preferedGID
     *
     * @param string $preferedGID
     * @return User
     */
    public function setPreferedGID($preferedGID)
    {
        $this->preferedGID = $preferedGID;

        return $this;
    }

    /**
     * Get preferedGID
     *
     * @return string 
     */
    public function getPreferedGID()
    {
        return $this->preferedGID;
    }
}
