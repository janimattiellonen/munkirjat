<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

class GenreRepository extends EntityRepository
{    
    
    public function getGenresByIds(array $ids = array() )
    {
        if(count($ids) == 0)
        {
            return null;
        }
        
        array_walk($ids, function(&$item) {$item = (int)$item;});
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('g')
            ->from('\Model\Entity\Genre', 'g')
            ->where('g.id IN (' . implode(',', $ids) . ')' );
        
        return $qb->getQuery()->getResult();
    }    
    
	public function searchByName($name)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('g')
        	->from('\Model\Entity\Genre', 'g');
		
		if(isset($name) )
		{
			$qb->where('g.name LIKE :name')
				->setParameter('name', $name . '%');
		}

        return $qb->getQuery()->getResult();
	}
	
	public function getGenres()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('g')
		    ->addSelect('SIZE(g.books) as amount')
        	->from('\Model\Entity\Genre', 'g');

        return $qb->getQuery()->getResult();
	}
}