<?php

class Bookshelf_Form_AuthorForm extends Jme_Form
{

    public function init()
    {
        $id = $this->createElement('hidden', 'id')
                ->addValidator('Int');
                        
    	$firstname = $this->createElement('text', 'firstname')
    	            ->setLabel('First name')
    	            ->addValidator('StringLength', true, array('min' => 1, 'max' => 45) )
    	            ->setRequired(true);

    	$lastname = $this->createElement('text', 'lastname')
    	            ->setLabel('Last name')
    	            ->addValidator('StringLength', true, array('min' => 1, 'max' => 45) )
    	            ->setRequired(true);	            
    	            
        $submit = $this->createSubmitButton('submit', 'Save');
        $cancel = $this->createSubmitButton('cancel', 'Cancel');
    	
        $this->addElements(array(
            $id,
        	$firstname,
        	$lastname,
        	$submit,
        	$cancel,
        ) );
    }
}