<?php

class Bookshelf_Form_BookForm extends Jme_Form
{

    public function init()
    {
        $id = $this->createElement('hidden', 'id')
                ->addValidator('Int');
        
    	$title = $this->createElement('text', 'title')
    			->setLabel('Title')
    			->setRequired(true);
    	
    	$languages = array(
		                'fi' => 'Finnish',
		                'se' => 'Swedish',
		                'en' => 'English',
        );		
    			
    	$language = $this->createElement('select', 'language')
		            ->setLabel('Language')
		            ->addValidator('InArray', false, array('haystack' => array('fi', 'en', 'se')) )
		            ->addMultiOptions($languages);	
    			
    	$authors = $this->createElement('text', 'authors')
    					->setLabel('Author(s)');
    						
    	$authorSelections = $this->createElement('multiselect', 'author_selections')
    	                    ->setAttrib('class', 'hidden')
    	                    ->addValidator('Int')
    	                    ->setRequired(true)
    	                    ->setRegisterInArrayValidator(false);
    	                    
    	$genres = $this->createElement('text', 'genres')
    	                ->addValidator('Int')
    					->setLabel('Genre(s)');	
    						
    	$genreSelections = $this->createElement('multiselect', 'genre_selections')
    	                    ->setAttrib('class', 'hidden')
    	                    //->removeValidator('InArray')
    	                    ->setRegisterInArrayValidator(false);
    			
    	$tags = $this->createElement('text', 'tags')
    					->setLabel('Tag(s)');
    						
    	$tagSelections = $this->createElement('multiselect', 'tag_selections')
    	                    ->setAttrib('class', 'hidden')
    	                    ->addValidator('Int')
    	                    ->setRequired(false)
    	                    ->setRegisterInArrayValidator(false);
    	                    
    	$pageCount = $this->createElement('text', 'page_count')
    			->setLabel('Page count')
    			->addValidator('int', true)
    			->addValidator('greaterThan', true, array('min' => 0) );	
    			
    	$isbn = $this->createElement('text', 'isbn')
    	        ->setLabel('Isbn')
    	        ->addValidator('Isbn');
    	        
        $isbn->addValidator(Jme_Validate_Doctrine_NoRecordExists::createValidator($isbn, '\Model\Entity\Book', 'isbn', array('id' => 'id') ), true);
    			
    	$isRead = $this->createElement('checkbox', 'is_read')
    			->setLabel('Is read');	
    			
    	$startedReading = $this->createDatePickerElement('started_reading', 'Started reading', 'Click the field to select date');
		$finishedReading = $this->createDatePickerElement('finished_reading', 'Finished reading', 'Click the field to select date');		
    			
        $submit = $this->createSubmitButton('submit', 'Save');
        $cancel = $this->createSubmitButton('cancel', 'Cancel');
        
        $this->addElements(array(
            $id,
        	$title,
        	$language,
            $authors,
            $authorSelections,
            $genres,
            $genreSelections,
            $tags,
            $tagSelections,
        	$pageCount,
        	$isbn,
        	$isRead,
        	$startedReading,
        	$finishedReading,
        	$submit,
        	$cancel,
        ) );
    }


}

