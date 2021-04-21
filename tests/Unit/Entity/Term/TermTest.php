<?php

namespace App\Tests\Unit\Entity\Term;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Term\Term;
use App\Tests\DatabasePrimer;

class TermTest extends KernelTestCase
{

	/** @var EntityManagerInterface */
	private $entityManager;

	/**
	 * Set up dependency instances
	 * @return void
	 */
    public function setUp() : void
	{
		$kernel = self::bootKernel();

		DatabasePrimer::prime($kernel);

		$this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
	}

	protected function tearDown() : void
	{
		parent::tearDown();

		$this->entityManager->close();
		$this->entityManager = null;
	}

	/** @test */
	public function can_term_be_saved_in_database()
	{
		$term = new Term();

		$this->assertInstanceOf('DateTimeInterface', $term->getCreatedAt());

		$term->setName('Danijel');
		$term->setTotalCount(1234);

		$this->entityManager->persist($term);

		$this->entityManager->flush();

		$termRepository = $this->entityManager->getRepository(Term::class);

		$termRecord = $termRepository->findOneBy(['name' => 'Danijel']);

		$this->assertEquals(1234, $termRecord->getTotalCount());
	}

}
