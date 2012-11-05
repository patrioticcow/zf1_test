<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $user_login = $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                
                array('StringLength', false, array(3, 20)),
            ),
            'required'   => true,
            'label'      => 'Login:',
        ));

        $password = $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                
                array('StringLength', false, array(4, 20)),
            ),
            'required'   => true,
            'label'      => 'Password:',
        ));

        $login = $this->addElement('submit', 'login_button', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
        	'class'    => 'but_green login_inside'
        ));
        
        $this->addElement('hidden', 'si', array(
        		'value' => Zend_Session::getId()
        ));

    	$refpage = $this->addElement('hidden', 'usertype', array(
            'value' => 'talent'
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
