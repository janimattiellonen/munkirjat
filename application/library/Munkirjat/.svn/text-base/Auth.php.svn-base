<?php

class Munkirjat_Auth extends \Model\Service
{
	const GUEST = 'guest';
	const REGISTERED_USER = 'registered_user';
	const ADMIN = 'admin';

	/**
	 * @var \Model\Entity\User
	 */
	private static $_user;
	
	/**
	 * @return \Model\Entity\User
	 */
	public static function getCurrentUser()
	{
		if(!isset(self::$_user) )
		{
			if(self::isLoggedIn() )
			{
				$identity = self::getAuth()->getIdentity();
				
				$userRepo = self::getEntityManager()->getRepository('\Model\Entity\User');
				$user = $userRepo->find($identity['user_id']);
				self::$_user = $user;
			}	
		}
		
		return self::$_user;
	}
	
	/**
	 * @return boolean
	 */
	public static function hasIdentity()
	{
		return self::getAuth()->hasIdentity();
	}
	
	/**
	 * @return boolean
	 */
	public static function isLoggedIn()
	{
		return self::hasIdentity();
	}
	
	/**
	 * @return string|Zend_Acl_Role
	 */
	public static function getCurrentRole()
	{
	    //        Zend_Auth::getInstance()->clearIdentity(); 
	    
    	if(self::getAuth()->hasIdentity() )
    	{
    		return self::getCurrentUser()->getRole();
    	}
		
    	return self::GUEST;
	}
	
	/**
	 * @return boolean
	 */
	public static function isAdmin()
	{
		return self::getCurrentRole() === self::ADMIN;
	}
}