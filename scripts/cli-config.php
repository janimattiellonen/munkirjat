<?php

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', realpath(__DIR__ . '/../library'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', realpath(__DIR__ . '/../library'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', realpath(__DIR__ . '/../library'));
$classLoader->register();
//$classLoader = new \Doctrine\Common\ClassLoader('\Symfony', realpath(__DIR__ . '/../external/doctrine2-orm/lib/vendor'));
//$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Entity', realpath(__DIR__ . '/../application/models') );
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxy', realpath(__DIR__ . '/../application/models') );
$classLoader->register();


//$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$em = \Model\Service::getEntityManager(); 

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);