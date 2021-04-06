<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseRepository extends EntityRepository implements ServiceEntityRepositoryInterface
{
    public const ENTITY_CLASS_NAME = '';

    public function __construct(EntityManagerInterface $entityManager, ?ClassMetadata $metadata = null, ?ManagerRegistry $registry = null)
    {
        if (static::ENTITY_CLASS_NAME === '') {
            throw new \RuntimeException('Repository entity class name is empty');
        }

        if ($registry) {
            /** @var EntityManager $manager */
            $manager = $registry->getManagerForClass($this::ENTITY_CLASS_NAME);

            parent::__construct($manager, $manager->getClassMetadata($this::ENTITY_CLASS_NAME));
        } elseif ($entityManager instanceof EntityManager && $metadata instanceof ClassMetadata) {
            parent::__construct($entityManager, $metadata);
        } else {
            throw new \RuntimeException('Failed to initialize repository.');
        }
    }

    public function save(EntityInterface $entity, bool $flush = true): EntityInterface
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function merge(EntityInterface $entity, bool $flush = true): EntityInterface
    {
        /** @var EntityInterface $entity */
        $entity = $this->_em->merge($entity);
        if ($flush) {
            $this->_em->flush();
            $this->_em->refresh($entity);
        }

        return $entity;
    }

    public function flush(EntityInterface $entity = null): void
    {
        $this->_em->flush($entity);
    }

    public function remove(EntityInterface $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findOr404(int $id): EntityInterface
    {
        /** @var EntityInterface|null $entity */
        $entity = $this->find($id);

        if (null === $entity) {
            $message = sprintf('Resource of type %s and ID %s could not be found!', $this::ENTITY_CLASS_NAME, $id);
            throw new NotFoundHttpException($message, null, Response::HTTP_NOT_FOUND);
        }

        return $entity;
    }
}
