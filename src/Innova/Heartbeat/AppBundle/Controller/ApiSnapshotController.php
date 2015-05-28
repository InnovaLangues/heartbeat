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
     * @Route("/{uid}", name="api_snapshot", options={"expose"=true}))
     *
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Server $server)
    {
        if ($this->getRequest()->isMethod('GET')) {
            $snapshots = 
            	$this
            		->get('innova.snapshot.manager')
            		->getRepository('InnovaHeartbeatAppBundle:Snapshot')
            		->findBy(
            			array(
            				'serverId' => $server->getUid()
            			), 
            			array('timestamp' => 'asc')
            		);

            $serialized = $this->container->get('serializer')->serialize($snapshots, 'json');
        } elseif ($this->getRequest()->isMethod('POST')) {

            if (0 === strpos($this->getRequest()->headers->get('Content-Type'), 'application/json')) {
                $json = json_decode($this->getRequest()->getContent(), true);
            }

            // save data in mongodb            
            $snapshot = new Snapshot();
            $snapshot->setServerId($server->getUid());
            $snapshot->setTimestamp($json->timestamp);
            $snapshot->setDiskTotal($json->disk->total);
            $snapshot->setDiskUsed($json->disk->used);
            $snapshot->setDiskFree($json->disk->free);
            $snapshot->setCpuCount($json->cpu->count);
            $snapshot->setCpuLoadMin1($json->cpu->load->min1);
            $snapshot->setCpuLoadMin5($json->cpu->load->min5);
            $snapshot->setCpuLoadMin15($json->cpu->load->min15);
            $snapshot->setMemoryTotal($json->memory->total);
            $snapshot->setMemoryUsed($json->memory->used);
            $snapshot->setMemoryFree($json->memory->free);
            $snapshot->setMemoryBuffersCacheUsed($json->memory->buffersCache->used);
            $snapshot->setMemoryBuffersCacheFree($json->memory->buffersCache->free);
            $snapshot->setMemorySwapTotal($json->memory->swap->total);
            $snapshot->setMemorySwapUsed($json->memory->swap->used);
            $snapshot->setMemorySwapFree($json->memory->swap->free);

            $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
            $documentManager->persist($snapshot);
            $documentManager->flush();
        }

        return new Response($serialized, 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/{uid}/last", name="api_server_show", options={"expose"=true}))
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
