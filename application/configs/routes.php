<?php

return array('resources' => array('router' => array('routes' => array(

    'plain' => array(
        'type' => 'Zend_Controller_Router_Route',
        'route' => '/',
        'defaults' => array(
            'module' => 'bookshelf',
    		'controller' => 'book',
            'action' => 'index'
        ),
    ),
    
    'bar' => array(
        'type' => 'Zend_Controller_Router_Route',
        'route' => '/bookshelf/foo/bar',
        'defaults' => array(
            'module' => 'bookshelf',
    		'controller' => 'foo',
            'action' => 'bar'
        ),
    ),
    
    
    'baz' => array(
        'type' => 'Zend_Controller_Router_Route',
        'route' => '/bookshelf/foo/baz',
        'defaults' => array(
            'module' => 'bookshelf',
    		'controller' => 'foo',
            'action' => 'baz'
        ),
    ),
        
    
    
	'default' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/:module/:controller/:action/*',
        'defaults' => array(
            'module' => 'bookshelf',
            'controller' => 'book',
            'action' => 'index',
        ),
    ), 

	'about' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/about',
        'defaults' => array(
            'module' => 'bookshelf',
            'controller' => 'book',
            'action' => 'about',
        ),
    ),    

	'statistics' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/statistics/*',
        'defaults' => array(
            'module' => 'bookshelf',
            'controller' => 'statistics',
            'action' => 'index',
        ),
    ),    
    
    'activate_account' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/user/account/activate/:username/:hash',
        'defaults' => array(
            'module' => 'user',
            'controller' => 'account',
            'action' => 'activate',
        ),
    ),  
    
    'login' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/login',
        'defaults' => array(
            'module' => 'user',
            'controller' => 'account',
            'action' => 'login',
        ),
    ),      

    'logout' => array(
    	'type' => 'Zend_Controller_Router_Route',
        'route' => '/logout',
        'defaults' => array(
            'module' => 'user',
            'controller' => 'account',
            'action' => 'logout',
        ),
    ),        

    '403' => array(
        'type' => 'Zend_Controller_Router_Route',
        'route' => '/403',
        'defaults' => array(
            'module' => 'bookshelf',
            'controller' => 'error',
            'action' => 'denied',
        ),
    ),
    
),),),);

    
