<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractClient
{

    /**
     * @var HttpClientInterface
     */
    protected $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient() : HttpClientInterface
    {
        return $this->client;
    }

}