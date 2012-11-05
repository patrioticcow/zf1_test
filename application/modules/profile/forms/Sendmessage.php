<?php

class Profile_Form_Sendmessage extends Zend_Form
{
	public $args;

	public function __construct()
	{
		$this->args = func_get_args();

		parent::__construct();
	}

	public function init()
    {
        $front = Zend_Controller_Front::getInstance();
        $userid = $front->getRequest()->getParam('id');

    	$this->setMethod('post');
    	$this->setAction($this->args[0]['action']);

		$text = new Zend_Form_Element_Textarea('sendme_message');
		$text->setAttrib('rows', '5');
		$text->setAttrib('cols', '60');
        $text->setLabel('Enter Message');

		$from = new Zend_Form_Element_Hidden('from_message');
		$from->setValue(USERID);

		$to = new Zend_Form_Element_Hidden('to_message');
		$to->setValue($userid);

    	$submit = new Zend_Form_Element_Submit('send_message');
    	$submit->setLabel('Send');
    	$submit->setAttrib('class', 'sendamessage');

    	$this->addElement($text);
    	$this->addElement($from);
    	$this->addElement($to);
    	$this->addElement($submit);

    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
    			'Form'
    	));

    }

}