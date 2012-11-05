<?php

class Generator_Model_Forms
{
	private $proxy = null;

	public function __construct(Generator_Model_Proxy $proxy)
	{
		$this->proxy = $proxy;

		$this->generate();
	}

    public function generate()
    {
    	$prop = static::getProperties();

        $meth[0] = new Zend_CodeGenerator_Php_Method();
        $meth[0]->setName('__construct')
                ->setVisibility('public')
                ->setBody(self::getConstructBody());

    	// Configuring after instantiation
        $meth[1] = new Zend_CodeGenerator_Php_Method();
        $meth[1]->setName('init')
                ->setVisibility('public')
                ->setParameter(array('name' => 'data = null'))
                ->setBody(self::getInitBody());

        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName($this->proxy->_objectname.'_Form_'.$this->proxy->_objectname)
              ->setMethods($meth)
              ->setExtendedClass('Zend_Form')
              ->setProperties($prop);

        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);

        if(!file_exists($this->proxy->_pathname.'/forms'))
    	{
    		mkdir($this->proxy->_pathname.'/forms');
    	}

        file_put_contents($this->proxy->_pathname . '/forms/'.$this->proxy->_objectname.'.php', $file->generate());
    }

    protected function getConstructBody()
    {
    	$str =
    	'$this->options = func_get_arg(0);'
	    ."\n\n".
	    '$this->init();';
    	return $str;
    }

    protected function getInitBody()
    {
        $str =
        '$object = null;'."\n".
        'if(isset($this->options["object"])){'."\n".
        '   $object = $this->options["object"];'."\n".
        '}'."\n\n";

    	$str .=
    	'$this->setAction($this->options[\'action\']);'."\n".
        '$this->setMethod(\'POST\');'."\n\n";

        $forms = $this->parseForms();

        foreach ($forms as $value) {
            $str .= $value;
        }

		$str .=
    	'$submit = new Zend_Form_Element_Submit(\'submit\');'."\n".
    	'$submit->setLabel(\'Submit\');'."\n\n".
        '$values = array($submit);'."\n\n".
		'$this->addElements($values);'."\n\n";

		$str .=
    	'$this->setDecorators(array('."\n".
		'    \'FormElements\','."\n".
		'     array(\'HtmlTag\', array(\'tag\' => \'div\', \'class\' => \'form_class\')),'."\n".
		'    \'Form\''."\n".
		'));';

    	return $str;
    }

    protected function getProperties()
    {
    	$prop['options'] = new Zend_CodeGenerator_Php_Property();
        $prop['options']->setName('options')
                       ->setStatic(FALSE)
                       ->setVisibility('protected')
                       ->setDefaultValue(null);

		return $prop;
	}


    /**
     * cristi was here
     */
    protected function parseForms()
    {
        $mapper = new Generator_Model_Mapper_Generator();
        $result = $mapper->fetchAll("{$this->proxy->_tablename}");

        return $result;
    }
}

