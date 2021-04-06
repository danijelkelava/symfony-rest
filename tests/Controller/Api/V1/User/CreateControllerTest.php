<?php

namespace App\Tests\Controller\Api\V1\User;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User\User;
use App\Factory\EntityFactory;
use App\Entity\EntityInterface;
use App\Repository\User\UserRepository;
use App\Responder\Responder;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateControllerTest extends TestCase
{
	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $entityFactory;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $repository;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $responder;	

	/**
	 * Set up dependency instances
	 * @return void
	 */
	public function setUp() : void
	{
		// enable mocking final classes
		\DG\BypassFinals::enable();

		$this->entityFactory = $this->createMock(EntityFactory::class);
		$this->repository = $this->createMock(UserRepository::class);
		$this->responder = $this->createMock(Responder::class);

	}

	public function testDependencyInstances()
	{
    	$this->assertInstanceOf(EntityFactory::class, $this->entityFactory);		
    	$this->assertInstanceOf(UserRepository::class, $this->repository);		
	}

    /*public function testControllerAction()
    {
    	$data = $this->generateUserData();

    	// assert that data is json string
    	$this->assertIsString($data);

    	$user = $this->entityFactory->createFromJson($data, \App\Entity\User\User::class, $groups = ['user:create']);

    	$this->assertInstanceOf(EntityInterface::class, $user);

    	$response = $this->responder($user, 'json', ['user:create'], true);

    	$this->assertInstanceOf(JsonResponse::class, $response);

        $client = static::createClient();

        $client->request('POST', '/api/v1/user/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    /**
     * Returns test user with random data in JSON format
     * @return string
     */
    public function generateUserData() : string
    {
    	$email = "test_email".rand(5, 7)."@mail.com";
    	$data = "{  \"email\": \"${email}\",  \"password\": \"string\",  \"first_name\": \"string\",  \"last_name\": \"string\"}";

    	return $data;    	
    }
}
