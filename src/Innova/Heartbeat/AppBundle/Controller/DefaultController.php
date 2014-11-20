<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Finder\Finder;
use Innova\Heartbeat\AppBundle\Entity\Server;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use \Wa72\HtmlPageDom\HtmlPageCrawler;

class DefaultController extends Controller
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
                'users'   => $users,
            )
        );
    }

    /**
     * @Route("servers", name="servers")
     * @Template()
     */
    public function serversAction()
    {
        $servers = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:Server')->findAll();

        return $this->render(
            'servers.html.twig',
            array(
                'title'   => 'Servers',
                'servers' => $servers
            )
        );
    }

    /**
     * @Route("server/{id}", name="server")
     * @Template()
     */
    public function serverAction(Server $server)
    {
        //$servers = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:Server')->findAll();

        return $this->render(
            'server.html.twig',
            array(
                'title'   => 'Server',
                'server' => $server
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

            if($app->statusCode != 500) {
                $app->statusCode = $client->getResponse()->getStatus();
            }
        }

        return $this->render(
            'apps.html.twig',
            array(
                'title' => 'Apps',
                'apps'  => $apps
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
            'users.html.twig',
            array(
                'title' => 'Servers',
                'users' => $users
            )
        );
    }

    /**
     * @Route("devdocs", name="devdocs")
     * @Template()
     */
    public function devdocsAction()
    {
        $path = $this->get('kernel')->getRootDir() . '/devdocs/index.md';

        $text = file_get_contents($path);

        $html = $this->container->get('markdown.parser')->transformMarkdown($text);

        $editedHtml = new HtmlPageCrawler($html);

        $headings = array();
        $title = null;
        $count = 0;

        $editedHtml->filter('h1, h2, h3')->each(function ($node, $i) use (&$headings, &$title, &$count) {

            $count++;

            $slug = $this->get('cocur_slugify')->slugify($node->text()) .  '_' . $count;

            $heading = new \stdClass();

            $node->setAttribute('id', $slug);

            $heading->text = $node->text();
            $heading->class = $node->nodeName();
            $heading->slug = $slug;

            $headings[] = $heading;
        });

        $html = $editedHtml->saveHTML();

        return $this->render(
            'devdocs.html.twig',
            array(
                'title' => $headings[0]->text,
                'headings' => $headings,
                'html' => $html
            )
        );
    }
}
