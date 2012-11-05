<?php

class Generator_Model_Proxy extends Application_Model_Proxy
{ 
	protected $_db_registry_name = null;
	
	protected $_databasename = null;
	
	protected $_tablename = null;
	
	protected $_primary = null;
	
	protected $_validDbTable = false;
	
	protected $_isAssociationEntity = false;
	
	protected $_new_module_name = null;
	
	protected $_modulename = null;
	
	protected $_objectname = null;
	
	protected $_ModelClassName = null;
	
	protected $_MapperClassName = null;
	
	protected $_FormClassName = null;
	
	protected $_DbTableClassName = null;
	
	protected $_ControllerClassName = null;
    
	protected $_pathname = null;
	
	protected $_dbTablePath = null;
	
	protected $_mapperPath = null;
	
	protected $_modelPath = null;
	
	protected $_controllerPath = null;
	
	protected $_viewPath = null;
	
	protected $_formPath = null;
	
	protected $_messages = null;
	
	protected $_overwrite = false;
	
	protected $_metadata = null;
	
	protected $_bootstrap = null;
	
    public function create($data = null) {}
}

