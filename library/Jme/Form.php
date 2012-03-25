<?php

class Jme_Form extends Zend_Form
{
	const SESSION_KEY = 'APP_FORM_SESSION_DATA'; 
	
	/**
	 * @var Zend_Session_Namespace
	 */
	private $_ns;
	
	/**
	 * @var array
	 */
	private $_arr;

	/**
	 * @var array
	 */
	protected $_options;

	/**
	 * @var array
	 */
	protected $_globalFilters;
	
	protected $_editMode = false;

	protected $_editId;
	
	public function __construct($options = null) 
	{
		$this->setFormOptions($options);
		
		$this->_arr = array();
		
		if(Zend_Registry::isRegistered('Zend_Translate') )
		{
			Zend_Form::setDefaultTranslator(Zend_Registry::get('Zend_Translate') );
		}
		
		$this->addPrefixPath("Jme_Form", "Jme/Form/");
		
	    $this->addElementPrefixPath('Jme_Form_Decorator',
								    'Jme/Form/Decorator/',
								    'decorator');		
	    
	    $this->_globalFilters = array(new Zend_Filter_StringTrim() );
	    
	    parent::__construct ($options);
	    
	    if(!isset($this->_ns) )
	    {
	    	$this->_initFormSession(self::SESSION_KEY);
	    }
	    
	   // $this->initDefaultDisplayGroupDecorators();
	}
	
	public function createButtonGroup($name, array $elements, array $options = array() )
	{
        $dg = new Zend_Form_DisplayGroup($name, $this->getPluginLoader(self::DECORATOR) );
        
        $dg->addElements($elements);
        
       	$dg->setDecorators(array(
       		'FormElements',
       		array('HtmlTag', array(	
       			'class'=> isset($options['class']) ? $options['class'] : 'button_display_group', 
       			'tag' => isset($options['tag']) ? $options['tag'] : 'div'
       		) ),
       	));
       	
       	$this->addDisplayGroups(array($dg) );   
	}
	
	
	public function setEditMode($state)
	{
		$this->_editMode = $state;
	}
	
	public function isEditMode()
	{
		return $this->_editMode;
	}
	
	public function setEditId($id)
	{
		$this->_editId = $id;
		
		$this->setEditMode(true);
	}
	
	public function getEditId()
	{
		return $this->_editId;
	}
	
	/**
	 * Starts a form specific session.
	 * 
	 * @param string $namespace should be unique to the current form to prevent clashes with existing
	 * session keys
	 */
	protected function _initFormSession($namespace)
	{
		$this->_ns = new Zend_Session_Namespace($namespace);
	}
	
	/**
	 * @return Zend_Locale|string|null
	 */
	public function getLocale()
	{
		return $this->getTranslator()->getLocale();
	}
	
	/**
	 * @return App_Auth
	 */
	public function getAuth()
	{
		return $this->_auth;
	}
	
	/**
	 * Adds a filter that will be used by all elements in the form (except hash).
	 * 
	 * @param Zend_Filter_Interface $filter
	 */
	public function addGlobalFilter(Zend_Filter_Interface $filter)
	{
		$this->_globalFilters[] = $filter;
	}
	
	/**
	 * Sets the global fitlers to be used by the form elements.
	 * 
	 * @param array $filters an array containing Zend_Filter_Interface objects
	 */
	public function setGlobalFilters(array $filters)
	{
		$this->_globalFilters = $filters;
	}
	
	/**
	 * @return array
	 */
	public function getGlobalFilters()
	{
		return $this->_globalFilters;
	}
	
	/**
	 * Applies the global filters to each element in the form.
	 */
	protected function _applyFilters()
	{
		$ignored = array(
			'hash',
		);
		
		$elements = $this->getElements();
		
		foreach($elements as &$element)
		{
			$type = $element->getType();
			
			if(!in_array($type, $ignored) )
			{
				$element->addFilters($this->getGlobalFilters() );
			}
		}
	}
	
