<?php
class Munkirjat_ClassLoader extends \Doctrine\Common\ClassLoader
{
    /**
     * The namespace must be protected to enable extending,
     * but Doctrine does not do it
     * 
     * @var string
     */
    protected $_namespace;
    
    public function __construct($ns = null, $includePath = null)
    {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
    }
    
    /**
     * Loads the given class or interface.
     *
     * @param string $className The name of the class to load.
     * @return boolean TRUE if the class has been successfully loaded, FALSE otherwise.
     */
    public function loadClass($className)
    {
        if ($this->_namespace !== null && strpos($className, $this->_namespace.$this->getNamespaceSeparator()) !== 0) {
            return false;
        }

        $className = str_replace($this->_namespace . $this->getNamespaceSeparator(), '', $className);
        
        require ($this->getIncludePath() !== null ? $this->getIncludePath() . DIRECTORY_SEPARATOR : '')
               . str_replace($this->getNamespaceSeparator(), DIRECTORY_SEPARATOR, $className)
               . $this->getFileExtension();
        
        return true;
    }
}