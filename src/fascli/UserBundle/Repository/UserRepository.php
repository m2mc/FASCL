<?php

namespace fascli\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
	public function userNomPrenoms()
{

 $nom = $this->get('security.context')->getToken()->getUser()->getNom();
 $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
 $user = '$nom $prenoms';
   return $user;
}
}
