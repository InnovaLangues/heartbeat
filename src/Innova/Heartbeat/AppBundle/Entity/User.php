<?php

namespace Innova\Heartbeat\AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
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
     * @ORM\Column(name="preferedUid", type="string", nullable=true, length=255)
     */
    private $preferedUid;

    /**
     * @var string
     *
     * @ORM\Column(name="preferedGid", type="string", nullable=true, length=255)
     */
    private $preferedGid;

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
     * Set preferedUid
     *
     * @param string $preferedUid
     * @return User
     */
    public function setPreferedUid($preferedUid)
    {
        $this->preferedUid = $preferedUid;

        return $this;
    }

    /**
     * Get preferedUid
     *
     * @return string 
     */
    public function getPreferedUid()
    {
        return $this->preferedUid;
    }

    /**
     * Set preferedGid
     *
     * @param string $preferedGid
     * @return User
     */
    public function setPreferedGid($preferedGid)
    {
        $this->preferedGid = $preferedGid;

        return $this;
    }

    /**
     * Get preferedGid
     *
     * @return string 
     */
    public function getPreferedGid()
    {
        return $this->preferedGid;
    }
}
