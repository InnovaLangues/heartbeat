<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Goutte\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;

class HomeController extends Controller 
{

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction() 
    {
        $servers = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:Server')->findAll();
        $apps = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:App')->findAll();
        $users = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:User')->findAll();        
     
        return $this->render(
            'index.html.twig', 
            array(
                'title'   => 'Dashboard',
                'servers' => $servers,
                'apps'    => $apps,
                'users'   => $users
           )
        );
    }
    
    /**
     * @Route("apps", name="apps")
     * @Template()
     */
    public function appsAction() 
    {
        $apps = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:App')->findAll();

        foreach ($apps as $app) {

            $app->statusCode = null;

            $client = new Client();

            try {
                $client->request('GET', $app->getUrl());
            } catch (\Exception $e) {
                $app->statusCode = 500;
            }

            if ($app->statusCode != 500) {
                $app->statusCode = $client->getResponse()->getStatus();
            }
        }

        return $this->render(
            'apps.html.twig', array(
                'title' => 'Apps',
                'apps' => $apps
            )
        );
    }

    /**
     * @Route("users", name="users")
     * @Template()
     */
    public function usersAction() 
    {
        $users = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:User')->findAll();

        return $this->render(
            'users.html.twig', array(
                'title' => 'Servers',
                'users' => $users
            )
        );
    }

    /**
     * @Route("keys", name="keys")
     * @Template()
     */
    public function keysAction() 
    {
        $response = new Response();
        $finder   = new Finder();

        $finder->files()->in('../app/config')->name('public.key');

        foreach ($finder as $file) {
            $contents = $file->getContents();
        }

        $response
            ->setStatusCode(200)
            ->setContent($contents)
            ->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
