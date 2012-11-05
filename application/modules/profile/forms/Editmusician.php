<?php

class Profile_Form_Editmusician extends Zend_Form
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
			$args = $this->args[1][0];
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

		$musName = new Zend_Form_Element_Text('band_name');
		$musName->setValue($args->band_name)->setLabel('Musician / Band Name');

		$talentOptions = array( '0' => 'Select One', '5' => 'Player', '2' => 'Singer', '3' => 'Song Writer',
								'6' => 'Lyricist', '1' => 'DJ', '4' => 'Teacher', '7' => 'Sound Man', '8' => 'Composer', '9' => 'Conductor');

		$talentOne = new Zend_Form_Element_Select('music_type2', array(
			'multiOptions' => $talentOptions,
			'value' => $args->music_type2
		));
		$talentOne->setLabel('First Talent Type');

		$talentTwo = new Zend_Form_Element_Select('music_type3', array(
			'multiOptions' => $talentOptions,
			'value' => $args->music_type3
		));
		$talentTwo->setLabel('Second Talent Type');

		$talentThree = new Zend_Form_Element_Select('music_type4', array(
			'multiOptions' => $talentOptions,
			'value' => $args->music_type4
		));
		$talentThree->setLabel('Third Talent Type');

		$talentFour = new Zend_Form_Element_Select('music_type5', array(
			'multiOptions' => $talentOptions,
			'value' => $args->music_type5
		));
		$talentFour->setLabel('Forth Talent Type');

		$band = new Zend_Form_Element_Select('band_type', array(
				'multiOptions' => array( '0' => 'Select One', 'band' => 'Band', 'orchestra' => 'Orchestra'),
				'value' => $args->band_type
		));
		$band->setLabel('Band Type');

		$genreOptions = array( '0' => 'Select One',
						'Acid' => 'Acid', 'Acid Jazz' => 'Acid Jazz', 'Acoustic' => 'Acoustic', 'Acoustic Blues' => 'Acoustic Blues', 'Alternative' => 'Alternative',
						'Ambient' => 'Ambient', 'Americana' => 'Americana', 'Baroque' => 'Baroque', 'Black Metal' => 'Black Metal', 'Blue Grass' => 'Blue Grass',
						'Blues' => 'Blues', 'Blues Rock' => 'Blues Rock', 'Brit Pop' => 'Brit Pop', 'Christian' => 'Christian', 'Classic Rock' => 'Classic Rock',
						'Classical' => 'Classical', 'Comedy' => 'Comedy', 'Contemporary Christian' => 'Cont. Christian', 'Country' => 'Country', 'Dance' => 'Dance',
						'Death Metal' => 'Death Metal', 'Drum N Bass' => 'Drum N Bass', 'Electronic' => 'Electronic', 'Emo' => 'Emo', 'Experimental' => 'Experimental',
						'Folk' => 'Folk', 'Folk Rock' => 'Folk Rock', 'Funk' => 'Funk', 'Fusion' => 'Fusion', 'Glam' => 'Glam', 'Gospel Rap' => 'Gospel Rap',
						'Gothic' => 'Gothic', 'Grunge' => 'Grunge', 'Hard Rock' => 'Hard Rock', 'Hardcore' => 'Hardcore', 'Hardcore Metal' => 'Hardcore Metal',
						'Heavy Metal' => 'Heavy Metal', 'Heavy Rock' => 'Heavy Rock', 'Hip Hop' => 'Hip Hop', 'House' => 'House', 'Indie' => 'Indie',
						'Industrial' => 'Industrial', 'Instrumental' => 'Instrumental', 'International' => 'International', 'Jam Band' => 'Jam Band', 'Jazz' => 'Jazz',
						'Latin' => 'Latin', 'Latin Jazz' => 'Latin Jazz', 'Metal' => 'Metal', 'Metalcore' => 'Metalcore', 'New Age' => 'New Age', 'New Country' => 'New Country',
						'Other' => 'Other', 'Pop' => 'Pop', 'Pop Punk' => 'Pop Punk', 'Post Hardcore' => 'Post Hardcore', 'Post Rock' => 'Post Rock',
						'Progressive' => 'Progressive', 'Psychedelic' => 'Psychedelic', 'Punk' => 'Punk', 'R&amp;B' => 'R&amp;B ', 'Rap' => 'Rap', 'Rapcore' => 'Rapcore',
						'Reggae' => 'Reggae', 'Rock' => 'Rock', 'Rockabilly' => 'Rockabilly', 'Salsa' => 'Salsa', 'Screamo' => 'Screamo', 'Ska' => 'Ska',
						'Soft Rock' => 'Soft Rock', 'Soul' => 'Soul', 'Soundtrack' => 'Soundtrack', 'Spoken Word' => 'Spoken Word', 'Swing' => 'Swing', 'Techno' => 'Techno',
						'Trance' => 'Trance', 'Trash Metal' => 'Trash Metal', 'World' => 'World', 'World Fusion' => 'World Fusion');

		$genreOne = new Zend_Form_Element_Select('genre', array(
				'multiOptions' => $genreOptions,
				'value' => $args->genre
		));
		$genreOne->setLabel('First Genre Type');

		$genreTwo = new Zend_Form_Element_Select('genre2', array(
				'multiOptions' => $genreOptions,
				'value' => $args->genre2
		));
		$genreTwo->setLabel('Second Genre Type');

		$genreThree = new Zend_Form_Element_Select('genre3', array(
				'multiOptions' => $genreOptions,
				'value' => $args->genre3
		));
		$genreThree->setLabel('Third Genre Type');

		$genreFour = new Zend_Form_Element_Select('genre4', array(
				'multiOptions' => $genreOptions,
				'value' => $args->genre4
		));
		$genreFour->setLabel('Fourth Genre Type');

		$recordLabel = new Zend_Form_Element_Text('record_label');
		$recordLabel->setValue($args->record_label)->setLabel('Record Label');

		$labelType = new Zend_Form_Element_Text('label_type');
		$labelType->setValue($args->label_type)->setLabel('Label Type');

		$gigsnr = new Zend_Form_Element_Select('number_of_gigs', array(
				'multiOptions' => array( '99' => 'Select One', '0' => '0', '10' => '< 10', '20' => '10 - 20', '50' => '20 - 50', '100' => '50 - 100', '1000' => '> 100'),
				'value' => $args->number_of_gigs
		));
		$gigsnr->setLabel('Number of Gigs');

		$experience = new Zend_Form_Element_Select('years_experience', array(
				'multiOptions' => array( '99' => 'Select One', '0' => '< 1', '1' => '1 - 2', '2' => '2 - 5', '5' => '5 - 7', '7' => '7 - 10', '10' => '> 10'),
				'value' => $args->years_experience
		));
		$experience->setLabel('Years Experience');

		$management = new Zend_Form_Element_Select('management', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => $args->management
		));
		$management->setLabel('Management');

		$bandmember = new Zend_Form_Element_Select('searching_band', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => $args->searching_band
		));
		$bandmember->setLabel('Searching for a Band Member');

		$gigsearch = new Zend_Form_Element_Select('searching_gig', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => $args->searching_gig
		));
		$gigsearch->setLabel('Currently Looking for a gig');

		$studio = new Zend_Form_Element_Select('studio_musician', array(
				'multiOptions' => array( '99' => 'Select One', '1' => 'Yes', '0' => 'No'),
				'value' => $args->studio_musician
		));
		$studio->setLabel('Studio Musician');

		$instruments = new Zend_Form_Element_Text('music_instruments');
		$instruments->setValue($args->music_instruments)->setLabel('List the instruments you can play');

		$websites = new Zend_Form_Element_Text('websites');
		$websites->setValue($args->website)->setLabel('Website');

		$musicinfo = new Zend_Form_Element_Textarea('des_1');
		$musicinfo->setValue($args->des_1)->setLabel('Musician Information')->setAttrib('rows', '5');

		$influences = new Zend_Form_Element_Textarea('major_influence');
		$influences->setValue($args->major_influence)->setLabel('Influences')->setAttrib('rows', '5');

		$bandmembermem = new Zend_Form_Element_Textarea('searching_band_mem');
		$bandmembermem->setValue($args->searching_band_mem)->setLabel('List the band members you are looking for')->setAttrib('rows', '2');

		$gigsearchmem = new Zend_Form_Element_Textarea('searching_gig_des');
		$gigsearchmem->setValue($args->searching_gig_des)->setLabel('Gig description')->setAttrib('rows', '5');

		$submit = new Zend_Form_Element_Submit('edit_acting_profile');
		$submit->setLabel('Submit');
		$submit->setAttrib('class', 'but_blue');

		$values = array($city, $musName, $talentOne, $talentTwo, $talentThree, $talentFour,
				$band, $genreOne, $genreTwo, $genreThree, $genreFour, $recordLabel, $labelType, $gigsnr,
				$experience, $management, $studio, $instruments, $websites, $musicinfo, $influences, $bandmembermem, $gigsearchmem, $submit);

		$this->addElements($values);

		$submit ->setDecorators($this->setbulkDecorators('submit_new', 'submit_label', 'submit_post'));

		$this->addDisplayGroup(array($city, $musName, $talentOne, $talentTwo, $talentThree, $talentFour, $band, $genreOne, $genreTwo), 'firstmusicf_group', array());
		$this->addDisplayGroup(array($genreThree, $genreFour, $recordLabel, $labelType, $gigsnr, $experience, $management, $studio), 'secondmusicf_group', array());
		$this->addDisplayGroup(array($bandmember, $bandmembermem, $gigsearch, $gigsearchmem, $instruments, $websites, $musicinfo, $influences), 'thirdmusicf_group', array());
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