<?php
class Jme_Validate_Doctrine_NoRecordExists extends Zend_Validate_Abstract
{
	const ERROR_RECORD_FOUND = 'recordFound';
	
	/**
	 * @var array
	 */
	protected $_messageTemplates = array(
		self::ERROR_RECORD_FOUND => 'A record matching %value% was found',
	);
	
	/**
	 * @var string
	 */
	protected $_entityClass;
	
	/**
	 * @var string
	 */
	protected $_field;
	
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $_em;
	
	/**
	 * @var array
	 */
	protected $_exclude;
	
	/**
	 * Enter description here ...
	 * @param unknown_type $entityClass
	 * @param unknown_type $field
	 * @param array $exclude
	 */
	public function __construct($entityClass, $field, array $exclude)
	{
		$this->_entityClass = $entityClass;
		$this->_field = $field;
		$this->_exclude = $exclude;
		$this->_em = \Model\Service::getEntityManager();
	}
	
	/**
	 * @see Zend/Validate/Zend_Validate_Interface::isValid()
	 */
	public function isValid($value)
	{
		$this->_setValue($value);
		
		$results = $this->_query();

		$isValid = true;
				
		if($results)
		{
			$isValid = false;
			$this->_error(self::ERROR_RECORD_FOUND);
		}
		
		return $isValid;
	}
	
	/**
	 * @see Zend/Validate/Db/Zend_Validate_Db_Abstract::_query()
	 * 
	 * @return array
	 */
	protected function _query()
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select('x')
			->from($this->_entityClass, 'x')
			->where('x.'. $this->_field . ' = :field')
			->setParameter('field', $this->_value);
			
		foreach($this->_exclude as $name => $value)
		{
			$paramName = "exclude_$name";
			
			$qb->andWhere("x.$name != :" . $paramName)
				->setParameter($paramName, $value);
		}	
		
		return $qb->getQuery()->getResult();
	}
	
    /**
     * 
     * @param Zend_Form_Element $element
     * @param string $entityClass
     * @param string $fields
     * @param array $exclude
     * 
     * @return \Zend_Validate_Abstract
     */
    public static function createValidator(Zend_Form_Element $element, $entityClass, $field, array $exclude = array() )
    {
    	return new Zend_Validate_Callback(function($value, $context) use ($element, $entityClass, $field, $exclude)
   		{
    		$validator = new Jme_Validate_Doctrine_NoRecordExists(
    			$entityClass, 
    			$field,
    			array_map(function($field) use ($context) { return $context[$field]; }, $exclude) 
    		);
    		
    		$isValid = $validator->isValid($value);
    		$element->addErrorMessages($validator->getMessages() );
    		
    		return $isValid;
    	});
    }	
}
