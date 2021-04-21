<?php

namespace App\Tests\Unit\Manager;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\DatabasePrimer;
use App\Entity\EntityInterface;
use App\Entity\Term\Term;
use App\Manager\TermManager;
use App\Repository\Term\TermRepository;
use App\Factory\EntityFactory;

class TermManagerTest extends KernelTestCase
{

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $entityFactory;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $termRepository;

	/**
	 * @var TermManager
	 */
	private $termManager;


	/**
	 * Set up dependency instances
	 * @return void
	 */
    public function setUp() : void
	{
		// enable mocking final classes
		\DG\BypassFinals::enable();
		$kernel = self::bootKernel();

		DatabasePrimer::prime($kernel);

		$this->entityFactory = $this->createMock(EntityFactory::class);
		$this->termRepository = $this->createMock(TermRepository::class);

		$this->termManager = new TermManager($this->termRepository, $this->entityFactory);

	}

	protected function tearDown() : void
	{
		parent::tearDown();

		$this->entityFactory = null;
		$this->termRepository = null;
		$this->termManager = null;
	}

	/** @test */
	public function term_manager_creates_term_instance()
	{
		$data = ['name' => 'someTestTerm'];

		$json = json_encode($data);

		$term = $this->termManager->createFromJson($json, ['term:create']);

		$this->assertInstanceOf(EntityInterface::class, $term);
	
	}

	/** @test */
	public function calculate_score_method_is_calculating_properly()
	{

		$result = $this->termManager->calculateScore(5, 10);

		$this->assertEquals(5, $result);

		$result = $this->termManager->calculateScore(5, 20);

		$this->assertEquals(2.5, $result);

	}


}


