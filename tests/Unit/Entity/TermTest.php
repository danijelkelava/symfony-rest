<?php

namespace App\Tests\Unit\Manager;

use PHPUnit\Framework\TestCase;
use App\Manager\TermManager;
use App\Entity\Term\Term;
use Symfony\Component\Serializer\SerializerInterface;

class TermTest extends TestCase
{

	public function testCreatedAt()
	{
		$term = new Term;

		$this->assertInstanceOf('DateTimeInterface', $term->getCreatedAt());
	}


}
