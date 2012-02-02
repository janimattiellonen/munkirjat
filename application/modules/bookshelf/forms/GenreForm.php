<?php

class Bookshelf_Form_GenreForm extends Jme_Form
{

    public function init()
    {
        $id = $this->createElement('hidden', 'id')
                ->addValidator('Int');
                        
    	$name = $this->createElement('text', 'name')
    	            ->setLabel('Name')
    	            ->addValidator('StringLength', true, array('min' => 1, 'max' => 45) )
    	            ->setRequired(true);

        $name->addValidator(Jme_Validate_Doctrine_NoRecordExists::createValidator($name, '\Model\Entity\Genre', 'name', array('id' => 'id') ), true);
    	            
    	            
    	            
        $submit = $this->createSubmitButton('submit', 'Save');
        $cancel = $this->createSubmitButton('cancel', 'Cancel');
    	
        $this->addElements(array(
            $id,
        	$name,
        	$submit,
        	$cancel,
        ) );
    }
}