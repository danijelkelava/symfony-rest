<?php

namespace App\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class Responder
{
	private $serializer;

	public function __construct(SerializerInterface $serializer)
	{
		$this->serializer = $serializer;
	}

    public function __invoke($data, $format, $groups = [], bool $json = false) : JsonResponse
    {
        $result = $this->serializer->serialize($data, $format, ['groups' => $groups]);

        return new JsonResponse($result, Response::HTTP_OK, [], $json);
    }
}