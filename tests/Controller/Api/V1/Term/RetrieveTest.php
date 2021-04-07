<?php

namespace App\Tests\Controller\Api\V1\Term;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RetrieveTest extends WebTestCase
{

    /**
     * @var KernelBrowser
     */
    private $client;

	/**
	 * Set up dependency instances
	 * @return void
	 */
	public function setUp() : void
	{
		$this->client = self::createClient();
	}

	public function testControllerAction()
	{

        $this->client->request(
            'GET',
            '/api/v1/term/scala1'
        );

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(true, $this->client->getResponse()->isSuccessful());
	}


}
