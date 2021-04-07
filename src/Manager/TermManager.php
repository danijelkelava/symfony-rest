<?php 

namespace App\Manager;

use App\Entity\Term\Term;
use App\Repository\Term\TermRepository;
use App\Factory\EntityFactory;

class TermManager 
{

    /**
     * @var TermRepository
     */
	private $repository;

    /**
     * @var EntityFactory
     */
	private $entityFactory;

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
	public function createFromJson(string $json, array $groups = []) : Term
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
	public function save(Term $term) : Term
	{
		return $this->repository->save($term);
	}

	/**
	 * Updates term
	 *
	 * @param Term $term
	 * @return Term $term
	 */
	public function update(Term $term) : Term
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
        $term->setScore($this->calculateScore($term->getTotalCount()));

        return $term;		
	}

	/**
	 * Calculate score
	 *
	 * @param int $totalCount
	 * @return float
	 */
	public function calculateScore(int $totalCount) : float
	{
		$maxCount = $totalCount > $this->getMaxTotalCount() ? $totalCount : $this->getMaxTotalCount();
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

    /**
     * Gets the max total count of all terms.
     *
     *
     * @return mixed The scalar result.
     *
     * @throws NoResultException        If the query returned no result.
     * @throws NonUniqueResultException If the query result is not unique.
     */
	public function getMaxTotalCount()
	{
		return $this->repository->createQueryBuilder('term')
					->select('MAX(term.totalCount)')
					->getQuery()
            		->getSingleScalarResult();
	}

}