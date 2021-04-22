<?php 

namespace App\Manager;

use App\Service\GithubAPIService;
use Symfony\Component\HttpClient\Response\TraceableResponse;

final class SearchManager 
{
	private GithubAPIService $service;

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