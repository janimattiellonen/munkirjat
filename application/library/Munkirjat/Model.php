<?php
namespace Munkirjat;

class Model
{
    /**
     * @var \Model\Repository\BaseRepository
     */
    protected $_entityRepository;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_entityManager;
    	
	protected $_entityClassName;
	
    /**
     * Find by primary key
     *
     * @param  integer $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->_getEntityRepository()->find($id);
    }
    
	public function findByName($name)
	{
		return $this->_getEntityRepository()->searchByName($name);
	}
	
	public function findBynameForJson($name)
	{
		$results = $this->findByName($name);

		$items = array();
		
		foreach($results as $item)
		{
			$items[] = array('id' => $item->getId(), 'label' => $item->getName()  );
		}
		
		return $items;
	}    
    
    
    /**
     * 
     * @param mixxed $entity (\Model\Entity or id of entity)
     */
    public function remove($entity)
    {
        if($entity instanceof \Model\Entity)
        {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
        else
        {
            $entity = $this->_getEntityRepository()->find($entity);    
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }
    
	/**
	 * 
	 * @param $id
	 * @param \Model\Entity $id
	 */
	public function findOrCreate($id = null)
	{
		$entity = $this->find($id);
		
		if(!$entity)
		{
			$entity = new $this->_entityClassName();
		}
		
		return $entity;
	}
	
	/**
	 * @param unknown_type $entity
	 */
	protected function _save($entity)
	{
		$em = $this->getEntityManager();
		$em->persist($entity);
		$em->flush();
	}
	
    /**
     * Get entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
    	if(!isset($this->_entityManager) )
    	{
        	$this->_entityManager =  \Model\Service::getEntityManager();
    	}
    	
    	return $this->_entityManager;
    }
    
    /**
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $manager)
    {
    	$this->_entityManager = $manager;
    }
    
    /**
     * @param string $entityClassName optional entity class name
     * @return \Model\Repository\BaseRepository
     */
    protected function _getEntityRepository($entityClassName = null)
    {
        // if an optional entity class name is provided, a repository object for that
        // class is retrieved, but not stored for next calls
        if (null === $this->_entityRepository || isset($entityClassName) ) 
        {
            $class = isset($entityClassName) ? $entityClassName : $this->_entityClassName;
            
            $repository = $this->getEntityManager()->getRepository($class);
            
            if(isset($entityClassName) )
            {
                return $repository;
            }
            
            $this->_entityRepository = $repository;
        }
        
        return $this->_entityRepository;
    }
    
    /**
     * @return Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
    	
}