	/**
	 * @see Zend_Form::addElement()
	 *
	 * @param string|Zend_Form_Element $element
	 * @param string $name
	 * @param array|Zend_Config $options
	 * @return Zend_Form
	 */
	public function addElement($element, $name = null, $options = null) 
	{
		
		parent::addElement($element, $name, $options);
	}	
	
	/**
	 * Same as Zend_Form::createElement but with the addition that the id is set to
	 * the value of the name (optionally).
	 * 
	 * @param string $type
	 * @param string $name
	 * @param array|Zend_Config $options
	 * @param boolean $setId (default = true)
	 * 
	 * @return Zend_Form_element
	 */
	public function createElement($type, $name, $options = null, $setId = true)
	{
		$element = parent::createElement($type, $name, $options);
		
		if($setId)
		{
			$element->setAttrib('id', $name);
		}
		
		return $element;
	}
	
	/**
	 * @param Zend_Form_Element $element
	 * @param int $min
	 * @param int $max
	 * 
	 * @return Zend_Form_Element
	 */
	public function setWidthValidator(Zend_Form_Element $element, $min = 0, $max = 0)
	{
		$element->addValidator(new Zend_Validate_StringLength(array('min' => $min, 'max' => $max) ) );
	}
	
	/**
	 * @param string $mark
	 * @param mixed $value
	 */
	public function setMark($mark, $value)
	{
		$this->_arr[$mark] = $value;
		$this->_ns->$mark = $value;
	}

	public function setFormOptions(array $options = null)
	{
		if($options == null)
		{
			$options = array();
		}
		
		$this->_options = $options;
	}

	/**
	 * @return array
	 */
	public function getFormOptions()
	{
		return $this->_options;
	}

	public function createSubmitButton($name = 'submit', $label = 'Submit')
	{
		return $this->createButton($name, $label);
	}
	
	public function createCancelButton($name = 'cancel', $label = 'Cancel')
	{
		return $this->createButton($name, $label);
	}	
	
	public function createNextButton($name = 'next', $label = 'Next')
	{
		return $this->createButton($name, $label);
	}
	
	public function createPreviousButton($name = 'previous', $label = 'Previous')
	{
		return $this->createButton($name, $label);
	}
	
	public function createButton($name, $label)
	{
		$button = new Jme_Form_Element_Submit($name); 
		$button->setLabel($label);
		
		return $button;
	}
	
	public function createDatePickerElement($name, $label, $description = null, $params = array() )
	{
		$defaultOptions = array('dateFormat' => 'd.m.yy');
		
		$params = array_merge($defaultOptions, $params);
		
		$element = new ZendX_JQuery_Form_Element_DatePicker($name, array('jQueryParams' => $params) );
		$element->setLabel($label);
		$element->addValidator(new Jme_Validate_Date()  );
		
		if($description != null)
		{
			$element->setDescription($description);
		}
		
		$element->addFilter(new Jme_Filter_Date() );

		return $element;
	}
	
	/**
	 * @param string $name
	 * @param string $label
	 * @param int $default (default = 1)
	 */
	public function createYesNoRadio($name, $label, $default = 1)
	{
		$element = $this->createElement('radio', $name);
		$element->setLabel($label);
		$element->addMultiOptions(array(1 => 'Yes', 0 => 'No') );
		$element->setValue($default);		
		return $element;
	}
	
	/**
	 * Adds an element after the specified element.
	 * 
	 * @param string|Zend_Form_Element
	 * @param Zend_Form_Element $newElement the element to be added
	 */
	public function addAfter($targetElement, Zend_Form_Element $newElement)
	{
		if(is_string($targetElement) )
		{
			$targetElement = $this->getElement($targetElement);	
		}
		
		$newElement->setOrder($targetElement->getOrder() + 1);
		
		$this->addElement($newElement);
	}
	
