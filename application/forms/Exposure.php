<?php

class Application_Form_Exposure extends Zend_Form
{
    public function init()
    {
    	$this->setMethod('post');

    	$email = new Zend_Form_Element_Text('email');
    	$email->setValue('Email')->setRequired(true)->set;

    	$name = new Zend_Form_Element_Text('name');
    	$name->setValue('Name')->setRequired(true);

    	$phone = new Zend_Form_Element_Text('phone');
    	$phone->setValue('Phone')->setRequired(true);


    	$submit = new Zend_Form_Element_Submit('search');
    	$submit->setLabel('Search');

    	$this->addElements(array($email, $name, $phone, $submit));


        $email->setDecorators(array(
        		'ViewHelper',
        		array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class' => 'zend_form_tdc')),
        		array('Label', array('tag'=>'div')),
        		array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class' => 'exposure_email'))
        ));
        $name->setDecorators(array(
        		'ViewHelper',
        		array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class' => 'zend_form_tdc')),
        		array('Label', array('tag'=>'div')),
        		array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class' => 'exposure_name'))
        ));
        $phone->setDecorators(array(
        		'ViewHelper',
        		array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class' => 'zend_form_tdc')),
        		array('Label', array('tag'=>'div')),
        		array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class' => 'exposure_phone'))
        ));
        $submit->setDecorators(array(
        	'ViewHelper',
        	array(array('emptyrow'=>'HtmlTag'), array('tag' => 'div', 'class' => 'exposure')),
        	array('Label', array('tag'=>'div'))
        ));

        $this->setDecorators(array(
            'FormElements',
        	array('HtmlTag', array('tag' => 'div', 'class' => 'exposure_form')),
            'Form'
        ));
    }
}
