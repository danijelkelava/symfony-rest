<?php 

namespace App\Manager;

use App\Service\ClientInterface;
use App\Service\GithubAPIService;
use Symfony\Component\HttpClient\Response\TraceableResponse;

final class SearchManager 
{
	private ClientInterface $service;

	public function __construct(GithubAPIService $service)
	{
		$this->service = $service;
	}

	public function searchTerm(string $term) : TraceableResponse
	{
		$response = $this->service->searchIssues($term);

		return $response;
	}
}