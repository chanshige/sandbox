<?php
namespace Jobchan\Handler;

use GuzzleHttp\Client as Guzzle;

class SlackHandler
{
    /** @var Guzzle */
    private $client;
    /** @var string */
    private $webhook;

    protected $channel;
    protected $username;
    protected $icon;
    protected $message;

    /**
     * SlackHandler constructor.
     *
     * @param Guzzle $client
     */
    public function __construct(Guzzle $client, $webhook)
    {
        $this->client = $client;
        $this->webhook = $webhook;
    }

    /**
     * @param $channel
     * @return $this
     */
    public function channel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @param $username
     * @return $this
     */
    public function username($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function text($message)
    {
        $this->message = $message;
        return $this;
    }

    public function send()
    {
        $this->client->post($this->webhook, ['body' => $this->payload()]);
    }

    public function payload()
    {
        $payload = [
            'channel' => $this->channel,
            'username' => $this->username,
            'icon_emoji' => $this->icon,
            'text' => $this->message
        ];

        return json_encode($payload, JSON_UNESCAPED_UNICODE);
    }
}
