<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Goutte\Client;

class AppController extends Controller
{
    /**
     * @Route("apps", name="apps")
     *
     * @Method("GET")
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
                    'apps' => $apps,
                        )
        );
    }
}
