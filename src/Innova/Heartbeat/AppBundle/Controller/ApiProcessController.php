<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\Heartbeat\AppBundle\Entity\Server;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\Heartbeat\AppBundle\Document\Snapshot;
use Innova\Heartbeat\AppBundle\Document\Process;

/**
 * Process controller
 *
 * @Route("/api/process")
 */
class ApiProcessController extends Controller
{
    /**
     * Get and show the list of servers.
     *
     * @Route("/{id}", name="api_process", options={"expose"=true}))
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Snapshot $snapshot)
    {
        $processes = 
            $this
                ->get('innova.process.manager')
                ->getRepository('InnovaHeartbeatAppBundle:Process')
                ->findBy(
                    array(
                        'id' => $snapshot->getId()
                    )
                );

        $serialized = $this->container->get('serializer')->serialize($processes, 'json');
        
        return new Response($serialized, 200, array('Content-Type' => 'application/json'));
    }
}
