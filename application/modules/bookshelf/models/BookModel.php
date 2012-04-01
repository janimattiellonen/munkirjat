<?php

class Bookshelf_Model_BookModel extends \Munkirjat\Model
{
	protected $_entityClassName = '\Model\Entity\Book';
	
	/**
	 * 
	 * @param Bookshelf_Form_BookForm $form
	 * @return \Model\Entity\Book
	 */
	public function save(Bookshelf_Form_BookForm $form)
	{
		$book = $this->findOrCreate($form->getValue('id') );
		    
		$book->fromArray($book->getEntityValues($form), array('authors', 'genres', 'tags') );
        
        if(!$book->isRead() )
        {
            $book->setIsRead(0);
        }
        
		$authors = $form->getValue('author_selections');
		
		if(is_array($authors) )
		{
		    $this->_addAuthors($book, $authors);
		}
		
		$genres = $form->getValue('genre_selections');
		
		if(is_array($genres))
		{
		    $this->_addGenres($book, $genres);
		}		
		
		$tags = $form->getValue('tag_selections');
		
		if(is_array($tags))
		{
		    $this->_addTags($book, $tags);
		}		
		
		$this->_save($book);
		
		return $book;
	}
	
	public function rateBook($bookId, $score)
	{
	    $book = $this->find($bookId);

	    if(!$book)
	    {
	        return false;
	    }
	    
	    $book->setRating($score);
	    $this->_save($book);
	    
	    return true;
	}
	
	public function populateCustom(Bookshelf_Form_BookForm $form)
	{
        $this->populateAuthors($form);
        $this->populateGenres($form);
        $this->populateTags($form);
	}
	
	public function populateAuthors(Bookshelf_Form_BookForm $form)
	{
        $authorRepository = $this->_getEntityRepository('\Model\Entity\Author');	    
	    $as = $form->getValue('author_selections');
	    
	    if(is_array($as) )
    	{
    	    $authors = $authorRepository->getAuthorsByIds($as);
    	    
    	    if(is_array($authors) )
    	    {
        	    foreach($authors as $author)
        	    {
        	        $form->getElement('author_selections')->addMultiOption($author->getId(), $author->getFullname() );
        	    }
    	    }
    	}
	}
	
	public function populateGenres(Bookshelf_Form_BookForm $form)
	{
	    $genreRepository = $this->_getEntityRepository('\Model\Entity\Genre');
	    
	    $gs = $form->getValue('genre_selections');
	    
	    if(is_array($gs) )
	    {
    	    $genres = $genreRepository->getGenresByIds($gs);
    	    
    	    if(is_array($genres) )
    	    {
        	    foreach($genres as $genre)
        	    {
        	        $form->getElement('genre_selections')->addMultiOption($genre->getId(), $genre->getName() );
        	    }
    	    }
	    }	
	}

	public function populateTags(Bookshelf_Form_BookForm $form)
	{
	    $tagRepository = $this->_getEntityRepository('\Model\Entity\Tag');
	    
	    $ts = $form->getValue('tag_selections');
	    
	    if(is_array($ts) )
	    {
    	    $tags = $tagRepository->getTagsByIds($ts);
    	    
    	    if(is_array($tags) )
    	    {
        	    foreach($tags as $tag)
        	    {
        	        $form->getElement('tag_selections')->addMultiOption($tag->getId(), $tag->getName() );
        	    }
    	    }
	    }	   
	}	
	
	public function getBookForEdit($bookId, Bookshelf_Form_BookForm $form)
	{
	    $book = $this->find($bookId);
	    
	    if(!$book)
	    {
	        return null;
	    }
	    
	    $form->setValuesFromEntity($book, array('authors' => 'author_selections', 'genres' => 'genre_selections', 'tags' => 'tag_selections') );
	    
	    $this->populateCustom($form);
	    
	    return $book;
	}
	
	protected function _addAuthors(\Model\Entity\Book $book, array $authors = array() )
	{
	    $book->removeAuthors();
	    
	    foreach($authors as $authorId)
	    {
	        $author = $this->getEntityManager()->getReference('\Model\Entity\Author', $authorId);
	        $book->addAuthor($author);
	    }
	}
	
	public function getRecentlyReadBooks($diff = 183, $limit = 20)
	{
	    return $this->_getEntityRepository()->getRecentlyReadBooks($diff, $limit);
	}
	
	public function getUnreadBooks($limit = 20)
	{
	    return $this->_getEntityRepository()->getUnreadBooks($limit);
	}
	
	public function getOneUnratedBook()
	{
	    return $this->_getEntityRepository()->getOneUnratedBook();
	}
	
    public function search(array $params = array() )
    {
        if(isset($params['author']) )
        {
            if(strpos($params['author'], ',') !== false)
            {
                $params['author'] = explode(',', $params['author']);
            }
            
            return $this->_getEntityRepository()->findBooksByAuthor($params['author']);
        }
        else
        {
            return $this->_getEntityRepository()->findBooksBy($params);
        }
    }
    
	/**
	 * @return \Model\Entity\Book
	 */    
    public function getLatestReadBook()
    {
        return $this->_getEntityRepository()->getLatestReadBook();
    }

	/**
	 * @return \Model\Entity\Book
	 */    
    public function getLatestAddedBook()
    {
        return $this->_getEntityRepository()->getLatestAddedBook();
    }    
    
	protected function _addGenres(\Model\Entity\Book $book, array $genres = array() )
	{
	    $book->removeGenres();
	    
	    foreach($genres as $genreId)
	    {
	        $genre = $this->getEntityManager()->getReference('\Model\Entity\Genre', $genreId);
	        $book->addGenre($genre);
	    }
	}	
	
	protected function _addTags(\Model\Entity\Book $book, array $tags = array() )
	{
	    $book->removeTags();
	    
	    foreach($tags as $tagId)
	    {
	        $tag = $this->getEntityManager()->getReference('\Model\Entity\Tag', $tagId);
	        $book->addTag($tag);
	    }
	}		
}

