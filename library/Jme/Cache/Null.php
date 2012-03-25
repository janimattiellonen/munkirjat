<?php
/**
 * Null cache.
 *
 * @author jme
 */
class Jme_Cache_Null extends Zend_Cache_Core
{
    public function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
    {
        return null;
    }
    
    public function save($data, $id = null, $tags = array(), $specificLifetime = false, $priority = 8)
    {
        
    }
}