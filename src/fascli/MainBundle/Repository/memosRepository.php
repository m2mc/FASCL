<?php

namespace fascli\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * memosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class memosRepository extends EntityRepository
{
	public function toutmemos()
{
 
    $qb = $this->createQueryBuilder('m');
   $qb ->addOrderBy('m.id', "DESC");
   return $qb->getQuery()
            ->getResult();
}
}
