<?php

/**
 * Converts 1 and true to Yes and other values to no
 */
class Jme_Filter_YesNo implements Zend_Filter_Interface 
{
	private $_yesValue;
	private $_noValue;
	
	public function __construct()
	{
		$this->_yesValue = 'Yes';
		$this->_noValue = 'No';	
	}
	
	/**
	 * @param string $value
	 * 
	 * @return string 
	 */
	public function filter($value) 
	{
		if(is_bool($value) )
		{
			return (boolean)$value === true ? $this->_yesValue : $this->_noValue;
		}
		else if((int)$value === 1 || strtolower($value) == 'true')
		{
			return $this->_yesValue;
		}
		else 
		{
			return $this->_noValue;
		}
	}
}
