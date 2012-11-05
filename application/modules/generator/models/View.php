<?php

class Generator_Model_View
{ 
	private $proxy = null;
	
	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;
		
		$this->generate();
	}
	
    public function generate()
    {
        if(!file_exists($this->proxy->_viewPath) && $this->proxy->_overwrite == false)
    	{
    		mkdir($this->proxy->_viewPath);
    		mkdir($this->proxy->_viewPath.'/scripts');
    		mkdir($this->proxy->_viewPath.'/scripts/index');
    		
    		$handle = fopen($this->proxy->_viewPath . '/scripts/index/index.phtml', 'w');
    		fwrite($handle, '<?php'."\n". 
                            'echo $this->title;'."\n\n".                            
                            'echo $this->message;'."\n\n".
                            'if(is_array($this->result))'."\n".
                            '{'."\n".
                            '    foreach($this->result as $row)'."\n".
                            '    {'."\n".
                            '        Zend_Debug::dump($row);'."\n".
                            '    }'."\n".
                            '}'."\n".
                            'else'."\n". 
                            '{'."\n".
	                        '    Zend_Debug::dump($this->result);'."\n".
                            '}'."\n".
                            'echo $this->form;'."\n\n".
                            'echo $this->paginator;'."\n".
                            '?>');
    		fclose($handle);
    	}
    	
    	return $this->proxy->_viewPath;
    }
    
}

