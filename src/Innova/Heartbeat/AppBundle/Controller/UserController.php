<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user")
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:User')->findAll();

        return $this->render(
            'users.html.twig', array(
                'title' => 'Users',
                'users' => $users,
            )
        );
    }
}
