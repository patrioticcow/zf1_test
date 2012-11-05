<?php

class Application_Form_Auditionsearch extends Zend_Form
{
    public function init()
    {
    	$this->setMethod('post');
    	$this->setAction('/auditions/index/index');

    	$casting = new Zend_Form_Element_Select('checkbox1', array(
      			'multiOptions'=>array('0'=>'Choose a category',
      					'43'=>'Acting-Acrobatics/Stunts', '41'=>'Acting-Comedy/Clown', '42'=>'Acting-Variety Acts',
		                '2'=>'Commercials-Non-SAG', '1'=>'Commercials-SAG', '49'=>'Crew-Acounting/Payroll/HR',
		                '16'=>'Crew-Assistant & Entry Level', '35'=>'Crew-Camera/Editor', '48'=>'Crew-Graphic/Web/Animation',
		                '34'=>'Crew-Lighting/Sound', '37'=>'Crew-Make Up/ Stylist', '51'=>'Crew-Management',
		                '25'=>'Crew-Marketing / PR', '38'=>'Crew-Other', '36'=>'Crew-Producer/Director',
		                '40'=>'Crew-Showbiz Internship', '47'=>'Crew-TV/Radio', '52'=>'Crew-Talent/Casting Mgmt',
		                '50'=>'Crew-Technology/MIS', '39'=>'Crew-Writing/Script/Edit', '3'=>'Dance-Ballet/Classic',
		                '56'=>'Dance-Choreography', '54'=>'Dance-Club/Gogo', '53'=>'Dance-HipHop', '4'=>'Dance-Modern/Jazz',
		                '58'=>'Dance-Other/General', '57'=>'Dance-Teacher', '55'=>'Dance-Traditional/Latin',
		                '7'=>'Episodic TV-AFTRA', '8'=>'Episodic TV-Non-Union', '5'=>'Episodic TV-Pilots', '6'=>'Episodic TV-SAG',
		                '60'=>'Extras', '13'=>'Feature Film-Documentaries', '14'=>'Feature Film-Independent',
		                '10'=>'Feature Film-Non-SAG', '9'=>'Feature Film-SAG', '12'=>'Feature Film-Short Film',
		                '11'=>'Feature Film-Student Films', '17'=>'Industrial/Traning Films', '15'=>'Infomercials', '27'=>'Internet',
		                '19'=>'Modeling-Hair/Cosmetics', '20'=>'Modeling-Print', '18'=>'Modeling-Runway', '44'=>'Music-Band',
		                '45'=>'Music-DJ/Sound', '32'=>'Music-Drums', '30'=>'Music-Horns', '31'=>'Music-Keyboards',
		                '33'=>'Music-Other', '29'=>'Music-Strings', '46'=>'Music-Teacher', '28'=>'Music-Vocals',
		                '21'=>'Music Videos', '59'=>'Reality TV', '22'=>'Theatre-Equity (Union)', '23'=>'Theatre-Non-Equity',
		                '24'=>'Live Events/Promo Model/Trade Shows','26'=>'Voice-Over'
    			)
  		));
    	$casting->setRequired(true);


    	$zip = new Zend_Form_Element_Text('zip');
    	$zip->setValue('Zip Code');
	    $zip->setAttribs(array('onfocus'=>"if(this.value == 'Zip Code') { this.value = ''; }"));

    	$city = new Zend_Form_Element_Select('city', array(
    			'multiOptions'=>array( '0'  => 'Market',
    					'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado',
    					'CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia',
    					'HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa','KS'=>'Kansas',
    					'KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland', 'MA'=>'Massachusetts',
    					'MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana',
    					'NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico',
    					'NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma',
    					'OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota',
    					'TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington',
    					'WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming'
            )
    	));
    	$city->setLabel('or');

    	$submit = new Zend_Form_Element_Submit('search');
    	$submit->setLabel('Search')->class = "but_green";

    	$this->addElements(array($casting, $zip, $city, $submit))
    			->addDisplayGroup(array($casting, $zip, $city ), 'second', array(
    				'decorators'=>array(
    						'FormElements',
    						array('HtmlTag', array('tag'=>'div', 'class'=>'search_group2')),
    			)))
    			->addDisplayGroup(array($submit), 'third', array(
    				'decorators'=>array(
    						'FormElements',
    						array('HtmlTag', array('tag'=>'div', 'class'=>'search_group3')),
    			)))
    	;



    	$casting->setDecorators(array(
    			'ViewHelper',
    			array(array('data'=>'HtmlTag'), array('tag'=>'div', 'class'=>'zend_form_td')),
    			array('Label', array('tag'=>'div', 'class'=>'casting_label')),
    			array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'float_left space'))
    	));
    	$zip->setDecorators(array(
    			'ViewHelper',
    			array(array('data'=>'HtmlTag'), array('tag'=>'div', 'class'=>'zend_form_td')),
    			array('Label', array('tag'=>'div', 'class'=>'casting_label')),
    			array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'float_left'))
    	));
    	$city->setDecorators(array(
    			'ViewHelper',
    			array(array('data'=>'HtmlTag'), array('tag'=>'div', 'class'=>'zend_form_td')),
    			array('Label', array('tag'=>'div', 'class'=>'casting_label')),
    			array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'float_left nospace'))
    	));


        $submit->setDecorators(array(
        	'ViewHelper',
        	array(array('data'=>'HtmlTag'),
        				array('tag'=>'div', 'class'=>'zend_form_tds')
        	),
        	array(array('emptyrow'=>'HtmlTag'),
        				array('tag'=>'div', 'class'=>'zend_form_empty')
        	),
        	array('Label', array('tag'=>'div'))
        ));

        $this->setDecorators(array(
            'FormElements',
        	array('HtmlTag', array('tag'=>'div', 'class'=>'zend_form_table')),
            'Form'
        ));
    }
}