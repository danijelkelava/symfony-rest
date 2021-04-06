<?php

namespace App\Service;

use App\Service\AbstractClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubAPIService extends AbstractClient
{

    public function fetchGitHubInformation(): array
    {
        $response = $this->getClient()->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    public function searchIssues(string $term)
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