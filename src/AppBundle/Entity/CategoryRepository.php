<?php

namespace AppBundle\Entity;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function findThem($id = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.id', 'DESC');
        if(null !== $id) {
            $qb->where('c.id = :id')
                ->setParameters([
                    ':id' => $id,
                ]);
        }
        return null === $id
            ? $qb->getQuery()->getArrayResult()
            : $qb->getQuery()->getSingleResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
