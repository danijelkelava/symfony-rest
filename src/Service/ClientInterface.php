<?php

namespace App\Service;

interface ClientInterface
{
	public function request(string $method, string $url, array $options = []);
}