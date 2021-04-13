<?php

namespace App\Tests\Unit\Manager;

use PHPUnit\Framework\TestCase;
use App\Entity\Term\Term;
use App\Manager\TermManager;

class TermManagerTest extends TestCase
{

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject
	 */
	private $termManager;

	/**
	 * Set up dependency instances
	 * @return void
	 */
	public function setUp() : void
	{

		$this->termManager = $this->createMock(TermManager::class);

	}

	public function testTermCreation()
	{
		$data = ['name' => 'php'];
		$json = json_encode($data);

		$this->assertIsString($json);

		$term = $this->termManager->createFromJson($json, ['term:create']);

		$this->assertInstanceOf(Term::class, $term);
	
	}

	public function testCalculateScore()
	{

		$result = $this->termManager->calculateScore(0, 0);
		$this->assertIsFloat($result);

	}


}


