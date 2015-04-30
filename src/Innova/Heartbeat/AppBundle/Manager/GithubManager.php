<?php

namespace Innova\Heartbeat\AppBundle\Manager;

/**
 * Manager for Github.
 */
class GithubManager
{
    protected $client;

    public function __construct()
    {
        $client = new \Github\Client(
            new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '/tmp/github-api-cache'))
        );

        // Or select directly which cache you want to use
        $client = new \Github\HttpClient\CachedHttpClient();
        $client->setCache(
            // Built in one, or any cache implementing this interface:
            // Github\HttpClient\Cache\CacheInterface
            new \Github\HttpClient\Cache\FilesystemCache('/tmp/github-api-cache')
        );

        $this->client = new \Github\Client($client);
    }

    public function getAvatarURL($login)
    {
        $user = $this->client->api('user')->show($login);

        return $user['avatar_url'];
    }

    public function getHTMLURL($login)
    {
        $user = $this->client->api('user')->show($login);

        return $user['html_url'];
    }

    public function getName($login)
    {
        $user = $this->client->api('user')->show($login);

        return $user['name'];
    }

    public function getLocation($login)
    {
        $user = $this->client->api('user')->show($login);

        return $user['location'];
    }

    public function getPublicKeys($login)
    {
        return 'https://github.com/'.$login.'.keys';
    }

    // Get pubkeys
    /*
    "login": "purplefish32",
    "id": 479917,
    "avatar_url": "https://avatars.githubusercontent.com/u/479917?v=3",
    "gravatar_id": "",
    "url": "https://api.github.com/users/purplefish32",
    "html_url": "https://github.com/purplefish32",
    "followers_url": "https://api.github.com/users/purplefish32/followers",
    "following_url": "https://api.github.com/users/purplefish32/following{/other_user}",
    "gists_url": "https://api.github.com/users/purplefish32/gists{/gist_id}",
    "starred_url": "https://api.github.com/users/purplefish32/starred{/owner}{/repo}",
    "subscriptions_url": "https://api.github.com/users/purplefish32/subscriptions",
    "organizations_url": "https://api.github.com/users/purplefish32/orgs",
    "repos_url": "https://api.github.com/users/purplefish32/repos",
    "events_url": "https://api.github.com/users/purplefish32/events{/privacy}",
    "received_events_url": "https://api.github.com/users/purplefish32/received_events",
    "type": "User",
    "site_admin": false,
    "name": "Donovan Tengblad",
    "company": null,
    "blog": null,
    "location": "Grenoble",
    "email": null,
    "hireable": false,
    "bio": null,
    "public_repos": 62,
    "public_gists": 14,
    "followers": 18,
    "following": 23,
    "created_at": "2010-11-13T09:31:00Z",
    "updated_at": "2015-03-16T13:24:05Z"
    */
}
