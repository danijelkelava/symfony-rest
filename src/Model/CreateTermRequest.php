<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTermRequest
{

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
	public $name;
}