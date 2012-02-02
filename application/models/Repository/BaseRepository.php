<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
	/**
	 * @return \Model\Entity|null
	 */
	public function getSingleResult(\Doctrine\ORM\QueryBuilder $qb)
	{
		try
		{	
			return $qb->getQuery()->getSingleResult();	
		}
		catch(\Doctrine\ORM\NoResultException $nre)
		{
			return null;
		}
	}
}