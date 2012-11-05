<?php

abstract class Application_Model_Mapper_Abstract
{
	protected static $_dbTable;
	
	public $useDependents = TRUE;

   	public $usePaginator = FALSE;
   	
   	protected $db;
   	
	
    protected function setDbTable($dbTable)
    {
        if (is_string($dbTable))
        {
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway provided");
        }
        
        self::$_dbTable = $dbTable;
        $this->db = $this->getDbTable();
        
        return $this;
    }

    protected function getDbTable()
    {
        if (null === self::$_dbTable)
        {
            //throw new Exception("No DbTable set");
            $this->setDbTable('User_Model_DbTable_User');
        }
        return self::$_dbTable;
    }
    
    protected function getOffset($limit)
    {
        if($limit != null)
	    {
	        $front = Zend_Controller_Front::getInstance();
	        $page = $front->getRequest()->getParam("page");
	        
	        $page = !$page ? 0 : ($page - 1);
	        
	        return $offset = $limit * $page;
	    }
	    else
	    {
	    	
	    	return $offset = null;
	    }
    }
    
    protected function setOrder($order)
    {
        if($order != null)
	    {
	    	$this->order = $order;
	    }
    }
	
	protected function cleanArray(array $data)
    {
    	foreach($data as $key=>$val)
    	{
    		if(null === $val)
    		{
    			unset($data[$key]);
    		}
    	}
    	return $data;
    }
    
    protected abstract function fetchAll();
}