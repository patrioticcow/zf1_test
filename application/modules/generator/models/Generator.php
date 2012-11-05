<?php

class Generator_Model_Generator
{
	private $data = array();
	private $proxy;

	public function generate($data = null)
    {
    	$this->data = $data = $this->setProxyData($data);

        if(empty($data['table_name']) && empty($data['new_module_name']) && empty($data['overwrite']))
        {
        	throw new Exception('object_name or table_name is required in '.__METHOD__, 1);
        }


        //var_dump($this->proxy); exit;
        if(!empty($data['create_module']) && !$data['module_name'] && $this->proxy->_overwrite == false)
        {
        	//var_dump($this->proxy); exit;
        	new Generator_Model_Module($this->proxy);
        	new Generator_Model_Bootstrap($this->proxy);

        }
        else
        {
        	$this->proxy->_isAssociationEntity = true; // entity included in another module
        }

        if(!empty($data['create_model']))
            new Generator_Model_Model($this->proxy);

        if(!empty($data['create_mapper']))
            new Generator_Model_Mapper($this->proxy);

        if(!empty($data['create_dbTable']))
            new Generator_Model_DbTable($this->proxy);

        if(!empty($data['create_controller']))
            new Generator_Model_Controller($this->proxy);

        if(!empty($data['create_view']))
            new Generator_Model_View($this->proxy);

        if(!empty($data['create_form']))
            new Generator_Model_Forms($this->proxy);


        return $this->proxy;
    }

    private function setProxyData($data = null)
    {
    	if($data === null)
    	{
    	    $front = Zend_Controller_Front::getInstance();
    	    $data = $front->getRequest()->getParams();
    	}

    	$this->data = $data;

    	$this->setProxy();

    	$this->setDbRegistryName();

    	$this->setDatabaseName();

        $this->setTableName();

        $this->setObjectName();

        $this->setModuleName();

        $this->setPaths();

        $this->setClassNames();

        // tests if schema and table exists and if so, sets the _primary  key
        $this->dbTableIsValid();

        $this->setOverwrite();

        return $data;
    }

    private function setProxy()
    {
    	$this->proxy = new Generator_Model_Proxy();
    }

    private function setDbRegistryName()
    {
    	$this->proxy->_db_registry_name = !empty($this->data['db_registry_name']) ? $this->data['db_registry_name'] : null;
    }

    private function setDatabaseName()
    {
    	$this->proxy->_databasename = !empty($this->data['database_name']) ? $this->data['database_name'] : null;
    }

    private function setTableName()
    {
    	 $this->proxy->_tablename = !empty($this->data['table_name']) ? $this->data['table_name'] : null;
    }

    private function setObjectName()
    {
    	$this->proxy->_objectname = !empty($this->data['table_name']) ? ucfirst(str_replace('_', '', $this->data['table_name'])) : null;
    }

    private function setModuleName()
    {
        if(!empty($this->data['new_module_name']))
        {
            $this->proxy->_modulename = $this->data['new_module_name'];
        }
        elseif(!empty($this->data['module_name']))
        {
            $this->proxy->_modulename = $this->data['module_name'];
        }
        else
        {
        	$this->proxy->_modulename = strtolower($this->proxy->_objectname);
        }
    }

    private function setPaths()
    {
    	$path = APPLICATION_PATH . '/modules';
        // set the intitial path for module
        $this->proxy->_pathname = $path . '/' . $this->proxy->_modulename;

    	$this->proxy->_dbTablePath = $this->proxy->_pathname . '/models/DbTable';

    	$this->proxy->_mapperPath = $this->proxy->_pathname . '/models/mappers';

    	$this->proxy->_modelPath = $this->proxy->_pathname . '/models';

        $this->proxy->_controllerPath = $this->proxy->_pathname . '/controllers';

        $this->proxy->_viewPath = $this->proxy->_pathname . '/views';
    }

    private function setClassNames()
    {
    	$this->proxy->_DbTableClassName = ucfirst($this->proxy->_modulename).'_Model_DbTable_'.$this->proxy->_objectname;

        $this->proxy->_ModelClassName = ucfirst($this->proxy->_modulename).'_Model_'.$this->proxy->_objectname;

        $this->proxy->_MapperClassName = ucfirst($this->proxy->_modulename).'_Model_Mapper_'.$this->proxy->_objectname;

		$this->proxy->_FormClassName = ucfirst($this->proxy->_modulename).'_Form_'.$this->proxy->_objectname;

        $this->proxy->_ControllerClassName = ucfirst($this->proxy->_modulename).'_'.'IndexController';
    }

    private function setOverwrite()
    {
    	$front = Zend_Controller_Front::getInstance();
    	if('overwrite' === $front->getRequest()->getActionName())
            $this->proxy->_overwrite = true;
    }

    protected function dbTableIsValid()
    {
    	$db = $this->getDbConn();

    	try {
    	    $metadata = $db->describeTable($this->proxy->_tablename, $this->proxy->_databasename);
    	} catch(Exception $e) {
    		$this->proxy->_validDbTable = false;
    	}

    	if(isset($metadata))
    	{
    		$this->proxy->_metadata = $metadata;

    	    foreach($metadata as $key=>$meta)
    	    {
    	    	foreach($meta as $k=>$val)
    	    	{
    	    		if($k == 'PRIMARY' && $val == 1)
    	    		    $primary []= $key;
    	    	}
    	    }

    	    if(sizeof($primary) > 1)
    	    {

    	    	//multi primary keys
    	    }
    	    else
    	    {
    	        $this->proxy->_primary = $primary[0];
    	    }

    	    $this->proxy->_validDbTable = true;

    	}
    	else
    	{
    	    $this->proxy->_validDbTable = false;
    	    return;
    	}
    }

    public function getDbConn()
    {
    	if($this->proxy->_db_registry_name != null)
    	{
    		return $db = Application_Model_ServiceLocator::getDb($this->proxy->_db_registry_name);
    		//return $db = Zend_Registry::get($this->proxy->_db_registry_name);
    	}
    	elseif(!$db = Zend_Db_Table::getDefaultAdapter())
    	{
    		return $db = Application_Model_ServiceLocator::getDb('db');
    	    //return $db = Zend_Registry::get('db');
    	}
    	else
    	{
    		return $db = Application_Model_ServiceLocator::getDb('db');
    	}
    }

    public function getDbName()
    {
    	if(@$this->proxy->_db_registry_name != null)
    	{
    		$db = Application_Model_ServiceLocator::getDb($this->proxy->_db_registry_name);
    		//$db = Zend_Registry::get($this->proxy->_db_registry_name);
    	}
    	elseif(!$db = Zend_Db_Table::getDefaultAdapter())
    	{
    		$db = Application_Model_ServiceLocator::getDb('db');
    	    //$db = Zend_Registry::get('db');
    	}


    	$a = $db->getConfig();
    	return $a['dbname'];
    }

    public static function getExistingModules()
    {
    	$directory = APPLICATION_PATH. '/modules';
        $dirnames[0] = 'Choose a Module';

        $iterator = new DirectoryIterator($directory);
        foreach ($iterator as $fileinfo)
        {
            if ($fileinfo->isDir() &&
                $fileinfo->getFilename() != 'administrator' &&
                $fileinfo->getFilename() != 'generator' &&
                $fileinfo->getFilename() != '.' &&
                $fileinfo->getFilename() != '..')
            {
                $dirnames[$fileinfo->getFilename()] = $fileinfo->getFilename();
            }
        }
        //ksort($filenames);
        return ($dirnames);
    }
}

