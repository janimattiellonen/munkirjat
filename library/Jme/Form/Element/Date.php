<?php


class Jme_Form_Element_Date extends Zend_Form_Element 
{
	public function __construct($spec, $options = null) 
	{
		parent::__construct ( $spec, $options);
	}
	
	public function setValue($value)
	{
		$value = date('d.m.Y', strtotime($value) );
		
		parent::setValue($value);
	}
}

?>
