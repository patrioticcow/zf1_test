<?php

class Application_Form_Cdlogin extends Zend_Form
{
	public function init()
	{
		$this->addElement('text', 'login', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'validators' => array(
				'Alnum',
				array('StringLength', false, array(3, 20)),
			),
			'required'   => true,
			'label'      => 'Login:',
		));

		$this->addElement('password', 'pass', array(
			'filters'    => array('StringTrim'),
			'validators' => array(
				'Alnum',
				array('StringLength', false, array(4, 20)),
			),
			'required'   => true,
			'label'      => 'Password:',
		));

		$this->addElement('submit', 'login_button', array(
			'required' => false,
			'ignore'   => true,
			'label'    => 'Login',
			'class'    => 'but_green login_inside'
		));

		// We want to display a 'failed authentication' message if necessary;
		// we'll do that with the form 'description', so we need to add that
		// decorator.
		$this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
			array('Description', array('placement' => 'prepend')),
			'Form'
		));
	}
}