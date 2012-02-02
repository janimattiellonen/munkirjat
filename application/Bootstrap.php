<?php
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

    
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoloader()
    {
       // $this->bootstrap('modules');
        
        $autoloader = Zend_Loader_Autoloader::getInstance();
        
        Zend_Session::start();
    }
    
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');

        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath("Munkirjat/View/Helper", "Munkirjat_View_Helper");
        $view->addHelperPath("Jme/View/Helper", "Jme_View_Helper");
        
        // TODO: Update jQuery version and add to project.
        $view->jQuery()->setLocalPath($view->baseUrl('assets/js/jquery-1.6.1.min.js'))
                       ->setUiLocalPath($view->baseUrl('assets/js/jquery-ui-1.8.11.custom.min.js'))
                       ->enable()->uiEnable();

        $view->headLink()->appendStylesheet($view->baseUrl('assets/css/jquery-ui-1.8.11.custom.css'));
        
        $view->inlineScript()->appendFile($view->baseUrl('assets/js/munkirjat.js'));
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
	protected function _initDoctrine2()
	{
        $doctrineClassLoader = new Doctrine\Common\ClassLoader('Doctrine');
        //$doctrineClassLoader->setIncludePath(APPLICATION_PATH . '/../library');
        $doctrineAutoloader = array($doctrineClassLoader, 'loadClass');
        		
        $doctrineExtensionsClassLoader = new Doctrine\Common\ClassLoader('DoctrineExtensions');
        $doctrineExtensionsAutoloader = array($doctrineExtensionsClassLoader, 'loadClass');        
        
        $entityClassLoader = new Munkirjat_ClassLoader('Model');
        $entityClassLoader->setIncludePath(APPLICATION_PATH . '/models');
        $entityAutoloader = array($entityClassLoader, 'loadClass');	
		
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->pushAutoloader($doctrineAutoloader, 'Doctrine\\')
                   ->pushAutoloader($entityAutoloader, 'Model\\')
                   ->pushAutoloader($doctrineExtensionsAutoloader, 'DoctrineExtensions\\');
        
        $options      = $this->getOption('doctrine');
        $cacheOptions = $options['cache'];		
		
		$config = new Configuration;
		$driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/models/Entity');
		$config->setMetadataDriverImpl($driverImpl);
		$config->setProxyDir(APPLICATION_PATH . '/models/Proxy');
		$config->setProxyNamespace('Model\Proxy');
		$config->addCustomStringFunction('DATEDIFF', 'DoctrineExtensions\Query\Mysql\DateDiff');
		$config->addCustomStringFunction('MONTH', 'Jme\Query\Mysql\Month');
		$config->addCustomStringFunction('YEAR', 'Jme\Query\Mysql\Year');
		
		if (APPLICATION_ENV == "development") {
		    $config->setAutoGenerateProxyClasses(true);
		} else {
		    $config->setAutoGenerateProxyClasses(false);
		}
		
        if($cacheOptions['enabled'] == true)
        { 
            $config->setMetadataCacheImpl($this->_getDoctrineCache('metadataCache', $cacheOptions));
            $config->setQueryCacheImpl($this->_getDoctrineCache('queryCache', $cacheOptions));
            $config->setResultCacheImpl($this->_getDoctrineCache('resultCache', $cacheOptions));
            $config->setAutoGenerateProxyClasses((bool) $cacheOptions['autoGenerateProxyClasses']);            
        }

        $em = Doctrine\ORM\EntityManager::create($options['dbal'], $config);
        
		\Model\Service::setEntityManager($em);        
        
        return $em;
	}
	
    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();

        \Model\Service::setAuth($auth);

        return $auth;
    }  	
    
    protected function _initAcl()
    {
    	$acl = new \Munkirjat_Acl();
    	
    	$aclPlugin = new \Jme_Controller_Plugin_Acl($acl, \Munkirjat_Auth::getCurrentRole() );
    	
    	$front = Zend_Controller_Front::getInstance();
    	$front->registerPlugin($aclPlugin);
    	
    	Zend_Registry::set('Jme_Acl', $acl);
    	
    	$nav = $this->bootstrap('navigation')->getResource('navigation');

    	$view = $this->getResource('view');
    	
    	$role = \Munkirjat_Auth::getCurrentRole();
    	
    	$view->navigation($nav)->setAcl(Zend_Registry::get('Jme_Acl'))->setRole($role);
    }	    
}
