<?php

namespace Innova\Heartbeat\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller {

    /**
     * @Route("users", name="users")
     * @Method("GET")
     * @Template()
     */
    public function usersAction() {
        $users = $this->getDoctrine()->getRepository('InnovaHeartbeatAppBundle:User')->findAll();

        return $this->render(
            'users.html.twig', array(
                'title' => 'Servers',
                'users' => $users
            )
        );
    }

}
