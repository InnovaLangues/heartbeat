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
            // limit the request results
            $limit = 30;
            $snapshots = 
            	$this
            		->get('innova.snapshot.manager')
            		->getRepository('InnovaHeartbeatAppBundle:Snapshot')
            		->findBy(
            			array(
            				'serverId' => $server->getUid()
            			), 
            			array('timestamp' => 'asc'), $limit
            		);

            $serialized = $this->container->get('serializer')->serialize($snapshots, 'json');
            
            return new Response($serialized, 200, array('Content-Type' => 'application/json'));

        } elseif ($this->getRequest()->isMethod('POST')) {

            if (0 === strpos($this->getRequest()->headers->get('Content-Type'), 'application/json')) {
                $json = json_decode($this->getRequest()->getContent());
            }

            // save data in mongodb            
            $snapshot = new Snapshot();
            $snapshot->setServerId($server->getUid());
            $snapshot->setTimestamp($json->timestamp);
            $snapshot->setDiskTotal($json->diskTotal);
            $snapshot->setDiskUsed($json->diskUsed);
            $snapshot->setDiskFree($json->diskFree);
            $snapshot->setCpuCount($json->cpuCount);
            $snapshot->setCpuLoadMin1($json->cpuLoadMin1);
            $snapshot->setCpuLoadMin5($json->cpuLoadMin5);
            $snapshot->setCpuLoadMin15($json->cpuLoadMin15);
            $snapshot->setMemoryTotal($json->memoryTotal);
            $snapshot->setMemoryUsed($json->memoryUsed);
            $snapshot->setMemoryFree($json->memoryFree);
            $snapshot->setMemoryBuffersCacheUsed($json->memoryBuffersCacheUsed);
            $snapshot->setMemoryBuffersCacheFree($json->memoryBuffersCacheFree);
            $snapshot->setMemorySwapTotal($json->memorySwapTotal);
            $snapshot->setMemorySwapUsed($json->memorySwapUsed);
            $snapshot->setMemorySwapFree($json->memorySwapFree);

            foreach ($json->processes as $jsonProcess) {
                $process = new Process();
                $process->setSnapshot($snapshot);
                $process->setUser($jsonProcess->user);
                $process->setComm($jsonProcess->comm);
                $process->setPcpu($jsonProcess->pcpu);
                $process->setVsz($jsonProcess->vsz);
                $documentManager->persist($process);
            }

            $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
            $documentManager->persist($snapshot);
            $documentManager->flush();
        }

        return new JsonResponse();
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
