<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\Heartbeat\AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Innova\Heartbeat\AppBundle\Document\Snapshot;

/**
 * Server controller
 *
 * @Route("/api/snapshot")
 */
class ApiSnapshotController extends Controller
{
    /**
     * Get and show the list of servers.
     *
     * @Route("/{uid}", name="api_snapshot")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Server $server)
    {
        $snapshots = $this->get('innova.snapshot.manager')->getRepository('InnovaHeartbeatAppBundle:Snapshot')->findAll();

        $serialized = $this->container->get('serializer')->serialize($snapshots, 'json');

        return new Response($serialized, 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/{uid}/last", name="api_server_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction(Server $server)
    {
        $serialized = $this->container->get('serializer')->serialize($server, 'json');

        return new Response($serialized, 200, array('Content-Type' => 'application/json'));
    }
}
