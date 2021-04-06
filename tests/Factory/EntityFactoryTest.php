<?php

namespace App\Tests\Factory;

use App\Factory\EntityFactory;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\User\UserRepository;
use App\Entity\User\User;
use App\Entity\EntityInterface;
use PHPUnit\Framework\TestCase;

class EntityFactoryTest extends TestCase
{

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $serializer;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $entityFactory;


	/**
	 * Set up dependency instances
	 * @return void
	 */
	public function setUp() : void
	{
		// enable mocking final classes
		\DG\BypassFinals::enable();

		$this->serializer = $this->createMock(\Symfony\Component\Serializer\SerializerInterface::class);
		$this->entityFactory = $this->createMock(\App\Factory\EntityFactory::class);

	}

	/**
	 * Check instances
	 */
	public function testDependencyInstances()
	{
    	$this->assertInstanceOf(SerializerInterface::class, $this->serializer);		
    	$this->assertInstanceOf(EntityFactory::class, $this->entityFactory);
	}

	/**
	 * Check if User entity is EntityInterface instance
	 */
    public function testIsUserEntityInterfaceInstance()
    {

    	$data = $this->generateUserData();
    	
    	$user = $this->entityFactory->createFromJson($data, \App\Entity\User\User::class, $groups = ['user:create']);

    	$this->assertInstanceOf(EntityInterface::class, $user);

    }

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
