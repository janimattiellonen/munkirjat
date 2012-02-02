<?php
return array('resources' => array('navigation' => array('pages' => array(

    'frontpage' => array (
        'label' => 'Frontpage',
        'id' => 'frontpage',
        'route' => 'default',
    ),
    
    'bar' => array (
        'label' => 'Bar',
        'id' => 'bar',
        'route' => 'bar',
    ),
    
    'baz' => array (
        'label' => 'Baz',
        'id' => 'baz',
        'route' => 'baz',
    ),
    
    
    'about' => array (
        'label' => 'About',
        'id' => 'about',
        'route' => 'about',
    ),
    
    'new_book' => array (
        'label' => 'Add new book',
        'id' => 'new_book',
        'route' => 'default',
        'module' => 'bookshelf',
        'controller' => 'book',
        'action' => 'new',
        'resource' => 'bookshelf_book',
        'privilege' => 'new',
    ),
    
    'new_author' => array (
        'label' => 'Add new author',
        'id' => 'new_author',
        'route' => 'default',
        'module' => 'bookshelf',
        'controller' => 'author',
        'action' => 'new',
        'resource' => 'bookshelf_author',
        'privilege' => 'new',
    ),
    
    'new_genre' => array (
        'label' => 'Add new genre',
        'id' => 'new_genre',
        'route' => 'default',
        'module' => 'bookshelf',
        'controller' => 'genre',
        'action' => 'new',
        'resource' => 'bookshelf_genre',
        'privilege' => 'new',
    ),
    
    'list_genres' => array (
        'label' => 'List genres',
        'id' => 'list_genres',
        'route' => 'default',
        'module' => 'bookshelf',
        'controller' => 'genre',
        'action' => 'list',
        'resource' => 'bookshelf_genre',
        'privilege' => 'list',
    ),

    'statistics' => array (
        'label' => 'Statistics',
        'id' => 'statistics',
        'route' => 'statistics',
    ),    
    
    'login' => array (
        'label' => 'Login',
        'id' => 'login',
        'route' => 'login',
        'resource' => 'user_account',
        'privilege' => 'login',
    ),

    'logout' => array (
        'label' => 'Logout',
        'id' => 'logout',
        'route' => 'logout',
        'resource' => 'user_account',
        'privilege' => 'logout',
    ),    

),),), );
