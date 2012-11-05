<?php

class Generator_Model_Mapper
{
	private $proxy = null;

	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;

		$this->generate();
	}

    public function generate()
    {
    	$method['construct'] = new Zend_CodeGenerator_Php_Method();
        $method['construct']->setName('__construct')
                            ->setVisibility('public')
                            ->setBody(static::getConstructBody());

    	$method['save'] = new Zend_CodeGenerator_Php_Method();
        $method['save']->setName('save')
                       ->setVisibility('public')
                       ->setParameter(array('name' => 'model', 'type' => 'Application_Model_Interface'))
                       ->setBody(static::getSaveBody());

        $method['delete'] = new Zend_CodeGenerator_Php_Method();
        $method['delete']->setName('delete')
                         ->setVisibility('public')
                         ->setParameter(array('name' => 'id = null'))
                         ->setBody(static::getDeleteBody());

        $method['fetchAll'] = new Zend_CodeGenerator_Php_Method();
        $method['fetchAll']->setName('fetchAll')
                           ->setParameter(array('name' =>'where = 1, $order = null, $limit = null, array $fields = null'))
                           ->setVisibility('public')
                           ->setBody(static::getFetchAllBody());

        $method['fetchScalar'] = new Zend_CodeGenerator_Php_Method();
        $method['fetchScalar']->setName('fetchScalar')
                              ->setParameter(array('name' =>'where = 1, $field = null'))
                              ->setVisibility('public')
                              ->setBody(static::getFetchScalarBody());

        $method['fetchRow'] = new Zend_CodeGenerator_Php_Method();
        $method['fetchRow']->setName('fetchRow')
                              ->setParameter(array('name' =>'where = 1, array $fields = null'))
                              ->setVisibility('public')
                              ->setBody(static::getFetchRowBody());

        $method['find'] = new Zend_CodeGenerator_Php_Method();
        $method['find']->setName('find')
                       ->setVisibility('public')
                       ->setParameter(array('name' => 'primary_key = null'))
                       ->setBody(static::getFindBody());

        $method['getResultObjects'] = new Zend_CodeGenerator_Php_Method();
        $method['getResultObjects']->setName('getResultObjects')
                                   ->setVisibility('protected')
                                   ->setParameter(array('name' => 'result'))
                                   ->setBody(static::getGetResultObjectsBody());

        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($this->proxy->_MapperClassName)
              ->setExtendedClass('Application_Model_Mapper_Abstract')
              ->setImplementedInterfaces(array('Application_Model_Mapper_Interface'))
              ->setMethods($method);
              //->setProperties($prop);

        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);

        if(!file_exists($this->proxy->_mapperPath))
    	{
    		mkdir($this->proxy->_mapperPath);
    	}

        file_put_contents($this->proxy->_mapperPath.'/'.$this->proxy->_objectname.'.php', $file->generate());

        return $file;
    }

    private function getConstructBody()
    {
    	$str = '$this->db =  Application_Model_ServiceLocator::getDb("'.$this->proxy->_db_registry_name.'");';

    	return $str;
    }

    private function getSaveBody()
    {
    	$str = '$data = array('."\n";

    	if($this->proxy->_metadata)
    	{
    	    foreach($this->proxy->_metadata as $m)
    	    {
    		    $getStr = $this->formatGetString($m);
    		    $str .= '    \''.$m.'\'    => $model->'.$getStr.'(),'."\n";
    	    }
        }
    	$str .= ');'."\n\n";

		$str .= '$data = $this->cleanArray($data);'."\n\n";

        $str .=
        'if($model->'.$this->formatGetString($this->proxy->_primary).'() == null)'."\n".
        '{'."\n".
        '    $this->db->insert(\''.$this->proxy->_tablename.'\', $data);'."\n".
        '}'."\n".
        'else   // update'."\n".
        '{'."\n".
        '	$this->db->update(\''.$this->proxy->_tablename.'\', $data, array(\''.$this->proxy->_primary.' = ?\' => $data[\''.$this->proxy->_primary.'\']));'."\n\n".
        '    return $data[\''.$this->proxy->_primary.'\'];'."\n".
        '}';

    	return $str;
    }

    private function getFetchAllBody()
    {
        $str = '$where = (null == $where) ? 1 : $where;'."\n\n";

        $str .= '$offset = $this->getOffset($limit);'."\n\n";

        $str .= '$fields = (!isset($fields)) ? \'*\' : $fields;'."\n\n";

    	$str .=
    	'$select = $this->db->select()'."\n".
    	'                   ->from("'.$this->proxy->_tablename.'", $fields)'."\n".
        '                   ->where($where)'."\n".
        '                   ->order($order)'."\n".
        '                   ->limit($limit, $offset);';
    	$str .= "\n\n";

    	$str .=
    	'if($this->usePaginator == TRUE)'."\n".
        '{'."\n".
        '    Application_Model_Paginator::setPagination($select, $limit);'."\n".
        '}'."\n\n".

    	$str .= '$result = $this->db->fetchAll($select);'."\n";

    	$str .= 'return $this->getResultObjects($result);';

    	return $str;
    }

    private function getFetchScalarBody()
    {
    	$str = '$where = (null == $where) ? 1 : $where;'."\n\n";

    	$str .= '$fields = (!isset($fields)) ? \'null\' : $fields;'."\n\n";

    	$str .=
    	'$select = $this->db->select()'."\n".
    	'                   ->from("'.$this->proxy->_tablename.'", $field)'."\n".
    	'                   ->where($where);'."\n";
    	$str .= "\n";

    	$str .=
    	'return $this->db->fetchOne($select);';

    	return $str;
    }

    private function getFetchRowBody()
    {
    	$str = '$where = (null == $where) ? 1 : $where;'."\n\n";

    	$str .= '$fields = (!isset($fields)) ? \'null\' : $fields;'."\n\n";

    	$str .=
    	'$select = $this->db->select()'."\n".
    	'                   ->from("'.$this->proxy->_tablename.'", $fields)'."\n".
    	'                   ->where($where);'."\n";
    	$str .= "\n";

    	$str .=
    	'return $this->db->fetchAll($select);';

    	return $str;
    }

    private function getFindBody()
    {
        return $str = 'return $this->setDbTable(\''.$this->proxy->_DbTableClassName.'\')->getDbTable()->find($primary_key);';
    }

    private function getDeleteBody()
    {
        $str =
        '    $this->db->delete("'.$this->proxy->_tablename.'", array('."\n".
        '                           \''.$this->proxy->_primary.' = ?\' => $id'."\n".
        '    ));'."\n";

		return $str;
    }

    private function getGetResultObjectsBody()
    {
    	$str = '$objects = array();';
    	$str .= "\n\n";

    	$str .=
    	'foreach($result as $row)'."\n".
        '{'."\n".
        '    $object = new '.$this->proxy->_ModelClassName.'();'."\n\n";

    	$str .=
    	'    $object->setProperty($row);'."\n\n";

		$str .=
		'    if($this->useDependents === TRUE)'."\n".
		'    {'."\n".
	    '        //$model = new '.$this->proxy->_ModelClassName.'();'."\n\n".
		'	    //$object->setDependentTable($model->fetchAll(\'id = \'.$row->id));'."\n".
		'    }'."\n\n";

    	$str .=
    	'    $objects []= $object;'."\n";

    	$str .=
    	'}'."\n\n";

    	$str .=
    	'if(isset($objects[1]))'."\n".
        '{'."\n".
        '    return $objects;'."\n".
        '}'."\n".
        'elseif(isset($objects[0]))'."\n".
        '{'."\n".
        '    return $objects[0];'."\n".
        '}';
    	return $str;
    }

    private function formatGetString($str)
    {
    	return $getStr = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }

    private function formatSetString($str)
    {
    	return $setStr = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }
}

