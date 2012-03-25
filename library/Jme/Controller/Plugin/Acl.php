<?php
class Jme_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract 
{
	
	/**
	* @var Zend_Acl
	**/
	protected $_acl;

	/**
	 * @var string
	 **/
	protected $_roleName;

	/**
	 * @var array
	 **/
	protected $_errorPage;

	/**
	 * Constructor
	 *
	 * @param Zend_Acl $acl
	 * @param string $role
	 * @return void
	 **/
	public function __construct(Zend_Acl $acl, $role)
	{
		$this->_errorPage = array(
			'module' => 'default', 
			'controller' => 'error', 
			'action' => 'not-found'
		);
		
		$this->setRole($role);
		$this->setAcl($acl);

	}

	/**
	 * Sets the ACL object
	 *
	 * @param mixed $aclData
	 * @return void
	 **/
	public function setAcl(Zend_Acl $aclData)
	{
		$this->_acl = $aclData;
	}
	
	/**
	 * Returns the ACL object
	 *
	 * @return Zend_Acl
	 **/
	public function getAcl()
	{
		return $this->_acl;
	}
	
	/**
	 * Sets the ACL role to use
	 *
	 * @param string $roleName
	 * @return void
	 **/
	public function setRole($role)
	{
		$this->_role = $role;
	}
	
	/**
	 * Returns the ACL role used
	 *
	 * @return string
	 * @author 
	 **/
	public function getRole()
	{
		return $this->_role;
	}
	
	/**
	 * Sets the error page
	 *
	 * @param string $action
	 * @param string $controller
	 * @param string $module
	 * @return void
	 **/
	public function setErrorPage($action = 'forbidden', $controller = 'error', $module = 'core')
	{
		$this->_errorPage = array(
			'module' => $module, 
			'controller' => $controller,
			'action' => $action
		);
	}
	
	/**
	 * Returns the error page
	 *
	 * @return array
	 **/
	public function getErrorPage()
	{
		return $this->_errorPage;
	}
	
	/**
	 * Predispatch
	 * Checks if the current user identified by roleName has rights to the requested url (module/controller/action)
	 * If not, it will call denyAccess to be redirected to errorPage
	 *
	 * @return void
	 **/
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$resourceName = $request->getModuleName() . '_' . $request->getControllerName();
		//echo $this->getRole() . ": " . $request->getActionName() . ": " . $resourceName;exit;
		try 
		{
			if (!$this->getAcl()->isAllowed($this->getRole(), $resourceName, $request->getActionName() ) ) 
			{
				$this->getResponse()->setHttpResponseCode(403);
				header('Location: /403');
				die;
			}
		} 
		catch(Exception $e) 
		{
			$this->denyAccess();
		}
	}
	
	/**
	 * Deny Access Function
	 * Redirects to errorPage, this can be called from an action using the action helper
	 *
	 * @return void
	 **/
	public function denyAccess()
	{
		$this->_request->setModuleName($this->_errorPage['module']);
		$this->_request->setControllerName($this->_errorPage['controller']);
		$this->_request->setActionName($this->_errorPage['action']);
	}
}
