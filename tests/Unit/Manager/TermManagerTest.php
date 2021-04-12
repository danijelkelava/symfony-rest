<?php

namespace App\Tests\Unit\Manager;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Manager\TermManager;

class TermManagerTest extends TestCase
{

	private $termManager;

	/**
	 * Set up dependency instances
	 * @return void
	 */
	public function setUp() : void
	{

		$this->termManager = $this->createMock(TermManager::class);

	}

	public function testCalculateScore()
	{

		$result = $this->termManager->calculateScore(0, 0);
		$this->assertIsFloat($result);

	}


}


