<?php

class Profile_Form_Addcategory extends Zend_Form
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

		$gallery = new Zend_Form_Element_Text('gallery');
		$gallery->setLabel('Gallery Name');
		$gallery->setRequired(true);

		$submit = new Zend_Form_Element_Submit('add_gallery');
		$submit->setLabel('Create Gallery');
		$submit->setAttrib('class', 'but_blue');

		$this->addElements(array($gallery, $submit));

		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
				'Form'
		));

	}

}