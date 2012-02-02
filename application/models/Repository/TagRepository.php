<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

class TagRepository extends EntityRepository
{    
    
    public function getTagsByIds(array $ids = array() )
    {
        if(count($ids) == 0)
        {
            return null;
        }
        
        array_walk($ids, function(&$item) {$item = (int)$item;});
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('\Model\Entity\Tag', 't')
            ->where('t.id IN (' . implode(',', $ids) . ')' );
        
        return $qb->getQuery()->getResult();
    }    
    
	public function searchByName($name)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('t')
        	->from('\Model\Entity\Tag', 't');
		
		if(isset($name) )
		{
			$qb->where('t.name LIKE :name')
				->setParameter('name', $name . '%');
		}

        return $qb->getQuery()->getResult();
	}
	
	public function getTags()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('g')
		    ->addSelect('SIZE(g.books) as amount')
        	->from('\Model\Entity\Tag', 't');

        return $qb->getQuery()->getResult();
	}
}