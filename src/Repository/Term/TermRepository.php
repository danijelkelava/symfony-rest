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
class TermRepository extends BaseRepository
{
    public const ENTITY_CLASS_NAME = Term::class;
}
