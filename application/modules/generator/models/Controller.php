<?php

class Generator_Model_Controller
{ 
	private $proxy = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
    	$meth['init'] = new Zend_CodeGenerator_Php_Method();
        $meth['init']->setName('init')
                ->setVisibility('public')
                ->setBody(self::getInitBody());
                
        $meth['index'] = new Zend_CodeGenerator_Php_Method();
        $meth['index']->setName('indexAction')
                      ->setVisibility('public')
                      ->setBody(self::getIndexActionBody());
                
    	// Configuring after instantiation
        $meth['save'] = new Zend_CodeGenerator_Php_Method();
        $meth['save']->setName('saveAction')
                ->setVisibility('public')
                ->setParameter(array('name' => 'data = null'))
                ->setBody(self::getSaveActionBody());
				
		$meth['getform'] = new Zend_CodeGenerator_Php_Method();
        $meth['getform']->setName('getForm')
                ->setVisibility('private')
                ->setParameter(array('name' => 'object = null'))
                ->setBody(self::getGetFormBody());
        /*    
        $meth['fetch'] = new Zend_CodeGenerator_Php_Method();
        $meth['fetch']->setName('fetchAction')
                ->setVisibility('public')
                ->setBody(self::getFetchActionBody());
                                           
        $meth['find'] = new Zend_CodeGenerator_Php_Method();
        $meth['find']->setName('findAction')
                ->setVisibility('public')
                ->setParameter(array('name' => 'id = null'))
                ->setBody(self::getFindActionBody());
        
        $meth['delete'] = new Zend_CodeGenerator_Php_Method();
        $meth['delete']->setName('deleteAction')
                ->setVisibility('public')
                ->setParameter(array('name' => 'id = null'))
                ->setBody(self::getDeleteActionBody());
        */
        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($this->proxy->_ControllerClassName)
              ->setExtendedClass('Zend_Controller_Action')
              ->setMethods($meth);
              //->setProperties($prop);
        
        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);
        
        if(!file_exists($this->proxy->_controllerPath))
    	{
    		mkdir($this->proxy->_controllerPath);
    	}
    	
        if(!file_exists($this->proxy->_controllerPath.'/IndexController.php'))
        {
            file_put_contents($this->proxy->_controllerPath.'/IndexController.php', $file->generate());
        }
        /*
        else if(!file_exists($this->proxy->_controllerPath.'/'.$this->proxy->_objectname.'.php'))
        {
            file_put_contents($this->proxy->_controllerPath.'/'.$this->proxy->_objectname.'.php', $file->generate());
        }
        */
        //var_dump($code); exit;
        return $this->proxy->_controllerPath.'/'.$this->proxy->_objectname.'.php';
    }
    
    private function getInitBody()
    {
    	$str = '//Application_Model_Auth::authorize("user");'."\n\n".
               '$this->_helper->layout->setLayout(\'default\');'."\n\n";
    	
    	return $str; 
    	                
    }
    
    private function getSaveActionBody()
    {
    	$str = 
    	'$model = new '.$this->proxy->_ModelClassName.'();'."\n\n".
    	'$form = $this->getForm();'."\n\n". 
        'if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getParams()))'."\n".
        '{'."\n".
        '    $result = $model->create();'."\n\n".
        '    $this->view->result = $result;'."\n".
    	'}'."\n";
		
		$str .= 
		'else'."\n".
		'{'."\n".
		'    $this->view->form = $form;'."\n".
		'}';
			   
    	return $str; 
    	                
    }
    
    private function getIndexActionBody()
    {
    	$str = '$model = new '.$this->proxy->_ModelClassName.'();'."\n\n". 
               '$result = $model->fetchAll(null, null, 10);'."\n\n".
               '$this->view->result = $result;'."\n\n";
    	
    	return $str; 
    	                
    }
    
    private function getFetchActionBody()
    {
    	$str = '$model = new '.$this->proxy->_ModelClassName.'();'."\n\n". 
               '$result = $model->fetchAll();'."\n\n".
               '$this->view->result = $result;'."\n\n";
    	$str .= '$this->render("index");';
    	return $str; 
    	                
    }
    
    private function getFindActionBody()
    {
    	$str = '$model = new '.$this->proxy->_ModelClassName.'();'."\n\n". 
               '$id = (null == $id) ? $this->getRequest()->getParam(\'id\') : $id;'."\n\n".
    	       '$result = $model->find($id);'."\n\n".
               '$this->view->result = $result;'."\n\n";
    	$str .= '$this->render("index");';
    	return $str; 
    	                
    }
    
    private function getDeleteActionBody()
    {
    	$str = '$model = new '.$this->proxy->_ModelClassName.'();'."\n\n". 
               '$id = (null == $id) ? $this->getRequest()->getParam(\'id\') : $id;'."\n\n".
    	       '$id = $model->delete($id);'."\n\n".
               '$this->view->result = $id . "Deleted.";'."\n\n";
    	$str .= '$this->render("index");';
    	return $str; 
    	                
    }
	
	private function getGetFormBody()
    {
    	$str = '$model = new '.$this->proxy->_ModelClassName.'();'."\n\n";
      	
      	$str .= '$result = $model->fetchAll(\''.$this->proxy->_primary.' = \'.USERID);'."\n\n";
      	
    	$str .= 
    	'return new '.$this->proxy->_FormClassName.'('."\n".
		'    array('."\n".
        '         \'action\'   => \''.$this->proxy->_modulename.'/index/save\','."\n".
        '         \'object\' => $object'."\n".
        '));'."\n";
		  
    	$str .= 'return $form;';
    	return $str; 
    	                
    }
}

