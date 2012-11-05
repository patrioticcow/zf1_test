<?php
class Api_DB_Test {
	
	public static function showProcessList()
	{
		$db = Zend_Registry::get('db');
		
		$sql = "
		    SHOW PROCESSLIST
		";
		
        $result = $db->fetchAll($sql);
        
        return $result;
	}
	
    public static function showDBs()
	{
		$db = Zend_Registry::get('db');
		
		$sql = "
		    SHOW Databases
		";
		
        $result = $db->fetchAll($sql);
        
        return $result;
	}
	
    public static function showSchema($tableName = 'ss.image')
	{
		$db = Zend_Registry::get('db');
		
		$sql = "
		    SHOW Columns From $tableName
		";
		
        $result = $db->fetchAll($sql);
        
        return $result;
	}
	
    public static function showCreateTable($tableName = 'ss.image')
	{
		$db = Zend_Registry::get('db');
		
		$sql = "
		    SHOW CREATE TABLE $tableName;
		";
		
        $result = $db->fetchAll($sql);
        
        return $result;
	}
	
    public static function getBenchMark($sql)
	{
		$start = microtime();
		
		$db = Zend_Registry::get('db');
		
        $result = $db->fetchAll($sql);
        
        echo 'Query Time: '.(microtime()-$start);
        
        return $result;
	}
	
    public static function showStatus($test = 'co')
	{
		$db = Zend_Registry::get('db');
		
        $result = $db->fetchAll('SHOW GLOBAL STATUS LIKE "%'.$test.'%"');
        
        return $result;
	}
	
	public static function showProcedures()
	{
		$db = Zend_Registry::get('db');
		
		$sql = "
		    SELECT ROUTINE_NAME
            FROM INFORMATION_SCHEMA.ROUTINES
            WHERE ROUTINE_TYPE='PROCEDURE' 
		";
        
		$result = $db->fetchAll($sql);
		
        return $result;
	}
}