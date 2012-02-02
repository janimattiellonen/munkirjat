<?php

namespace Model;

use \Doctrine\ORM\EntityManager;

class Service
{
    /**
     * Doctrine entity manager.
     * 
     * @var EntityManager
     */
    protected static $em;
    
    /**
     * @var Zend_Acl
     */
    protected static $acl;
    
    /**
     * @var \Zend_Auth
     */
    protected static $auth;
    
    /**
     * @var Zend_Config
     */
    protected static $config;
    
    public static function setEntityManager(EntityManager $em)
    {
        self::$em = $em;
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager()
    {
        return self::$em;
    }
    
    /**
     * 
     * @param Zend_Acl $acl
     */
    public static function setAcl($acl)
    {
        self::$acl = $acl;
    }
    
    /**
     * @return Zend_Acl
     */
    public static function getAcl()
    {
        return self::$acl;
    }
    
    /**
     * 
     * @param Zend_Auth $auth
     */
    public static function setAuth($auth)
    {
        self::$auth = $auth;
    }
    
    /**
     * @return Zend_Auth
     */
    public static function getAuth()
    {
        return self::$auth;
    }    
    
    /**
     * @param \Zend_Config $config
     */
    public static function setConfig(\Zend_Config $config)
    {
    	self::$config = $config;
    }
    
    /**
     * @return \Zend_Config
     */
    public static function getConfig()
    {
    	return self::$config;
    }
}