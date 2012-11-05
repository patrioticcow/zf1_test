<?php

class Profile_Form_Imageuploadsecond extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');

        $model = new Profile_Model_Talentgallery();
        $galleryFetch = $model->fetchAll('talentnum = '.USERID.' OR talentnum = 0');

        $group = array();
        if($galleryFetch != null){
            if(is_array($galleryFetch)){
                foreach ($galleryFetch as $value) {
                    $group[$value->getGalleryId()] = $value->getGalleryName();
                }
            } else {
               $group[$galleryFetch->getGalleryId()] = $galleryFetch->getGalleryName();
            }

        }

        $picture = new Zend_Form_Element_File('picture', array(
            'label' => 'Upload Secondary Pictures',
            'required' => true,
            'MaxFileSize' => 104857600, // 2097152 bytes = 2 megabytes
            'validators' => array(
                array('Count', false, 1),
                array('Extension', false, 'gif,jpg,png,jpeg'),
                array('ImageSize', false, array('minwidth' => 100,
                                                'minheight' => 100,
                                                'maxwidth' => 1000,
                                                'maxheight' => 1000))
            )
        ));

        $picture->setValueDisabled(true);


        $gallery = new Zend_Form_Element_Select('user_gallery');
        $gallery->addMultiOptions($group);
        $gallery->setLabel('Select a gallery for your pictures');


    	$submit = new Zend_Form_Element_Submit('upload_picture_second');
    	$submit->setLabel('Submit');

    	$values = array($picture, $gallery, $submit);

    	$this->addElements($values);

    	$submit 	->setDecorators($this->setbulkDecorators('submit', 'submit_label', 'submit_post'));

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