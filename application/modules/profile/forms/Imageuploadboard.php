<?php

class Profile_Form_Imageuploadboard extends Zend_Form
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

        $picture = new Zend_Form_Element_File('picture', array(
            'class' 		=> 'picture_main',
            'id' 		    => 'file_upload',
            'name' 		    => 'file_upload',
            'required' 		=> true,
            'MaxFileSize' 	=> 104857600, // 2097152 bytes = 2 megabytes
            'validators' 	=> array(
                array('Count', false, 1),
                array('Extension', false, 'gif,jpg,png,jpeg'),
                array('ImageSize', false, array('minwidth' 	=> 560,
                                                'maxwidth' 	=> 1500,
                                                'maxheight' => 1500))
            )
        ));

        $picture->setValueDisabled(true);

    	$submit = new Zend_Form_Element_Submit('upload_picture_cover');
    	$submit->setLabel('Submit');

    	$values = array($picture, $submit);

    	$this->addElements($values);

    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
    			'Form'
    	));

    }

}