	/**
	 * Adds an element before the specified element.
	 * 
	 * @param string|Zend_Form_Element
	 * @param Zend_Form_Element $newElement the element to be added
	 */
	public function addBefore($targetElement, Zend_Form_Element $newElement)
	{
		if(is_string($targetElement) )
		{
			$targetElement = $this->getElement($targetElement);	
		}
		
		$newElement->setOrder($targetElement->getOrder() - 1);
		
		$this->addElement($newElement);
	}
	
	/**
	 * Stores a value in the form's own session namespace.
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function storeSessionValue($key, $value)
	{
		$this->_ns->$key = $value;
	}
	
	/**
	 * @param string $key
	 * 
	 * @return mixed|null
	 */
	public function getSessionValue($key)
	{
		if($this->isSessionValueSet($key) )
		{
			return $this->_ns->$key;
		}
	}
	
	public function isSessionValueSet($key)
	{
		return isset($this->_ns->$key);
	}
	
	public function clearSessionValue($key)
	{
		unset($this->_ns->$key);
	}
	
	public function clearAllSessionValues()
	{
		$this->_ns->unsetAll();
	}
	
	/**
	 * Populates the form from provided entity.
	 * 
	 * @param \Model\Entity $entity
	 */
	public function setValuesFromEntity(\Model\Entity $entity, array $replace = array() )
	{
	    $em = \Model\Service::getEntityManager();
        $cmf = $em->getMetadataFactory();
        $class = $cmf->getMetadataFor(get_class($entity));
        
		$filter = new \Zend_Filter_Word_UnderscoreToCamelCase();
		
		$values = array();
		
		foreach($this->getElements() as $element)
		{
		    $originalName = $element->getName();
		    $replacedName = null;
		    
		    if(isset($replace[$originalName]) )
		    {
		        $replacedName = $replace[$originalName];
		    }
		    
			$elementName = lcfirst($filter->filter($originalName) );
			
			if(method_exists($entity, $elementName))
			{
		        $methodName = $elementName;
			}
			else
			{
			    $methodName = 'get' . ucfirst($elementName);
			}
			
			if($entity->propertyExists($elementName) && method_exists($entity, $methodName) )
			{
			    $mapping = null;
                
			    if ($entity->propertyExists($elementName) ) 
                {
                    try 
                    {
                        $mapping = $class->getFieldMapping($elementName);
                    } 
                    catch (\Doctrine\ORM\Mapping\MappingException $e) {
                    }
                }
			    
				$value = $entity->$methodName();
				
				if($value != null)
				{
				    if($value instanceof \Model\Entity)
				    {
				        $value = $value->getId();
				    }
				    else if($value instanceof \Doctrine\Common\Collections\Collection)
				    {
				        $arr = array();
				        
				        foreach($value as $objEntity)
				        {
				            $arr[] = $objEntity->getId();
				        }
				        
				        $value = $arr;
				    }
    				if(is_object($value) )
    				{
        				if($value instanceof \DateTime)
        				{
        				    if($mapping && isset($mapping['type']) )
        				    {
        				        if($mapping['type'] == 'date')
        				        {
        				            $value = $value->format('Y-m-d');
        				        }
        				        else if($mapping['type'] == 'time')
        				        {
        				            $value = $value->format('H:i');
        				        }
        				        else
        				        {
        				            $value = $value->format('Y-m-d H:i');
        				        }
        				    }
        				}
    				}
			    }
			
			    $tmp = $replacedName != null ? $replacedName : $originalName;
			    
				$values[$tmp] = $value;
			}
		}
		
		$this->populate($values);
	}
	
	public function createButtonDisplayGroup(array $buttons, $name, array $options = array() )
	{
	    $this->addDisplayGroup($buttons, $name);
        
	    $tag = isset($options['tag']) ? (string)$options['tag'] : 'div';
	    
        $ht = new Zend_Form_Decorator_HtmlTag();
        $ht->setTag($tag);
        if(isset($options['class']) )
        {
        	$ht->setOption('class', (string)$options['class']);
        }
        
        $this->setDisplayGroupDecorators(array(
		    'FormElements',
		    $ht,
		));       
	}
}
