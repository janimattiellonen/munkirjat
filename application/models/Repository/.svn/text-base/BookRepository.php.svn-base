<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends BaseRepository
{
    
	public function getRecentlyReadBooks($diff = 183, $limit = 20)
	{
		$dateStr = date('Y-m-d H:i:s');
		
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$q = $qb->select('b')
			->from('\Model\Entity\Book', 'b')
			->where('b.isRead = 1')
			->where('b.finishedReading IS NOT NULL')
			->where('DATEDIFF(:date, b.finishedReading) <= :diff')
			->setParameter('date', $dateStr)
			->setparameter('diff', $diff)
			->orderBy('b.finishedReading', 'DESC')
			->setMaxResults($limit);
	
		return $qb->getQuery()->getResult();
	}    
	
	public function getUnreadBooks($limit = 20)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('b')
			->from('\Model\Entity\Book', 'b')
			->where('b.isRead != 1')
			->setMaxResults($limit);
	
		return $qb->getQuery()->getResult();
	}
	
	// (SELECT count(ab.author_id) FROM AuthorBook ab WHERE a.id = ab.author_id GROUP BY ab.author_id) amount
	
	public function findBooksByAuthor($authorIds)
	{
	    $qb = $this->getEntityManager()->createQueryBuilder();
	    
	    $qb->select('b')
		    ->addSelect('SIZE(a.books) as amount')
			->from('\Model\Entity\Book', 'b')
			->join('b.authors', 'a');
			
		$i = 0;	
		foreach((array)$authorIds as $authorId)
		{
		    $qb->orWhere('a.id = :author' . $i)
		        ->setParameter('author' . $i++, $authorId);
		}	
	    return $qb->getQuery()->getResult();
	}
	
	public function findBooksBy(array $params = array() )
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('b')
		    ->addSelect('SIZE(a.books) as amount')
			->from('\Model\Entity\Book', 'b')
			->leftJoin('b.authors', 'a');
	
		if(isset($params['read']) )
		{
		    $qb->andWhere('b.isRead = :read')
		        ->setParameter('read', $params['read']);
		}	
		
	    if(isset($params['rated']) )
		{
		    if($params['rated'] == 0)
		    {
    		    $qb->andWhere('b.rating = 0')
    		    ->andWhere('b.isRead = 1');
		    }
		    else
		    {
		        $qb->andWhere('b.rating != 0');
		    }
		}
			
		if(isset($params['search']) )
		{
		    $value = $params['search'];
		    
		    $qb->where('b.title LIKE :title')
		        ->setParameter('title', '%' . $value . '%');
		    
		    $parts = \Model\Service\AuthorService::splitName($value);
		    
		    if($parts)
		    {
		        if(count($parts) == 1)
		        {
        		    $qb->orWhere('a.firstname LIKE :firstname')
        				->setParameter('firstname', '%' . $parts[0] . '%')
        				->orWhere('a.lastname LIKE :lastname')
        				->setParameter('lastname', '%' . $parts[0] . '%');
		        }
		        else
		        {
        		    $qb->orWhere('a.firstname LIKE :firstname')
        				->setParameter('firstname', '%' . $parts[0] . '%')
        				->orWhere('a.lastname LIKE :lastname')
        				->setParameter('lastname', '%' . $parts[1] . '%');
		        }
		    }
		}
		
		$qb->orderBy('a.lastname, a.firstname, b.title');
	    
		//echo $qb->getQuery()->getSql();
		
		return $qb->getQuery()->getResult();
	}
	
	public function getOneUnratedBook()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('b')
			->from('\Model\Entity\Book', 'b')
			->where('b.rating = 0')
			->andWhere('b.isRead = 1')
			->setMaxResults(1);

		return $this->getSingleResult($qb);
	}
	
	/**
	 * @return \Model\Entity\Book
	 */
	public function getLatestReadBook()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('b')
			->from('\Model\Entity\Book', 'b')
			->where('b.isRead = 1')
			->orderBy('b.finishedReading', 'DESC')
			->setMaxResults(1);
	
		return $this->getSingleResult($qb);
	}
	
	/**
	 * @return \Model\Entity\Book
	 */
	public function getLatestAddedBook()
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		
		$qb->select('b')
			->from('\Model\Entity\Book', 'b')
			->orderBy('b.created', 'DESC')
			->setMaxResults(1);
	
		return $this->getSingleResult($qb);
	}	
}