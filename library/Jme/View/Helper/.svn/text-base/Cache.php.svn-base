<?php

class Jme_View_Helper_Cache extends Zend_View_Helper_Abstract
{
    /**
     *
     * @param string $cacheName
     * @param boolean $strict if true then an exception is thrown if no cache object was found with the given cache name
     * @return Zend_Cache_Core 
     * @throws Zend_Cache_Exception
     */
    public function cache($cacheName, $strict = false)
    {
        $cacheHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('Cache');
        
        $cache = $cacheHelper->getCache($cacheName);
        
        if(!$cache)
        {
            if(!$strict)
            {
                $cache = new Jme_Cache_Null();
            }
            else
            {
                throw new Zend_Cache_Exception("No cache found with the name: $cacheName");
            }
            
        }
        
        return $cache;
    }
}