<?php

class Munkirjat_Acl extends Jme_Acl_Abstract
{
	const GUEST = 'guest';
	
	/**
	 * @see App_Acl_Abstract::_load()
	 *
	 */
	protected function _load() 
	{
		$this->add(new Zend_Acl_Resource('admin_cache') );
		$this->add(new Zend_Acl_Resource('admin_beautifurl') );
		$this->add(new Zend_Acl_Resource('admin_lucene') );
		$this->add(new Zend_Acl_Resource('admin_doctrine') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_bookservice') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_book') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_tag') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_author') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_genre') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_type') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_statistics') );
        
        $this->add(new Zend_Acl_Resource('bookshelf_foo') );
		
		//$this->add(new Zend_Acl_Resource('user_account') );
		
		$this->add(new Zend_Acl_Resource('user_account') );
		
		$this->add(new Zend_Acl_Resource('bookshelf_error') );
		$this->add(new Zend_Acl_Resource('bookshelf_index') );
		
		$this->add(new Zend_Acl_Resource('403_index') );
		
		$admin = new Zend_Acl_Role('admin');
		$guest = new Zend_Acl_Role(self::GUEST);
		$registeredUser = new Zend_Acl_Role('registered_user');
		
		$this->addRole($guest);
		$this->addRole($admin, $guest);
		$this->addRole($registeredUser, $guest);
		
		$this->allow('admin', 'admin_cache', array('manage', 'clear') );
		$this->allow('admin', 'admin_beautifurl', array('manage', 'recreate') );
		$this->allow('admin', 'admin_lucene', array('manage', 'recreate') );
		$this->allow('admin', 'admin_doctrine', array('create') );
		
		$this->allow('admin', 'user_account', 'logout');
		$this->allow('guest', 'user_account', 'login');
		$this->deny('admin', 'user_account', 'login');
		
		$this->allow('guest', 'bookshelf_index', array('about', 'index') );
		
		$this->allow(null, 'bookshelf_error', 'error');
		$this->allow(null, 'bookshelf_error', array('not-found', 'denied') );
		
		$this->allow(null, '403_index', array('index', 'not-found') );
		
		$this->allow('guest', 'bookshelf_author', array('find', 'list') );
		
		$this->allow('admin', 'bookshelf_author', array('new', 'edit', 'save') );
		
		$this->allow('admin', 'bookshelf_genre', array('find', 'new', 'edit', 'save') );
		$this->allow('guest', 'bookshelf_genre', array('list') );
		
		$this->allow('admin', 'bookshelf_tag', array('find', 'new', 'edit', 'save') );
		$this->allow('guest', 'bookshelf_tag', array('latesttags', 'matchingtags') );
		
		$this->allow('guest', 'bookshelf_bookservice', array('index', 'post', 'put') );
		
		$this->allow('admin', 'bookshelf_book', array('save', 'new', 'edit', 'remove', 'rate-book', 'rate-unrated-book') );
	
		$this->allow('guest', 'bookshelf_book', array(	
			'addtofavourites',
			'advancedsearch', 
			'amazon', 
			'list', 
			'similarbooks',
			'view',
			'index',
			'about',
		) );
        
		$this->allow('guest', 'bookshelf_foo', array(	
			'bar',
			'baz', 
		) );
		
		$this->allow('admin', 'bookshelf_type', array('add', 'edit', 'remove') );
		$this->allow('guest', 'bookshelf_type', array('list', 'view') );
		
		$this->allow('guest', 'bookshelf_statistics', array('show', 'index') );
		
		$this->allow('guest', 'user_account', array('register') );
	}
}