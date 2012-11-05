<?php

class Profile_Form_Editdance extends Zend_Form
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

		$talentnum = Application_Model_Functions::userid();
    	$model = new Talents_Model_Talentinfo2();
    	$prop = $model->fetchAll('talentnum = '.$talentnum);

		if(isset($this->args[1])){
			$args = $this->args[1];
		}

        $cityes = array( 'null' =>'Select One',
            'Albany, NY' => 'Albany, NY','Albuquerque, NM' => 'Albuquerque, NM','Atlanta, GA' => 'Atlanta, GA','Augusta, ME' => 'Augusta, ME',
            'Austin, TX' => 'Austin, TX','Baltimore, MD' => 'Baltimore, MD','Billings, MT' => 'Billings, MT','Birmingham, AL' => 'Birmingham, AL',
            'Boise, ID' => 'Boise, ID','Boston, MA' => 'Boston, MA','Buffalo, NY' => 'Buffalo, NY','Charleston, SC' => 'Charleston, SC',
            'Charleston, WV' => 'Charleston, WV','Charlotte, NC' => 'Charlotte, NC','Cheyenne, WY' => 'Cheyenne, WY','Chicago, IL' => 'Chicago, IL',
            'Cleveland, OH' => 'Cleveland, OH','Columbia, SC' => 'Columbia, SC','Columbus, OH' => 'Columbus, OH','Dallas, TX' => 'Dallas, TX',
            'Denver, CO' => 'Denver, CO','Des Moines, IA' => 'Des Moines, IA','Detroit, MI' => 'Detroit, MI','El Paso, TX' => 'El Paso, TX',
            'Fargo, ND' => 'Fargo, ND','Grand Junction, CO' => 'Grand Junction, CO','Hartford, CT' => 'Hartford, CT','Honolulu, HI' => 'Honolulu, HI',
            'Houston, TX' => 'Houston, TX','Indianapolis, IN' => 'Indianapolis, IN','Jackson, MS' => 'Jackson, MS','Jacksonville, FL' => 'Jacksonville, FL',
            'Kansas City, KS' => 'Kansas City, KS','Kansas City, MO' => 'Kansas City, MO','Las Vegas, NV' => 'Las Vegas, NV','Little Rock, AR' => 'Little Rock, AR',
            'Los Angeles, CA' => 'Los Angeles, CA','Louisville, KY' => 'Louisville, KY','Memphis, TN' => 'Memphis, TN','Miami, FL' => 'Miami, FL',
            'Milwaukee, WI' => 'Milwaukee, WI','Minneapolis, MN' => 'Minneapolis, MN','Nashville, TN' => 'Nashville, TN','New Orleans, LA' => 'New Orleans, LA',
            'New York City, NY' => 'New York City, NY','Norfolk, VA' => 'Norfolk, VA','Oklahoma City, OK' => 'Oklahoma City, OK',
            'Omaha, NE' => 'Omaha, NE','Orlando, FL' => 'Orlando, FL','Philadelphia, PA' => 'Philadelphia, PA','Phoenix, AZ' => 'Phoenix, AZ',
            'Pittsburgh, PA' => 'Pittsburgh, PA','Portland, ME' => 'Portland, ME','Portland, OR' => 'Portland, OR','Raleigh, NC' => 'Raleigh, NC',
            'Rapid City, SD' => 'Rapid City, SD','Reno, NV' => 'Reno, NV','St Louis, MO' => 'St Louis, MO','Salt Lake City, UT' => 'Salt Lake City, UT',
            'San Antonio, TX' => 'San Antonio, TX','San Diego, CA' => 'San Diego, CA','San Francisco, CA' => 'San Francisco, CA','Seattle, WA' => 'Seattle, WA',
            'Tampa, FL' => 'Tampa, FL','Washington, DC' => 'Washington, DC','Wichita, KS' => 'Wichita, KS','Calgary-Edmonton',
            'Ottawa, ON' => 'Ottawa, ON','Montreal, QC' => 'Montreal, QC','Toronto, ON' => 'Toronto, ON','Vancouver, BC' => 'Vancouver, BC',
            'London' => 'London','Birmingham, UK' => 'Birmingham, UK','Leeds/North' => 'Leeds/North','Scotland' => 'Scotland','Ireland' => 'Ireland',
            'Wales' => 'Wales','New SW / Sydney' => 'New SW / Sydney','Victoria / Melbourne' => 'Victoria / Melbourne','Queensland/Brisbane',
            'West / Perth' => 'West / Perth','South / Adelaide' => 'South / Adelaide','Auckland' => 'Auckland','Wellington' => 'Wellington'
        );

		$city = new Zend_Form_Element_Select('city', array(
				'multiOptions' => $cityes,
				'value' => $prop->getCity1()
		));
		$city->setLabel('City');

		$danceName = new Zend_Form_Element_Text('group_name');
		$danceName->setValue(isset($args) ? $args->getGroupName() : '')->setLabel('Dancer / Group Name');

		$talentOptions = array( '0' => 'Select One', 'Ballet' => 'Ballet', 'Ballroom' => 'Ballroom', 'Break' => 'Break', 'Club' => 'Club', 'Folk' => 'Folk',
				'Hip Hop' => 'Hip Hop', 'Jazz' => 'Jazz', 'House' => 'House', 'Line' => 'Line', 'Modern' => 'Modern', 'Rave' => 'Rave', 'Salsa' => 'Salsa',
				'Swing' => 'Swing', 'Tango' => 'Tango', 'Tap' => 'Tap');

		$talentOne = new Zend_Form_Element_Select('dance_style_1', array(
			'multiOptions' => $talentOptions,
			'value' => isset($args) ? $args->_dance_style_1 : ''
		));
		$talentOne->setLabel('First Dance Style');

		$talentTwo = new Zend_Form_Element_Select('dance_style_2', array(
			'multiOptions' => $talentOptions,
			'value' => isset($args) ? $args->_dance_style_2 : ''
		));
		$talentTwo->setLabel('Second Dance Style');

		$talentThree = new Zend_Form_Element_Select('dance_style_3', array(
			'multiOptions' => $talentOptions,
			'value' => isset($args) ? $args->_dance_style_3 : ''
		));
		$talentThree->setLabel('Third Dance Style');

		$talentFour = new Zend_Form_Element_Select('dance_style_4', array(
			'multiOptions' => $talentOptions,
			'value' => isset($args) ? $args->_dance_style_4 : ''
		));
		$talentFour->setLabel('Fourth Dance Style');

		$numPeopleGroup = new Zend_Form_Element_Select('num_ppl_in_group', array(
				'multiOptions' => array( '99' => 'Select One', '0' => 'None', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
						'8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12'),
				'value' => isset($args) ? $args->_num_ppl_in_group : '',
				'label' => 'People in Group'
		));

		$perfomnr = new Zend_Form_Element_Select('num_of_perfom', array(
				'multiOptions' => array( '99' => 'Select One', '0' => '0', '10' => '< 10', '20' => '10 - 20', '50' => '20 - 50', '100' => '50 - 100', '1000' => '> 100'),
				'value' => isset($args) ? $args->_num_of_perfom : ''
		));
		$perfomnr->setLabel('Number of Gigs');

		$experience = new Zend_Form_Element_Select('years_experience', array(
				'multiOptions' => array( '99' => 'Select One', '0' => '< 1', '1' => '1 - 2', '2' => '2 - 5', '5' => '5 - 7', '7' => '7 - 10', '10' => '> 10'),
				'value' => isset($args) ? $args->_years_experience : ''
		));
		$experience->setLabel('Years Experience');

		$management = new Zend_Form_Element_Select('management', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => isset($args) ? $args->_management : ''
		));
		$management->setLabel('Management');

		$websites = new Zend_Form_Element_Text('websites');
		$websites->setValue(isset($args) ? $args->_website : '')->setLabel('Website');

		$dancerbg = new Zend_Form_Element_Textarea('dancer_background');
		$dancerbg->setValue(isset($args) ? $args->_dancer_background : '')->setLabel('Dancer Backgroud')->setAttrib('rows', '8');

		$searchinggig = new Zend_Form_Element_Select('searching_gig', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => isset($args) ? $args->_searching_gig : ''
		));
		$searchinggig->setLabel('Currently Looking for a gig');

		$searchinggroup = new Zend_Form_Element_Select('searching_group_mem_des', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => isset($args) ? $args->_searching_group_mem_des : ''
		));
		$searchinggroup->setLabel('Searching for a Group');

		$influences = new Zend_Form_Element_Textarea('influences');
		$influences->setValue(isset($args) ? $args->_influences : '')->setLabel('Influences')->setAttrib('rows', '8');

		$gigsearchdes = new Zend_Form_Element_Textarea('searching_gig_des');
		$gigsearchdes->setValue(isset($args) ? $args->_searching_gig_des : '')->setLabel('Gig description')->setAttrib('rows', '8');

		$submit = new Zend_Form_Element_Submit('edit_dance_profile');
		$submit->setLabel('Submit');
		$submit->setAttrib('class', 'but_blue');

		$values = array($city, $danceName, $talentOne, $talentTwo, $talentThree, $talentFour, $numPeopleGroup, $perfomnr, $experience, $management,
				$websites, $dancerbg, $influences, $searchinggig, $gigsearchdes, $searchinggroup, $submit);

		$this->addElements($values);

		$submit ->setDecorators($this->setbulkDecorators('submit_new', 'submit_label', 'submit_post'));

		$this->addDisplayGroup(array($city, $danceName, $talentOne, $talentTwo, $talentThree), 'firstmusicf_group', array());
		$this->addDisplayGroup(array($talentFour, $numPeopleGroup, $perfomnr, $experience, $management), 'secondmusicf_group', array());
		$this->addDisplayGroup(array($websites, $dancerbg, $influences, $searchinggig, $gigsearchdes, $searchinggroup ), 'thirdmusicf_group', array());
		$this->addDisplayGroup(array( $submit), 'forthmusicf_group', array());

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