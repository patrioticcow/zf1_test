<?php

class Generator_Model_Model
{ 
	private $proxy = null;
	
	private $createBody = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
    	// set the properties base on the dbTable - this must be first
    	$prop = static::getProperties();
                               
    	$prop['assocTable'] = new Zend_CodeGenerator_Php_Property();
        $prop['assocTable']->setName('_dependent_table')
                           ->setDocBlock('association property for dependentTable or comment out')
                           ->setVisibility('protected')
                           ->setDefaultValue(null);
    	
    	$method[0] = new Zend_CodeGenerator_Php_Method();
        $method[0]->setName('__construct')
                ->setVisibility('public')
                ->setBody('static::$_mapper = new '.$this->proxy->_MapperClassName.'();');
                
    	// Configuring after instantiation
        $method[1] = new Zend_CodeGenerator_Php_Method();
        $method[1]->setName('create')
                ->setVisibility('public')
                ->setParameter(array('name' => 'data = null'))
                ->setBody(static::getCreateBody());
            
        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($this->proxy->_ModelClassName)
              ->setMethods($method)
              ->setExtendedClass('Application_Model_Proxy')
              ->setProperties($prop);
 
        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);
        
        if(!file_exists($this->proxy->_modelPath))
    	{
    		mkdir($this->proxy->_modelPath);
    	}
        //var_dump($file);
        file_put_contents($this->proxy->_modelPath.'/'.$this->proxy->_objectname.'.php', $file->generate());
    }
    
    protected function getCreateBody()
    {
    	$str = 
    	'if($data == null)'."\n". 
        '{'."\n". 
        '    $front = Zend_Controller_Front::getInstance();'."\n\n".
        '    $data = $front->getRequest()->getParams();'."\n".
        '}'."\n\n";
			
		$str .= $this->createBody;
		
    	$str .= 
    	'$id = static::$_mapper->save($this);'."\n\n".
        'return $id;';
    	
    	return $str;
    }
    
    protected function getProperties()
    {
    	$db = Application_Model_ServiceLocator::getDb($this->proxy->_db_registry_name);
    	//$db = Zend_Registry::get($this->proxy->_db_registry_name);

    	$prop['mapper'] = new Zend_CodeGenerator_Php_Property();
        $prop['mapper']->setName('_mapper')
                       ->setStatic(TRUE)
                       ->setVisibility('protected')
                       ->setDefaultValue(null);
                       
        $tables = $db->listTables();
        
        if(in_array($this->proxy->_tablename, $tables))
        {  
        	$metadata = $db->describeTable($this->proxy->_tablename, $this->proxy->_databasename);
        	
        	$this->proxy->_metadata = $properties = array_keys($metadata);
        	                         
    	    foreach($properties as $i=>$p)
    	    {
    	        $prop[$i] = new Zend_CodeGenerator_Php_Property();
                $prop[$i]->setName('_'.$p)
                         ->setVisibility('protected')
                         ->setDefaultValue(null); 

                // this is actually for the getCreateBody() method
                if($p == 'modified')
                {
                	$this->createBody .= '$this->_'.$p .' = !empty($data["'.$p.'"]) ? $data["'.$p.'"] : new Zend_Db_Expr("NOW()");'."\n\n";
                }
                $this->createBody .= '$this->_'.$p .' = !empty($data["'.$p.'"]) ? $data["'.$p.'"] : null;'."\n\n";
    	    }  
    	    
        	$prop['assocTable'] = new Zend_CodeGenerator_Php_Property();
            $prop['assocTable']->setName('_dependent_table')
                               ->setDocBlock('association property for dependentTable or comment out')
                               ->setVisibility('protected')
                               ->setDefaultValue(null);
    	    
                
    	} 
    	else 
    	{
    	    $message = '<br />'.$this->proxy->_tablename . ' does not exist. Would you like to create it?<br />';
    	    $message .= '<a href="/generator/index/createdb">Create the Db Here</a>';
    	    
    	    $this->proxy->_messages .= $message;
    	   
    	}
    	return $prop;
    }
}

