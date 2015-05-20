<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\Heartbeat\AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;

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
        $snapshot       = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:Snapshot')->findOneBy(array('server' => $server), array('timestamp' => 'desc'));
        $serializer     = $this->container->get('serializer');
        $array          = array_reverse($server->getSnapshots()->toArray());
        $jsonSnapshots  = $serializer->serialize($array, 'json');

        return $this->render(
            'server.html.twig', array(
                'title' => 'Server : '. $server->getName(),
                'server' => $server,
                'snapshot' => $snapshot,
                'jsonSnapshots' => $jsonSnapshots,
                'channels' => array($server->getUid()),
            )
        );
    }
}
