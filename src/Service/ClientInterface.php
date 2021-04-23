<?php

namespace App\Service;


interface ClientInterface
{
	public function request(array $data);
}