<?php

namespace Innova\Heartbeat\AppBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * ServerData
 *
 * @MongoDB\Document
 */
class ServerData
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
    private $details;
    
    /**
     *
     * @var date
     * @MongoDB\Date 
     */
    private $date;
    
    public function __construct() {
        $date = new \DateTime();
        $this->setDate($date);
    }

   
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
     * Set server id
     *
     * @param string $id
     * @return Server
     */
    public function setServerId($id)
    {
        $this->serverId = $id;
    }
    
    /**
     * 
     * @return Server
     */
    public function getServerId()
    {
        return $this->serverId;
    }
    
     /**
     * Set details
     *
     * @param String $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
    
    /**
     * 
     * @return Server
     */
    public function getDetails()
    {
        return $this->details;
    }
    
    /**
     * 
     * @param date $date
     */
    public function setDate($date){
        $this->date = $date;
    }
    
    /**
     * 
     * @return Date
     */
    public function getDate(){
        //print_r($this->date);die;
        return $this->date;
    }
}
