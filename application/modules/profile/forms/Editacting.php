<?php

class Profile_Form_Editacting extends Zend_Form
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
            'Tampa, FL' => 'Tampa, FL','Washington, DC' => 'Washington, DC','Wichita, KS' => 'Wichita, KS'
        );

		$city = new Zend_Form_Element_Select('city', array(
				'multiOptions' => $cityes,
				'value' => $args
		));
		$city->setLabel('City');

		$height = new Zend_Form_Element_Select('height', array(
				'multiOptions' => array( "" => "Select One",
						"22" => "< 2'0 ", "24" => "2'0 ", "25" => "2'1 ", "26" => "2'2 ", "27" => "2'3 ", "28" => "2'4 ", "29" => "2'5 ",
						"30" => "2'6 ", "31" => "2'7 ", "32" => "2'8 ", "33" => "2'9 ", "34" => "2'10 ", "35" => "2'11 ", "36" => "3'0 ", "37" => "3'1 ",
						"38" => "3'2 ", "39" => "3'3 ", "40" => "3'4 ", "41" => "3'5 ", "42" => "3'6 ", "43" => "3'7 ", "44" => "3'8 ", "45" => "3'9 ",
						"46" => "3'10 ", "47" => "3'11 ", "48" => "4'0 ", "49" => "4'1 ", "50" => "4'2 ", "51" => "4'3 ", "52" => "4'4 ", "53" => "4'5 ",
						"54" => "4'6 ", "55" => "4'7 ", "56" => "4'8 ", "57" => "4'9 ", "58" => "4'10 ", "59" => "4'11 ", "60" => "5'0 ", "61" => "5'1 ",
						"62" => "5'2 ", "63" => "5'3 ", "64" => "5'4 ", "65" => "5'5 ", "66" => "5'6 ", "67" => "5'7 ", "68" => "5'8 ", "69" => "5'9 ",
						"70" => "5'10 ", "71" => "5'11 ", "72" => "6'0 ", "73" => "6'1 ", "74" => "6'2 ", "75" => "6'3 ", "76" => "6'4 ", "77" => "6'5 ",
						"78" => "6'6 ", "79" => "6'7 ", "80" => "6'8 ", "81" => "6'9 ", "82" => "6'10 ", "83" => "6'11 ", "84" => "7'0 ", "85" => "7'1 ",
						"86" => "7'2 ", "87" => "7'3 ", "88" => "7'4 ", "89" => "7'5 ", "90" => "7'6 ", "91" => "7'7 ", "92" => "7'8 ", "93" => "7'9 ",
						"94" => "7'10 ", "95" => "7'11 ", "96" => "8'0 ", "97" => "> 8'0 "
				),
				'value' => $args['height']
		));
		$height->setLabel('Height');

		$weight = new Zend_Form_Element_Select('weight', array(
				'multiOptions' => array(
						'35' => '<40 lbs (18.0 kg)', '40' => '40 lbs (18.0 kg)', '42' => '42 lbs (19.0 kg)', '44' => '44 lbs (20.0 kg)', '46' => '46 lbs (20.5 kg)',
						'48' => '48 lbs (21.5 kg)', '50' => '50 lbs (22.5 kg)', '52' => '52 lbs (23.5 kg)', '54' => '54 lbs (24.5 kg)', '56' => '56 lbs (25.0 kg)',
						'58' => '58 lbs (26.0 kg)', '60' => '60 lbs (27.0 kg)', '62' => '62 lbs (28.0 kg)', '64' => '64 lbs (29.0 kg)', '66' => '66 lbs (30.0 kg)',
						'68' => '68 lbs (30.5 kg)', '70' => '70 lbs (31.5 kg)', '72' => '72 lbs (32.5 kg)', '74' => '74 lbs (33.5 kg)', '76' => '76 lbs (34.0 kg)',
						'78' => '78 lbs (35.0 kg)', '80' => '80 lbs (36.5 kg)', '82' => '82 lbs (37.0 kg)', '84' => '84 lbs (38.0 kg)', '86' => '86 lbs (39.0 kg)',
						'88' => '88 lbs (40.0 kg)', '90' => '90 lbs (41.0 kg)', '92' => '92 lbs (41.5 kg)', '94' => '94 lbs (42.5 kg)', '96' => '96 lbs (43.5 kg)',
						'98' => '98 lbs (44.5 kg)', '100' => '100 lbs (45.5 kg)', '102' => '102 lbs (46.5 kg)', '104' => '104 lbs (47.0 kg)', '106' => '106 lbs (48.0 kg)',
						'108' => '108 lbs (49.0 kg)', '110' => '110 lbs (50.0 kg)', '112' => '112 lbs (51.0 kg)', '114' => '114 lbs (51.5 kg)', '116' => '116 lbs (52.5 kg)',
						'118' => '118 lbs (53.5 kg)', '120' => '120 lbs (54.5 kg)', '122' => '122 lbs (55.5 kg)', '124' => '124 lbs (56.0 kg)', '126' => '126 lbs (57.0 kg)',
						'128' => '128 lbs (58.0 kg)', '130' => '130 lbs (59.0 kg)', '132' => '132 lbs (60.0 kg)', '134' => '134 lbs (61.0 kg)', '136' => '136 lbs (61.5 kg)',
						'138' => '138 lbs (62.5 kg)', '140' => '140 lbs (63.5 kg)', '142' => '142 lbs (64.5 kg)', '144' => '144 lbs (65.5 kg)', '146' => '146 lbs (66.0 kg)',
						'148' => '148 lbs (67.0 kg)', '150' => '150 lbs (68.0 kg)', '152' => '152 lbs (69.0 kg)', '154' => '154 lbs (70.0 kg)', '156' => '156 lbs (71.0 kg)',
						'158' => '158 lbs (71.5 kg)', '160' => '160 lbs (72.5 kg)', '162' => '162 lbs (73.5 kg)', '164' => '164 lbs (74.5 kg)', '166' => '166 lbs (75.5 kg)',
						'168' => '168 lbs (76.0 kg)', '170' => '170 lbs (77.0 kg)', '172' => '172 lbs (78.0 kg)', '174' => '174 lbs (79.0 kg)', '176' => '176 lbs (80.0 kg)',
						'178' => '178 lbs (80.5 kg)', '180' => '180 lbs (81.5 kg)', '182' => '182 lbs (82.5 kg)', '184' => '184 lbs (83.5 kg)', '186' => '186 lbs (84.5 kg)',
						'188' => '188 lbs (85.5 kg)', '190' => '190 lbs (86.0 kg)', '192' => '192 lbs (87.0 kg)', '194' => '194 lbs (88.0 kg)', '196' => '196 lbs (89.0 kg)',
						'198' => '198 lbs (90.0 kg)', '200' => '200 lbs (90.5 kg)', '202' => '202 lbs (91.5 kg)', '204' => '204 lbs (92.5 kg)', '206' => '206 lbs (93.5 kg)',
						'208' => '208 lbs (94.5 kg)', '210' => '210 lbs (95.5 kg)', '212' => '212 lbs (96.0 kg)', '214' => '214 lbs (97.0 kg)', '216' => '216 lbs (98.0 kg)',
						'218' => '218 lbs (99.0 kg)', '210' => '220 lbs (100.0 kg)', '222' => '222 lbs (100.5 kg)', '224' => '224 lbs (101.5 kg)', '226' => '226 lbs (102.5 kg)',
						'228' => '228 lbs (103.5 kg)', '220' => '230 lbs (104.5 kg)', '230' => '232 lbs (105.0 kg)', '234' => '234 lbs (106.0 kg)', '236' => '236 lbs (107.0 kg)',
						'238' => '238 lbs (108.0 kg)', '240' => '240 lbs (109.0 kg)', '242' => '242 lbs (110.0 kg)', '244' => '244 lbs (110.5 kg)', '246' => '246 lbs (111.5 kg)',
						'248' => '248 lbs (112.5 kg)', '250' => '250 lbs (113.5 kg)', '252' => '252 lbs (114.5 kg)', '254' => '254 lbs (115.0 kg)', '256' => '256 lbs (116.0 kg)',
						'258' => '258 lbs (117.0 kg)', '260' => '260 lbs (118.0 kg)', '262' => '262 lbs (119.0 kg)', '264' => '264 lbs (120.0 kg)', '266' => '266 lbs (120.5 kg)',
						'268' => '268 lbs (121.5 kg)', '270' => '270 lbs (122.5 kg)', '272' => '272 lbs (123.5 kg)', '274' => '274 lbs (124.5 kg)', '276' => '276 lbs (125.0 kg)',
						'278' => '278 lbs (126.0 kg)', '280' => '280 lbs (127.0 kg)', '282' => '282 lbs (128.0 kg)', '284' => '284 lbs (129.0 kg)', '286' => '286 lbs (129.5 kg)',
						'288' => '288 lbs (130.5 kg)', '290' => '290 lbs (131.5 kg)', '292' => '292 lbs (132.5 kg)', '294' => '294 lbs (133.5 kg)', '296' => '296 lbs (134.5 kg)',
						'298' => '298 lbs (135.0 kg)', '300' => '300 lbs (136.0 kg)', '300' => '302 lbs (137.0 kg)', '304' => '304 lbs (138.0 kg)', '306' => '306 lbs (139.0 kg)',
						'308' => '308 lbs (139.5 kg)', '310' => '310 lbs (140.5 kg)', '312' => '312 lbs (141.5 kg)', '314' => '314 lbs (142.5 kg)', '316' => '316 lbs (143.5 kg)',
						'318' => '318 lbs (144.0 kg)', '320' => '320 lbs (145.0 kg)', '322' => '322 lbs (146.0 kg)', '324' => '324 lbs (147.0 kg)', '326' => '326 lbs (148.0 kg)',
						'328' => '328 lbs (149.0 kg)', '330' => '330 lbs (149.5 kg)', '332' => '332 lbs (150.5 kg)', '334' => '334 lbs (151.5 kg)', '336' => '336 lbs (152.5 kg)',
						'338' => '338 lbs (153.5 kg)', '340' => '340 lbs (154.0 kg)', '342' => '342 lbs (155.0 kg)', '344' => '344 lbs (156.0 kg)', '346' => '346 lbs (157.0 kg)',
						'348' => '348 lbs (158.0 kg)', '350' => '350 lbs (159.0 kg)', '352' => '352 lbs (159.5 kg)', '354' => '354 lbs (160.5 kg)', '356' => '356 lbs (161.5 kg)',
						'358' => '358 lbs (162.5 kg)', '360' => '360 lbs (163.5 kg)', '362' => '362 lbs (164.0 kg)', '364' => '364 lbs (165.0 kg)', '266' => '366 lbs (166.0 kg)',
						'368' => '368 lbs (167.0 kg)', '370' => '370 lbs (168.0 kg)', '372' => '372 lbs (168.5 kg)', '374' => '374 lbs (169.5 kg)', '376' => '376 lbs (170.5 kg)',
						'378' => '378 lbs (171.5 kg)', '380' => '380 lbs (172.5 kg)', '382' => '382 lbs (173.5 kg)', '384' => '384 lbs (174.0 kg)', '386' => '386 lbs (175.0 kg)',
						'388' => '388 lbs (176.0 kg)', '390' => '390 lbs (177.0 kg)', '392' => '392 lbs (178.0 kg)', '394' => '394 lbs (178.5 kg)', '396' => '396 lbs (179.5 kg)',
						'398' => '398 lbs (180.5 kg)', '400' => '400 lbs (181.5 kg)', '400' => '400+ lbs (181.5 kg)'
				),
				'value' => $args['weight']
		));
		$weight->setLabel('Weight');

		$bust = new Zend_Form_Element_Select('bust', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39',
						'40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48', '49' => '49',
						'50' => '50'
				),
				'value' => $args['bust']
		));
		$bust->setLabel('Bust');

		$shirt = new Zend_Form_Element_Select('shirt', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19'
				),
				'value' => $args['shirt']
		));
		$shirt->setLabel('Shirt');

		$waist = new Zend_Form_Element_Select('waist', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29',
						'30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39',
						'40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48'
				),
				'value' => $args['waist']
		));
		$waist->setLabel('Waist');

		$hips = new Zend_Form_Element_Select('hips', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29',
						'30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39',
						'40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48'
				),
				'value' => $args['hips']
		));
		$hips->setLabel('Hips/Inseam');

		$sex = new Zend_Form_Element_Select('sex', array(
				'multiOptions' => array('null' => 'Select One', 'Female' => 'Female', 'Male' => 'Male'),
				'value' => $args['sex']
		));
		$sex->setLabel('Sex');

		$dobmm = new Zend_Form_Element_Select('dobmm', array(
				'multiOptions' => array('' => 'Select One', '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May',
						'06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'),
				'value' => $args['dobmm']
		));
		$dobmm->setLabel('Birth Month');

		$dobdd = new Zend_Form_Element_Select('dobdd', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'1' => '1', '2' => '2',
						'3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11',
						'12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20',
						'21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29',
						'30' => '30', '31' => '31'
				),
				'value' => $args['dobdd']
		));
		$dobdd->setLabel('Birth Day');

		$dobyyyy = new Zend_Form_Element_Select('dobyyyy', array(
				'multiOptions' => array(
						'2012' => '2012', '2011' => '2011', '2010' => '2010', '2009' => '2009', '2008' => '2008', '2007' => '2007', '2006' => '2006', '2005' => '2005',
						'2004' => '2004', '2003' => '2003', '2002' => '2002', '2001' => '2001', '2000' => '2000', '1999' => '1999', '1998' => '1998', '1997' => '1997',
						'1996' => '1996', '1995' => '1995', '1994' => '1994', '1993' => '1993', '1992' => '1992', '1991' => '1991', '1990' => '1990', '1989' => '1989',
						'1988' => '1988', '1987' => '1987', '1986' => '1986', '1985' => '1985', '1984' => '1984', '1983' => '1983', '1982' => '1982', '1981' => '1981',
						'1980' => '1980', '1979' => '1979', '1978' => '1978', '1977' => '1977', '1976' => '1976', '1975' => '1975', '1974' => '1974', '1973' => '1973',
						'1972' => '1972', '1971' => '1971', '1970' => '1970', '1969' => '1969', '1968' => '1968', '1967' => '1967', '1966' => '1966', '1965' => '1965',
						'1964' => '1964', '1963' => '1963', '1962' => '1962', '1961' => '1961', '1960' => '1960', '1959' => '1959', '1958' => '1958', '1957' => '1957',
						'1956' => '1956', '1955' => '1955', '1954' => '1954', '1953' => '1953', '1952' => '1952', '1951' => '1951', '1950' => '1950', '1949' => '1949',
						'1948' => '1948', '1947' => '1947', '1946' => '1946', '1945' => '1945', '1944' => '1944', '1943' => '1943', '1942' => '1942', '1941' => '1941',
						'1940' => '1940', '1939' => '1939', '1938' => '1938', '1937' => '1937', '1936' => '1936', '1935' => '1935', '1934' => '1934', '1933' => '1933',
						'1932' => '1932', '1931' => '1931', '1930' => '1930', '1929' => '1929', '1928' => '1928', '1927' => '1927', '1926' => '1926', '1925' => '1925',
						'1924' => '1924', '1923' => '1923', '1922' => '1922', '1921' => '1921', '1920' => '1920', '1919' => '1919', '1918' => '1918', '1917' => '1917',
						'1916' => '1916', '1915' => '1915', '1914' => '1914', '1913' => '1913', '1912' => '1912', '1911' => '1911', '1910' => '1910', '1909' => '1909',
						'1908' => '1908', '1907' => '1907', '1906' => '1906', '1905' => '1905', '1904' => '1904', '1903' => '1903', '1902' => '1902', '1901' => '1901',
						'1900' => '1900'
				),
				'value' => $args['dobyyyy']
		));
		$dobyyyy->setLabel('Birth Year');

		$build = new Zend_Form_Element_Select('build', array(
				'multiOptions' => array( 'null' => 'Select One',
						'Thin' => 'Thin', 'Athletic' => 'Athletic', 'Full Figured' => 'Full Figured', 'Medium' => 'Medium', 'Lean Muscle' => 'Lean Muscle',
						'Extra Large' => 'Extra Large', 'Large' => 'Large', 'Petite' => 'Petite'
						),
				'value' => $args['build']
		));
		$build->setLabel('Body Type');

		$hair = new Zend_Form_Element_Select('hair', array(
				'multiOptions' => array( 'null' => 'Select One',
						'Auburn' => 'Auburn', 'Black' => 'Black', 'Blonde' => 'Blonde', 'Brown' => 'Brown', 'Bald' => 'Bald', 'Chestnut' => 'Chestnut',
						'Dark Brown' => 'Dark Brown', 'Grey' => 'Grey', 'Red' => 'Red', 'White' => 'White', 'Salt&Pepper' => 'Salt & Pepper'
						),
				'value' => $args['hair']
		));
		$hair->setLabel('Hair');

		$hairstyle = new Zend_Form_Element_Select('hairstyle', array(
				'multiOptions' => array( 'null' => 'Select One',
						'Afro' => 'Afro', 'Bald' => 'Bald', 'Buzz' => 'Buzz', 'Conservative' => 'Conservative', 'Dreadlocks' => 'Dreadlocks',
						'Long' => 'Long', 'Medium' => 'Medium', 'Shaved' => 'Shaved', 'Short' => 'Short'
						),
				'value' => $args['hairstyle']
		));
		$hairstyle->setLabel('Hair Style');

		$eyes = new Zend_Form_Element_Select('eyes', array(
				'multiOptions' => array( '' => 'Select One',
						'Blue' => 'Blue', 'Blue-Green' => 'Blue-Green', 'Brown' => 'Brown', 'Green' => 'Green', 'Grey' => 'Grey',
						'Grey-Blue' => 'Grey-Blue', 'Grey-Green' => 'Grey-Green', 'Hazel' => 'Hazel'
						),
				'value' => $args['eyes']
		));
		$eyes->setLabel('Eyes');

		$dress = new Zend_Form_Element_Select('dress', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'1' => '1', '2' => '2',
						'3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11',
						'12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20',
						'21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29',
						'30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39',
						'40' => '40', '41' => '41', '42' => '42', '43' => '43', '44' => '44', '45' => '45', '46' => '46', '47' => '47', '48' => '48'
				),
				'value' => $args['dress']
		));
		$dress->setLabel('Dress/Suit');

		$size = new Zend_Form_Element_Select('size', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'S' => 'S', 'R' => 'R', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL'
				),
				'value' => $args['size']
		));
		$size->setLabel('Dress/Suit Size');

		$shoe = new Zend_Form_Element_Select('shoe', array(
				'multiOptions' => array(''=>'Select One', ''=>'Select One',
						'1' => '1', '2' => '2',
						'3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11',
						'12' => '12', '13' => '13', '14' => '14', '15' => '15'
				),
				'value' => $args['shoe']
		));
		$shoe->setLabel('Shoe');

		$ethnicity = new Zend_Form_Element_Select('ethnicity', array(
				'multiOptions' => array( '' => 'Select One',
						'African' => 'African', 'African American' => 'African American', 'Asian' => 'Asian', 'Caribbean' => 'Caribbean', 'Caucasian' => 'Caucasian',
						'East Indian' => 'East Indian', 'Hispanic' => 'Hispanic', 'Latin American' => 'Latin American', 'Mediterranean' => 'Mediterranean',
						'Middle Eastern' => 'Middle Eastern', 'Mixed' => 'Mixed', 'Native American' => 'Native American'
				),
				'value' => $args['ethnicity']
		));
		$ethnicity->setLabel('Ethnicity');

		$submit = new Zend_Form_Element_Submit('edit_acting_profile');
		$submit->setLabel('Submit');
		$submit->setAttrib('class', 'but_blue');

		$values = array($city, $sex, $height, $weight, $bust, $shirt, $waist, $hips, $dobmm, $dobdd, $dobyyyy, $build, $hair, $hairstyle, $eyes, $dress, $size, $shoe, $ethnicity, $submit);

		$this->addElements($values);

		//$shoe ->setDecorators($this->setbulkDecorators('shoe_new', 'shoe_label', 'shoe_post'));
		$submit ->setDecorators($this->setbulkDecorators('submit_new', 'submit_label', 'submit_post'));

		$this->addDisplayGroup(array($city, $sex, $height, $weight, $bust, $shirt, $waist, $hips, $ethnicity, $build), 'firstactinf_group', array());
		$this->addDisplayGroup(array($dobmm, $dobdd, $dobyyyy, $hair, $hairstyle, $eyes, $dress, $size, $shoe), 'secondacting_group', array());
		$this->addDisplayGroup(array($submit), 'thirdacting_group', array());

		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'table', 'class' => 'upload_form')),
				'Form'
		));

	}

	public function weight()
	{
	$x = array();

	$i = 18;
	for($j=40; $j<=400; $j++)
	{
	    if(($j % 2)==0)
	    {
	    	$x[$j] = $j.'lbs(~'.$i.'kg)';
		$i++;
	    }
	}

	return $x;
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