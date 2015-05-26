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
 * @Route("/api/server")
 */
class ApiServerController extends Controller
{
    /**
     * Get and show the list of servers.
     *
     * @Route("/", name="api_server", options={"expose"=true}))
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $servers = $this->get('innova.server.manager')->getAll();

        $serialized = $this->container->get('serializer')->serialize($servers, 'json');

        return new Response($serialized, 200, array('Content-Type' => 'application/json'));


    }

    /**
     * @Route("/{id}", name="api_server_show", options={"expose"=true}))
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
