<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Goutte\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     * @Method("GET")
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
                'users'   => $users,
            )
        );
    }

    /**
     * @Route("/key", name="key")
     *
     * @Method("GET")
     * @Template()
     */
    public function keyAction()
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
