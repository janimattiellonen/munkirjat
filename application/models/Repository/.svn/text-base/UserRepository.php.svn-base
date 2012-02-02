<?php

namespace Model\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository
{
	public function usernameAvailable($username, array $exclude = array() )
	{
		return $this->isAvailable($username, 'username', '\Model\Entity\User', $exclude);
	}	

	public function emailAddressAvailable($emailAddress, array $exclude = array() )
	{
		return $this->isAvailable($emailAddress, 'email', '\Model\Entity\User', $exclude);
	}		
	
	public function isAvailable($value, $field, $entityClass, array $exclude = array() )
	{
		$qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('x')
        	->from($entityClass, 'x')
           	->where("x.$field = :field_$field")
           	->setParameter("field_$field", $value);

        foreach($exclude as $key => $value)
        {
        	$paramName = "field_$key";
        	
        	$qb->andWhere("x.$key != :$paramName")
        		->setParameter($paramName, $value);
        }   	
           	
        try
        {
        	$qb->getQuery()->getSingleResult();
        	return false;
        }
        catch(NoResultException $e)
        {
        	return true;
        }	
	}
}