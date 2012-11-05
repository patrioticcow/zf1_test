<?php

class Profile_Form_Imagedelete extends Zend_Form
{
	public $args;

	public function __construct()
	{
		$this->args = func_get_args();

		parent::__construct();
	}

	public function init()
    {
    	$this->setMethod('post');

    	foreach ($this->args[1] as $val)
    	{
    		$submitImage = new Zend_Form_Element_Image('submit_image_'. $val->id);
        	$checkBox 	 = new Zend_Form_Element_Checkbox($val->id);

    		$this->addElement( $submitImage ->setImage($val->full_path) );
    		$this->addElement( $checkBox 	->setValue($val->id) 		->setLabel('Check to delete') );

    		$submitImage ->setDecorators($this->setbulkDecorators('submit_image', 'submit_image_label', 'submit_image_post'));
    		$checkBox 	 ->setDecorators($this->setbulkDecorators('submit_checkbox', 'submit_checkbox_label', 'submit_checkbox_post'));

    		$this->addDisplayGroup(array($submitImage, $checkBox), 'firstsearch_group'. $val->id, array(
    				'decorators' => array(
    						'FormElements',
    						array('HtmlTag', array('tag' => 'div', 'class' => 'delete_group1')),
    				)));
    	}

    	$submit = new Zend_Form_Element_Submit('delete_picture');
    	$submit->setLabel('Delete');
    	$submit->setAttrib('class', 'but_blue');

    	$this->addElement($submit);

    	$submit ->setDecorators($this->setbulkDecorators('submit_new', 'submit_label', 'submit_post'));

    	$this->addDisplayGroup(array($submit), 'secondsearch_group', array(
    			'decorators' => array(
    					'FormElements',
    					array('HtmlTag', array('tag' => 'div', 'class' => 'delete_group2')),
    			)));

    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
    			'Form'
    	));

    }

    public function setbulkDecorators($htmlTag, $label, $row)
    {
    	$array =
    			array(
    			'ViewHelper',
    			array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class' => ''.$htmlTag.'')),
    			array('Label', array('tag'=>'div', 'class' => ''.$label.'')),
    			array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class' => ''.$row.''))
    	);
    	return $array;
    }

	public function setActive($name)
	{
		$profile = array();

		$tnum = new Profile_Model_Profiles(); $tnum->useDependents(false);

		$dataType = $tnum->fetchProfiles('talentnum = '.USERID, null, null);
		foreach($dataType as $val)
		{
			$profile[] = $val->profile_type;
		}

		if (in_array($name, $profile)) {
			$array = '1';
		} else {
			$array = 'value';
		}

		return $array;
	}
}