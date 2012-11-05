<?php

class Generator_Model_DbTable
{ 
    private $proxy = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
        $prop[0] = new Zend_CodeGenerator_Php_Property();
        $prop[0]->setName('_schema')
                ->setVisibility('protected')
                ->setDefaultValue($this->proxy->_databasename);

        $prop[1] = new Zend_CodeGenerator_Php_Property();
        $prop[1]->setName('_name')
                ->setVisibility('protected')
                ->setDefaultValue($this->proxy->_tablename);
                
        $prop[2] = new Zend_CodeGenerator_Php_Property();
        $prop[2]->setName('_primary')
                ->setVisibility('protected')
                ->setDefaultValue($this->proxy->_primary);
 
        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($this->proxy->_DbTableClassName)
              ->setExtendedClass('Zend_Db_Table_Abstract')
              //->setMethods($meth)
              ->setProperties($prop);
 
        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);
        
        if(!file_exists($this->proxy->_dbTablePath))
    	{
    		mkdir($this->proxy->_dbTablePath);
    	}
        //var_dump($file);
        file_put_contents($this->proxy->_dbTablePath.'/'.$this->proxy->_objectname.'.php', $file->generate());
        
        return $file;
    }
    
}

