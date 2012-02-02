<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

class AuthorRepository extends EntityRepository
{
    public function getFavouriteAuthors($minBooks = 3, $limit = 20)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        
        $qb->select('a, count(b.id) as amount')
                ->from('\Model\Entity\Author', 'a')
                ->leftJoin('a.books', 'b')
                ->setMaxResults($limit)
                ->groupBy('a.id')
                ->orderBy('amount', 'DESC')
                ->having('count(b.id) >= :min')
                ->setParameter('min', $minBooks);

        return $qb->getQuery()->getResult();
    }
    /*
    		$q = $this->createQuery()
				->select('COUNT(*) as amount')
				->addSelect('a.id, a.firstname, a.lastname')
				->from('Author a')
				->leftJoin('a.AuthorBook ab')
				->groupBy('ab.author_id')
				->orderBy('amount DESC')
				->having('amount >= ?', $minimumBookCount);
    */
    
    public function getAuthorsByIds(array $ids = array() )
    {
        if(count($ids) == 0)
        {
            return null;
        }
        
        array_walk($ids, function(&$item) {$item = (int)$item;});
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
            ->from('\Model\Entity\Author', 'a')
            ->where('a.id IN (' . implode(',', $ids) . ')' );
        
        return $qb->getQuery()->getResult();
    }
    
	public function searchByName($firstname = null, $lastname = null)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('a')
        	->from('\Model\Entity\Author', 'a');
		
		if(isset($firstname) && isset($lastname) )
		{
			$qb->where('a.firstname LIKE :firstname')
				->setParameter('firstname', $firstname . '%')
				->andWhere('a.lastname LIKE :lastname')
				->setParameter('lastname', $lastname . '%');
		}
		else if(isset($firstname) || isset($lastname) )
		{
			$name = isset($firstname) ? $firstname : $lastname;
			
			$qb->where('a.firstname LIKE :name')
				->orWhere('a.lastname LIKE :name')
				->setParameter('name', $name . '%');			
		}

        return $qb->getQuery()->getResult();
	}
}