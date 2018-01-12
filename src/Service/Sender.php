<?php namespace App\Service;

use App\Model\Notification;
use GuzzleHttp\Client;

class Sender
{
    /** @var Client */
    protected $httpClient;

    /**
     * @var array
     */
    protected $config;

    /**
     * Notification constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new Client();
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function notification(Notification $notification)
    {
        $config = [
            'user' => $this->config['user'],
            'token' => $this->config['token'],
            'title' => $notification->getTitle(),
            'message' => $notification->getMessage(),
            'device' => $notification->getDevice(),
            'priority' => $notification->getPriority(),
            'html' => (int) $notification->isHtml(),
        ];

//        dd($config);

        $x = $this->httpClient->post($this->config['baseurl'], [
            'form_params' => $config,
        ]);

        return $x->getStatusCode() == 200;
    }
}