<?php
namespace Jobchan\Handler;

use GuzzleHttp\Client as Guzzle;

/**
 * Class BacklogHandler
 *
 * @method BacklogHandler notification();
 * @method BacklogHandler issues(array $option);
 * @method BacklogHandler issue(string $projectKey, array $option = []);
 * @method BacklogHandler project(string $projectKey, array $option = []);
 * @method BacklogHandler watching(string $userId, array $option = []);
 * @method BacklogHandler activity(string $userId, array $option = []);
 * @package Jobchan\Handler
 */
class BacklogHandler
{
    /** @var Guzzle */
    protected $client;
    /** @var string BaseUri */
    private $baseUri;

    /**
     * BacklogHandler constructor.
     *
     * @param Guzzle $client
     * @param string $spaceUrl
     */
    public function __construct(Guzzle $client, $spaceUrl)
    {
        $this->baseUri = $spaceUrl . 'api/v2/';
        $this->client = $client;
    }

    public function __call($method, $args)
    {
        // 第一引数がoptionの場合
        if (is_array($args[0])) {
            return $this($this->createUrl($method), $args[0]);
        }

        return $this(
            $this->createUrl($method, isset($args[0]) ? $args[0] : ''),
            isset($args[1]) ? $args[1] : []
        );
    }

    /**
     * @param string $uri
     * @param array  $options
     * @return string
     */
    public function __invoke($uri, array $options = [])
    {
        $response = $this->client->get($uri, ['query' => $this->buildQuery($options)]);
        return (string)$response->getBody();
    }

    /**
     * @param string $method
     * @param string $key
     * @return string
     */
    private function createUrl($method, $key = '')
    {
        switch ($method) {
            case 'notification':
                return $this->baseUri . "notifications";
                break;

            case 'project':
                return $this->baseUri . "projects/" . $key;
                break;

            case 'issues':
                return $this->baseUri . "issues";
                break;

            case 'issue':
                return $this->baseUri . "issues/" . $key;
                break;

            case 'watching':
                return $this->baseUri . "users/" . $key . "/watchings";
                break;

            case 'activity':
                return $this->baseUri . "users/" . $key . "/activities";
                break;

            default:
                break;
        }
        return $this->baseUri;
    }

    /**
     * @param array $opt
     * @return array
     */
    private function buildQuery($opt = [])
    {
        return array_merge(['apiKey' => getenv('BACKLOG_API_KEY')], $opt);
    }
}
