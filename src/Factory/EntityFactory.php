<?php

namespace App\Factory;

use App\Entity\EntityInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class EntityFactory
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * EntityFactory constructor.
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    public function createFromJson(string $data, string $class, array $groups = [], array $context = []): EntityInterface
    {
        return $this->create($data, $class, 'json', $groups, $context);
    }

    private function create($data, string $class, string $format, array $groups = [], array $context = []): EntityInterface
    {
        if (\count($groups)) {
            $context['groups'] = $groups;
        }

        /** @var EntityInterface $entity */
        $entity = $this->serializer->deserialize($data, $class, $format, $context);

        return $entity;
    }
}
