<?php

namespace App\Service;

use App\Service\AbstractClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class GithubAPIService extends AbstractClient
{

    /**
     * Search github issues
     *
     * @param string $term
     * @return TraceableResponse
     */
    public function searchIssues(string $term) : ResponseInterface
    {
        $response = $this->request(
            'GET',
            'https://api.github.com/search/issues',
            [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json'
                ],
                'query' => [
                    'q' => $term,
                    'per_page' => 1
                ]
            ]
        );

        return $response;
    }
}