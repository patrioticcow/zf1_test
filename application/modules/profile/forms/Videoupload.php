<?php

class Profile_Form_Videoupload extends Zend_Form
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
	    $this->setAction($this->args[0]['action']);

        $file = new Zend_Form_Element_File('file');
       	$file->setLabel('File')
           	->setRequired(true)
           	->setDestination('/var/www/multimedia/temp')
           	->addValidator('Size', false, array('min' => '10kB', 'max' => '100MB'))
            ->addValidator('Extension', false, 'avi,mov,wmv,mpeg,flv,mpg');

        $title = new Zend_Form_Element_Text('video_title');
	    $title->setRequired(true);
        $title->setLabel('Video Title*');

        $description = new Zend_Form_Element_Textarea('video_description');
    	$description->setLabel('Video Description')->setAttrib('rows', '3');

    	$submit = new Zend_Form_Element_Submit('upload_video');
    	$submit->setLabel('Submit');

    	$values = array( $file, $title, $description, $submit);

    	$this->addElements($values);
    	$this->setAttrib('enctype', 'multipart/form-data');

    	//$submit->setDecorators($this->setbulkDecorators('submit', 'submit_label', 'submit_post'));

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

}