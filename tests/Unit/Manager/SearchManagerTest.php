<?php

namespace App\Tests\Unit\Manager;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Manager\SearchManager;
use App\Service\GithubAPIService;
use Symfony\Component\HttpClient\Response\TraceableResponse;

class SearchManagerTest extends KernelTestCase
{

	/**
	 * @var SearchManager
	 */
	private $searchManager;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $service;


	/**
	 * Set up dependency instances
	 * @return void
	 */
    public function setUp() : void
	{
		$this->service = $this->createMock(GithubAPIService::class);
		$this->searchManager = new SearchManager($this->service);
	}

	/** @test */
	public function is_response_instance_of_tranceable_response()
	{
		$response = $this->searchManager->searchTerm('test');

		$this->assertInstanceOf(TraceableResponse::class, $response);
	
	}
}


