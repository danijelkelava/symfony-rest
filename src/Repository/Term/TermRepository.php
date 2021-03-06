<?php

namespace App\Repository\Term;

use App\Entity\Term\Term;
use App\Repository\BaseRepository;

/**
 * @method Term|null find($id, $lockMode = null, $lockVersion = null)
 * @method Term|null findOneBy(array $criteria, array $orderBy = null)
 * @method Term[]    findAll()
 * @method Term[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TermRepository extends BaseRepository
{
    public const ENTITY_CLASS_NAME = Term::class;

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
		return $this->createQueryBuilder('term')
					->select('MAX(term.totalCount)')
					->getQuery()
            		->getSingleScalarResult();
	}
}
