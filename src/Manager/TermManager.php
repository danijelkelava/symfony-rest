<?php 

namespace App\Manager;

use App\Entity\Term\Term;
use App\Entity\EntityInterface;
use App\Repository\Term\TermRepository;
use App\Factory\EntityFactory;

final class TermManager 
{

    /**
     * @var TermRepository
     */
	private TermRepository $repository;

    /**
     * @var EntityFactory
     */
	private EntityFactory $entityFactory;

	public function __construct(
        TermRepository $repository, 
        EntityFactory $entityFactory
	)
	{
        $this->repository = $repository;
        $this->entityFactory = $entityFactory;
	}

	/**
	 * Create term entity from json
	 *
	 * @param string $json
	 * @param array $groups
	 * @return Term $term
	 */
	public function createFromJson(string $json, array $groups = []) : EntityInterface
	{
		$term = $this->entityFactory->createFromJson($json, Term::class, $groups);

		return $term;
	}

	/**
	 * Saves term
	 *
	 * @param Term $term
	 * @return Term $term
	 */
	public function save(Term $term) : EntityInterface
	{
		return $this->repository->save($term);
	}

	/**
	 * Updates term
	 *
	 * @param Term $term
	 * @return Term $term
	 */
	public function update(Term $term) : EntityInterface
	{
		return $this->repository->merge($term);
	}

	/**
	 * Set score
	 *
	 * @param Term $term
	 * @return Term 
	 */
	public function setScore(Term $term) : Term
	{
		$totalCount = $term->getTotalCount();
		$maxTotalCount = $this->getMaxTotalCount();

		$score = $this->calculateScore($totalCount, $maxTotalCount);
		
        $term->setScore(number_format($score, 2));

        return $term;		
	}

	/**
	 * Calculate score
	 *
	 * @param int $totalCount
	 * @return float
	 */
	public function calculateScore(int $totalCount, ?int $maxTotalCount) : float
	{
		$maxCount = $totalCount > $maxTotalCount ? $totalCount : $maxTotalCount;

		return ($totalCount/$maxCount) * 10;
	}

	/**
	 * Find term by criteria
	 *
	 * @param array $criteria
	 * @return Term|null
	 */	
	public function findTermByCriteria(array $criteria) : ?Term
	{
		return $this->repository->findOneBy($criteria);
	}

	public function getMaxTotalCount() : ?int
	{
		return $this->repository->getMaxTotalCount();
	}
}