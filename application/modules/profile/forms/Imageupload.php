<?php

class Profile_Form_Imageupload extends Zend_Form
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
            'MaxFileSize' 	=> 104857600, // 2097152 bytes = 2 megabytes 10485760
            'validators' 	=> array(
                array('Count', false, 1),
                array('Extension', false, 'gif,jpg,png,jpeg'),
                array('ImageSize', false, array('minwidth' 	=> 50,
                                                'minheight' => 50,
                                                'maxwidth' 	=> 1500,
                                                'maxheight' => 1500))
            )
        ));

        $picture->setValueDisabled(true);

    	$submit = new Zend_Form_Element_Submit('upload_picture');
    	$submit->setLabel('Submit');

    	$values = array($picture, $submit);

    	$this->addElements($values);

    	$submit->setDecorators($this->setbulkDecorators('submit', 'submit_label', 'submit_post'));

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