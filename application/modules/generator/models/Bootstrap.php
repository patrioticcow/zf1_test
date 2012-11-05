<?php

class Generator_Model_Bootstrap
{ 
	private $proxy = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
    	return $this->proxy->_bootstrap = $this->getInitModuleHeadingsBody();
    }
    
    protected function getInitModuleHeadingsBody()
    {
    	$str = '<textarea cols="80" rows="12">';
    	$str .=
    	'    protected function _initModule'.$this->proxy->_objectname.'()'."\n".
	    '    {'."\n".
    	'        $loader = new Zend_Application_Module_Autoloader(array('."\n".
		'	        \'namespace\' => \''.ucfirst($this->proxy->_modulename).'\','."\n".
		'	        \'basePath\'  => APPLICATION_PATH . \'/modules/'.$this->proxy->_modulename.'\','."\n".
		'        ));'."\n\n";
		
    	
    	$str .=
    	'        $loader->addResourceType(\'form\', \'forms\', \'Form\')'."\n".
    	'               ->addResourceType(\'menu\', \'menus\', \'Menu\')'."\n".
		'	            ->addResourceType(\'model\', \'models\', \'Model\')'."\n".
		'	            ->addResourceType(\'mappers\', \'models/mappers\', \'Model_Mapper\')'."\n".
		'	            ->addResourceType(\'dbtable\', \'models/DbTable\', \'Model_DbTable\');'."\n".
    	'    }';
    	
    	$str .= '</textarea>';
    	return $str;
    }
    
    public static function getBootstrap($module_name)
    {
    	
    }
}

