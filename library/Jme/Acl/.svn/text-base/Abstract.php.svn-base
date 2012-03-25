<?php


abstract class Jme_Acl_Abstract extends Zend_Acl 
{
	/**
	 * @var boolean
	 */
	private static $_throwExceptions = true;

    /**
     * @var boolean
     */
    private $_loaded = false;	
	
	/**
	 * Loads acl.
	 */
	protected abstract function _load();
	
	public function __construct()
	{
		
	}
	
	/**
	 * Control, whether an exception is thrown if a non-existing role or 
	 * resource is given. By default, an exeption is thrown.
	 * 
	 * @param boolean $state
	 */
	public static function setThrowException($state)
	{
		self::$_throwExceptions = (boolean)$state;
	}	
	
	/**
	 * @return boolean
	 */
	public static function throwsException()
	{
		return self::$_throwExceptions;
	}
	
	/**
	 * Override default implementation so that no exception is thrown
	 * if a non-existing role or resource is given.
	 * 
	 * @see Zend_Acl::isAllowed()
	 * 
	 * @return boolean
	 */
	public function isAllowed($role = null, $resource = null, $privilege = null)
	{
	    if(!$this->_loaded)
    	{
    		$this->_load();
    		$this->_loaded = true;
    	}
    	
		if(self::throwsException() )
		{
			return parent::isAllowed($role, $resource, $privilege);
		}
		
		if(null === $role && null === $resource)
		{
			return parent::isAllowed($role, $resource, $privilege);
		}
		else
		{
			if(null !== $role && !$this->hasRole($role) )
			{
				return false;
			}
			
			if(null !== $resource && !$this->has($resource) )
			{
				return false;
			}
			
			return parent::isAllowed($role, $resource, $privilege);
		}
	}	
}
