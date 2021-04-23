<?php 

namespace App\Manager;

use App\Service\ClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SearchManager 
{
	private ClientInterface $service;

	public function __construct(ClientInterface $service)
	{
		$this->service = $service;
	}

	public function searchTerm(string $term) : ResponseInterface
	{
		$response = $this->service->searchIssues($term);

		return $response;
	}
}