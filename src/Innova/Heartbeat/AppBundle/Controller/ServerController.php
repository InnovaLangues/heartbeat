<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\Heartbeat\AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;
use Innova\Heartbeat\AppBundle\Document\ServerData;

/**
 * Server controller
 *
 * @Route("/server")
 */
class ServerController extends Controller
{
    /**
     * Get and show the list of servers.
     *
     * @Route("/", name="server")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $servers = $this->get('innova.server.manager')->getAll();

        return $this->render(
            'servers.html.twig', array(
                'title'   => 'Servers',
                'servers' => $servers,
            )
        );
    }

    /**
     * @Route("/{id}", name="server_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction(Server $server)
    {
        $details = null;
        $id      = null;
        $date    = null;

        $serverDatas = $this->get('innova.serverdata.manager')->findByServerId($server->getUid(), 1000); //1440 24h
        
        print_r($serverDatas);
        die();

        $serverData  = $serverDatas[0];
        //$serverDatas = $this->container->get('serializer')->serialize($serverDatas, 'json');

        if ($serverData) {
            $details = $serverData->getDetails();
        }

        return $this->render(
            'server.html.twig', array(
                'title' => 'Server : '.$server->getName(),
                'server' => $server,
                'details' => $details,
                'channels' => array($server->getUid()),
                'serverDatas' => json_encode($serverDatas->toArray()),
            )
        );
    }
}
