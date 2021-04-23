<?php

namespace App\Service;

use App\Service\ClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractClient implements ClientInterface
{

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function request(array $data)
    {
        return $this->client->request($data);
    }
}