<?php

class Profile_Form_Enableprofile extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');

	    $profile = $this->setActive();

	    $acting = $music = $dance = 'value';
	    if (in_array('acting', $profile)) {
		    $acting = '1';
	    }
	    if (in_array('music', $profile)) {
		    $music = '1';
	    }
	    if (in_array('dance', $profile)) {
	        $dance = '1';
        }

    	$acting = new Zend_Form_Element_Radio('acting', array(
    			'multiOptions' => array(
    					'1' => 'Active',
    					'0' => 'Not Active'
    			),
    			'label' => 'Acting/Modeling Profile',
    			'value' => $acting,
    			'separator' => ' '
    	));
    	$musician = new Zend_Form_Element_Radio('musician', array(
    			'multiOptions' => array(
    					'1' => 'Active',
    					'0' => 'Not Active'
    			),
    			'label' => 'Musician Profile',
    			'value' => $music,
    			'separator' => ' '
    	));
    	$dancer = new Zend_Form_Element_Radio('dancer', array(
    			'multiOptions' => array(
    					'1' => 'Active',
    					'0' => 'Not Active'
    			),
    			'label' => 'Dancer Profile',
    			'value' => $dance,
    			'separator' => ' '
    	));

    	$submit = new Zend_Form_Element_Submit('enable_profiles');
    	$submit->setLabel('Set');

    	$values = array($acting, $musician, $dancer, $submit);

    	$this->addElements($values);

    	$acting 	->setDecorators($this->setbulkDecorators('enable_acting', 'enable_acting_label', 'enable_acting_post profiles_main'));
    	$musician 	->setDecorators($this->setbulkDecorators('enable_musicians', 'enable_musicians_label', 'enable_musicians_post profiles_main'));
    	$dancer 	->setDecorators($this->setbulkDecorators('enable_dancer', 'enable_dancer_label', 'enable_dancer_post profiles_main'));
    	$submit 	->setDecorators($this->setbulkDecorators('submit', 'submit_label', 'submit_post'));

    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('tag' => 'div', 'class' => 'exposure_search_form')),
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

	public function setActive()
	{
		$profile = array();

		$tnum = new Profile_Model_Profiles(); $tnum->useDependents(false);

		$userid =  Application_Model_Functions::userid();

		$dataType = $tnum->fetchProfiles('talentnum = '.$userid, null, null);
		foreach($dataType as $val)
		{
			$profile[] = $val->profile_type;
		}

		return $profile;
	}

}