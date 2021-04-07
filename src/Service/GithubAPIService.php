<?php

namespace App\Service;

use App\Service\AbstractClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpClient\Response\TraceableResponse;

class GithubAPIService extends AbstractClient
{

    public function searchIssues(string $term) : TraceableResponse
    {
        $response = $this->getClient()->request(
            'GET',
            'https://api.github.com/search/issues',
            [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json'
                ],
                'query' => [
                    'q' => $term
                ]
            ]
        );

        return $response;
    }
}