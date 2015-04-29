<?php

namespace Innova\Heartbeat\AppBundle\Twig;

use Innova\Heartbeat\AppBundle\Manager\GithubManager;

class GithubExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('githubAvatarURL', array($this, 'avatarURLFilter')),
            new \Twig_SimpleFilter('githubHTMLURL', array($this, 'HTMLURLFilter')),
            new \Twig_SimpleFilter('githubName', array($this, 'nameFilter')),
            new \Twig_SimpleFilter('githubLocation', array($this, 'locationFilter')),
            new \Twig_SimpleFilter('githubPublicKeys', array($this, 'publicKeysFilter')),
        );
    }

    public function avatarURLFilter($login)
    {
        $githubManager = new GithubManager();
        return $githubManager->getAvatarURL($login);
    }

    public function HTMLURLFilter($login)
    {
        $githubManager = new GithubManager();
        return $githubManager->getHTMLURL($login);
    }

    public function nameFilter($login)
    {
        $githubManager = new GithubManager();
        return $githubManager->getName($login);
    }

    public function locationFilter($login)
    {
        $githubManager = new GithubManager();
        return $githubManager->getLocation($login);
    }

    public function publicKeysFilter($login)
    {
        $githubManager = new GithubManager();
        return $githubManager->getPublicKeys($login);
    }

    public function getName()
    {
        return 'github_extension';
    }
}
