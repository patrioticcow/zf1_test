<?php

class Profile_Form_Editinterests extends Zend_Form
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

    	$model = new Talents_Model_Talentinfo2();
    	$prop = $model->fetchAll('talentnum = '.USERID, null, 1);

		$interests = array();
		if($prop->_interest_1 == 1){
			array_push($interests, 'interest_1');
		}
		if($prop->_interest_2 == 1){
			array_push($interests, 'interest_2');
		}
		if($prop->_interest_3 == 1){
			array_push($interests, 'interest_3');
		}
		if($prop->_interest_4 == 1){
			array_push($interests, 'interest_4');
		}
		if($prop->_interest_5 == 1){
			array_push($interests, 'interest_5');
		}

		$interest = new Zend_Form_Element_MultiCheckbox('interest', array(
					'multiOptions' => array(
				        'interest_1' => 'Acting',
				        'interest_2' => 'Modeling',
				        'interest_3' => 'Dance',
				        'interest_4' => 'Music',
				        'interest_5' => 'Crew',
				    ),
				'value' => $interests
		));
		$interest->setLabel("I'm interested in: ");



		$submit = new Zend_Form_Element_Submit('edit_talent_interests');
		$submit->setLabel('Submit Interest');
		$submit->setAttrib('class', 'but_blue');

		$this->addElements(array($interest,  $submit));

		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
				'Form'
		));

	}

}