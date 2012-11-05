<?php

class Generator_Model_Module
{ 
	private $proxy = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
        
    	if(!file_exists($this->proxy->_pathname))
    	{
    		mkdir($this->proxy->_pathname);
    		
    		return $this;
    	}
    	elseif($this->proxy->_overwrite != false) 
    	{
    		mkdir($this->proxy->_pathname);
    		
    		//var_dump($this); exit;
    		return $this;
    		
        }
    	else 
    	{
    		throw new Exception($this->proxy->_modulename . ' already exists'
    		                    .'<a href="/generator/index/overwrite'.
    		                        '/database_name/'.$this->proxy->_databasename.
    		                        '/table_name/'.$this->proxy->_tablename.
    		                        '/object_name/'.$this->proxy->_objectname.'">
    		                        Click Here to Overwrite
    		                      </a>');
    	}
    	
    }
    
}

