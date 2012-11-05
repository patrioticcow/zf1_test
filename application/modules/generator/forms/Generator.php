<?php

class Generator_Form_Generator extends Zend_Form
{
	protected $elements = null;
	protected $options;

	public function __construct()
	{
		$this->options = func_get_arg(0);

		if(func_num_args() > 1)
	        $this->elements = func_get_arg(1);

	    return $this->init();
	}

    public function init()
    {
    	$this->setAction($this->options['action']);
    	$this->setName($this->options['name']);
        $this->setMethod($this->options['method']);

        $this->addElement('text', 'db_registry_name', array(
                    'required'   => false,
            	    'label'      => 'Database Registry Connection Name:',
                    //'value'      => @$val,
        ));

        $this->addElement('text', 'database_name', array(
                    'required'   => false,
            	    'label'      => 'Database Name:',
                    //'value'      => @$val,
        ));

        $this->addElement('text', 'table_name', array(
                    'required'   => false,
            	    'label'      => 'Table Name:',
                    'value'      => null,
        ));

        $this->addElement('text', 'new_module_name', array(
                    'required'   => false,
            	    'label'      => 'New Module Name:(if different than DbTable Name)',
                    'value'      => null,
        ));

        $this->addElement('select', 'module_name', array(
                    'required'   => false,
                    'multiOptions' => array(Generator_Model_Generator::getExistingModules()),
            	    'label'      => 'Existing Module Name:',
                    'value'      => 0,
        ));

        $this->addElement('checkbox', 'create_module', array(
                    'required'   => false,
            	    'label'      => 'Create Module:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_dbTable', array(
                    'required'   => false,
            	    'label'      => 'Create DbTable:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_mapper', array(
                    'required'   => false,
            	    'label'      => 'Create Mapper:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_model', array(
                    'required'   => false,
            	    'label'      => 'Create Model:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_controller', array(
                    'required'   => false,
            	    'label'      => 'Create Controller:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_view', array(
                    'required'   => false,
            	    'label'      => 'Create View:',
                    'value'      => 1,
        ));

        $this->addElement('checkbox', 'create_form', array(
                    'required'   => false,
            	    'label'      => 'Create Form:',
                    'value'      => 1,
        ));

        $update = $this->addElement('submit', 'generate', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Generate Code'
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));

        return $this;
    }

}