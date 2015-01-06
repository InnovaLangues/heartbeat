<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\Heartbeat\AppBundle\Document\ServerData;

class ServerDataController extends Controller {

    /**
     * Get all available servers data
     * @Route("serversData", name="servers_data")
     */
    public function getServersDataAction() {
        $servers = $this->get('doctrine_mongodb')->getRepository('InnovaHeartbeatAppBundle:Server')->findAll();
        
        

        foreach ($servers as $server) {
            $connection =  $this->get('innova.serverdata.manager')->getConnection($server, 'heartbeat', 'heartbeat');
            // connect to server
           
            // ssh2_auth_password($connection, 'heartbeat', 'heartbeat');
            // get data
            $stream = ssh2_exec($connection, '/usr/local/bin/php -i');

            // save data in mongodb
            $serverData = new ServerData();
            $serverData->setServer($server);
            $serverData->setDetails($stream);
        }
    }

}
