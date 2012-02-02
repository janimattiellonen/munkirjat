<?php

class Bookshelf_Form_SimpleBookSearchForm extends Jme_Form 
{
	public function init()
	{
		$this->setMethod(Zend_Form::METHOD_GET);
		$this->setAction($this->getView()->baseUrl() . '/bookshelf/book/list');
		
		$name = $this->createElement('text', 'search');
		//$name->setLabel('Search');
		$name->addValidator(new Zend_Validate_StringLength(array('min' => 2, 'max' => 128) ) );
		$name->setRequired(false);
		
		$submit = $this->createSubmitButton();
		
		$this->addElement($name);		
		$this->addElement($submit);
		
		$this->_applyFilters();		
	}
}