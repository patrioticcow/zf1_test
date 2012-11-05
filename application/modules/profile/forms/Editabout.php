<?php

class Profile_Form_Editabout extends Zend_Form
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
    	$about = '';
    	$id = '';

    	if(isset($this->args[1][0])){
    		$args = $this->args[1][0];

    		if(isset($args->type)){
    			$about 	= $args->about;
    			$id 	= $args->type;
    		} else {
    			$about 	= $args->special_skills;
    			$id 	= $args->talentnum;
    		}
    	}

		$text = new Zend_Form_Element_Textarea('edit_about');
		$text->setValue($about);
		$text->setAttrib('rows', '10');
		$text->setAttrib('cols', '84');

		$hidden = new Zend_Form_Element_Hidden('id');
		$hidden->setValue($id);

    	$submit = new Zend_Form_Element_Submit('edit_abouts');
    	$submit->setLabel('Submit');
    	$submit->setAttrib('class', 'but_blue');

    	$this->addElement($hidden);
    	$this->addElement($text);
    	$this->addElement($submit);

    	$text 	->setDecorators($this->setbulkDecorators('text_new', 'text_new', 'text_new'));
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