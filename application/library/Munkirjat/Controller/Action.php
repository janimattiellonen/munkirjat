<?php
class Munkirjat_Controller_Action extends Zend_Controller_Action
{
    public function init()
    {
    	parent::init();
        
        $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
    }
    	
	/**
	 * @return Munkirjat_Model
	 */
    public function getModel()
    {
        $modelName = $this->_getModelClassName();
        
        if (!class_exists($modelName) ) 
        {
            return null;
        }
        
        return new $modelName();
    }
	
    protected function _isCancelled()
    {
    	$cancel = $this->_request->getPost('cancel');
    	
    	return isset($cancel);
    }
    
    protected function _getModelClassName()
    {
        $camelCaser     = new Zend_Filter_Word_DashToCamelCase();
        
        $request        = $this->getRequest();
        $dispatcher     = $this->getFrontController()->getDispatcher();
        $moduleName     = $dispatcher->formatModuleName($request->getModuleName());
        $controllerName = $camelCaser->filter($request->getControllerName());
        
        return "{$moduleName}_Model_{$controllerName}Model";
    }
	
    protected function _getFormClassName()
    {
        $camelCaser     = new Zend_Filter_Word_DashToCamelCase();
        
        $request        = $this->getRequest();
        $dispatcher     = $this->getFrontController()->getDispatcher();
        $moduleName     = $dispatcher->formatModuleName($request->getModuleName());
        $controllerName = $camelCaser->filter($request->getControllerName());
        
        return "{$moduleName}_Form_{$controllerName}Form";
    }
	
	/**
	 * @return Zend_Form
	 */
	public function getForm()
	{
        $formName = $this->_getFormClassName();
        
        if (!class_exists($formName) ) 
        {
            return null;
        }
        
        return new $formName();
	}
	
	/**
	 * Convenience method for obtaining a unique identifier for the given GET|POST parameters.
	 * 
	 * @param array $params
	 * 
	 * @return string unique identifier
	 */
	protected function _getRequestIdentifier(array $params)
	{
		return \Jme\Request::createIdentifierFromRequest($params);
	}
    
    /**
     * @return Zend_Cache_Manager
     */
    protected function getCache($name)
    {
        return Zend_Registry::get('cachemanager')->getCache($name);
    }
}