<?php
namespace Model\Service;

use Model\Entity\Accountverification;

class AccountVerificationService extends \Model\Service
{
	public function createCode($userId)
	{
		return md5($userId . '-' . time() . rand() );
	}
	
	public function saveCode($userId, $code)
	{
		$em = self::getEntityManager();
		
		$av = new AccountVerification();
		$av->setHash($code);
		$av->setUser($em->getReference('\Model\Entity\User', $userId) );
		
		$em->persist($av);
		$em->flush();
	}
	
	/**
	 * 
	 * @param mixed $userId
	 * 
	 * @return string account verification code
	 */
	public function getCodeFor($userId)
	{
		$em = self::getEntityManager();
		
		$av = $em->getRepository('\Model\Entity\Accountverification')->findBy(array('user' => $userId) );
		
		return count($av) == 1 ? $av[0]->getHash() : null;
	}
}