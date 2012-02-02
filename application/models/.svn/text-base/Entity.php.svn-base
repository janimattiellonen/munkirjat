<?php
namespace Model;

class Entity
{
	/**
	 * Populates entity fields from an array
	 * @param array $data
	 * @param array $exclude fields that are not to be populated
	 */
	public function fromArray($data, array $exclude = array() )
	{
		foreach($data as $key => $value)
		{
			if(!in_array($key, $exclude) )
			{
				$method = 'set' . ucfirst($key);
				
				$this->$method($value);
			}
		}
	}
	
	public function getEntityValues(\Zend_Form $form)
	{
		$metadata = \Model\Service::getEntityManager()->getMetadataFactory()->getMetadataFor(get_class($this) );

		// under_score -> unerScore
		$filter = new \Zend_Filter_Word_UnderscoreToCamelCase();
		
		$values = array();
		$formValues = array();
		
		foreach($form->getValues() as $name => $value)
		{
			if(is_array($value) )
			{
				foreach($value as $name2 => $value2)
				{
					$formValues[$name2] = $value2;
				}
			}
			else
			{
				$formValues[$name] = $value;
			}
		}
		
		foreach($formValues as $name => $value)
		{
			$propertyName = lcfirst($filter->filter($name) );
			$propertySetter = "set" .ucfirst($propertyName);
			
			if($metadata->hasAssociation($propertyName) )
			{
				if(!$value)
				{
					$value = null;
				}	
			}
			else if($metadata->hasField($propertyName) ) 
			{
                $mapping = $metadata->getFieldMapping($propertyName);
                
                if ($mapping['type'] == 'integer' && !$value) 
                {
                    $value = null;
                }
                
                if ($mapping['type'] == 'date' && !$value instanceof \DateTime) 
                {
                    $value = new \DateTime($value);
                }
                
                if ($mapping['type'] == 'time') 
                {
                    $value = new \DateTime($value);
                }
			}
			
            if ($this->propertyExists($propertyName) || \method_exists($this, $propertySetter) )
            {
                if (! $value) 
                {
                    $value = null;
                }

                $values[$propertyName] = $value;
            }
		}
		
		return $values;
	}
	
    public function propertyExists($propertyName)
    {

        $refl_class = new \ReflectionClass($this);
        
        if ($refl_class) 
        {
            if ($refl_class->hasProperty($propertyName) ) 
            {
                return true;
            }
        }
        
        return false;
    }	
	
}