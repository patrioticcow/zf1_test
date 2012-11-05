<?php

class Profile_Model_Profiles extends Application_Model_Proxy
{

    protected static $_mapper = null;
    protected $_profile_id = null;
    protected $_talentnum = null;
    protected $_profile_type_id = null;
    protected $userid;

    protected $_talentci = null;

    public function __construct()
    {
        self::$_mapper = new Profile_Model_Mapper_Profiles();
    }

    public function leftSidebar()
    {
        $view = Zend_Layout::getMvcInstance()->getView();

		$userid = Application_Model_Functions::getId();
		if($userid == null){$userid = USERID;}

        //check if online
        if($userid != null && is_numeric($userid)){
            $isOnline = Application_Model_Functions::getOnline($userid);
        } else {
            $isOnline = false;
        }

        $view->isonline = $isOnline;
        $view->primaryimage = $this->getPrimaryImage($userid);
        $view->loggedinuser = $userid;

        // points
        $totalPoints = null;
		$pointsModel = new Points_Model_Etpointssum();
	    $pointsModel->useDependents(false);
		$points = $pointsModel->fetchAll('talentnum = '.$userid, null, 1);

		if($points != null){
			$totalPoints = $points->getPointsTotal();
		}

		$view->points = $totalPoints;

        if(LOGGEDIN){
            $friendGet = new Friends_Model_Etfriends();
	        $getfriend = $friendGet->getFriend();
            $view->isfriend = $getfriend;
        }

	    $view->url = $this->editPicUrls($userid);
    }

	public function editPicUrls($userid)
	{
		$front = Zend_Controller_Front::getInstance();
		$request = $front->getRequest();

		$module = $request->getParam('module');
		$controller = $request->getParam('controller');
		$type = $request->getParam('type');

		$url = '/profile/social/edit/id/'.$userid;

		if($module == 'profiles'){
			$url = '/'.$module.'/edit/pictures/type/'.$type.'/id/'.$userid;
		}
        if($module == 'profile'){
            if($controller == 'social'){
                $url = '/'.$module.'/'.$controller.'/edit/id/'.$userid;
            } else {
                $url = '/'.$module.'/'.$controller.'/editimages/id/'.$userid;
            }
		}

		return $url;
	}

    public function getPrimaryImage($userid)
    {
    	$front = Zend_Controller_Front::getInstance();

    	$controller = $front->getRequest()->getParam('controller');
    	$module 	= $front->getRequest()->getParam('module');

    	$controllerArray = array("social", "modeling", "acting", "dance", "musician", "dynamic", "edit");
    	if (!in_array($controller, $controllerArray)) {
    		$controller = 'social';
    	}


    	if(($controller == 'dynamic' || $controller == 'edit') && ($module == 'profiles'))
	    {
    		$getType = $front->getRequest()->getParam('type');
    		$type = explode('-', $getType);

    		$dynamic = new Profiles_Model_Profilemedia();
    		$dp = $dynamic->fetchAll('profile_id = '.$type[1].' AND talentnum = '.$userid.' AND type = 1');

    		$pictures = '';
    		if($dp != null){
    			$pictures = 'http://download.exploretalent.com/'.$dp->getMediaPath();
    		}

    	}
	    else if($controller == 'social')
	    {
		    $pictures = Media_Model_MediaAbstract::getSocialPic($userid, 'media_social', null, null, null, false);
	    }
	    else
	    {
    		$model = new Media_Model_Media();
    		$pictures = $model->getPictureLeft($userid, ' AND type = 2', 'talent_media2_'.$controller, 'media_'.$controller);
    	}

    	return $pictures;
    }

    public function notificationSidebar()
    {
    	$model = new Notifications_Model_Notifications();
    	$model->topNotifiactions();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();
            $data = $front->getRequest()->getParams();
        }

        $this->_profile_id = !empty($data["profile_id"]) ? $data["profile_id"] : null;
        $this->_talentnum = !empty($data["talentnum"]) ? $data["talentnum"] : null;
        $this->_profile_type_id = !empty($data["profile_type_id"]) ? $data["profile_type_id"] : null;

        $id = self::$_mapper->save($this);

        return $id;
    }

	public function fetchProfiles($where, $order, $limit)
	{
		$profile = self::$_mapper->fetchProfiles($where, $order, $limit);
		return $profile;
	}

	public function updateProfile($datas)
	{
	    // get id to see if the user account already existas
	    $profile = $this->fetchAll('a.talentnum = '.USERID);
        //echo '<pre>'; print_r($profile); exit;
        $id = '';
	    if ($profile){
	        $id = $profile->getProfileId();
	    }

			$acting 	= $datas['acting'] 		== '1' ? '1' : '0';
			$musician 	= $datas['musician'] 	== '1' ? '4' : '0';
			$dancer 	= $datas['dancer'] 		== '1' ? '8' : '0';
            $social     = isset($datas['social']) && ($datas['social'] == '1') ? '32' : '0';

			$total = $acting + $musician + $dancer + $social;// + $crew + $sports;
			$update = array('profile_id'=>$id, 'talentnum' =>  USERID, 'profile_type_id' => $total);

		$this->create($update);
	}


	/*
	 * update / insert about/resume
	* */
	public function updatedResume ($id, $talentnum, $resume, $type, $i = null, $other) //$data['id'], USERID, $data['edit_resume'], 'acting'
	{

		if(($type == 'special_skills') || ($type == 'experience'))
		{ //update acting
			$u = new Talents_Model_Talentinfo2();

			$data = array();

			$data['talentnum'] = $talentnum;

			if ($type == 'experience'){
				$data['special_skills'] = $other;
				$data['experience'] = $resume;
			}
			if ($type == 'special_skills'){
				$data['special_skills'] = $resume;
				$data['experience'] = $other;
			}

			//print_r($data);

			$u->create($data);

		}
		else
		{ // update everything else
			if(isset($id) && ($id >='1'))
			{  //update
				if ($type == 'resume'){
					$data = array(
							'resume'    => $resume
					);
				}
				if ($type == 'about'){
					$data = array(
							'about'    => $resume
					);
				}
				$update = self::$_mapper->generalUpdate('talent_resume', $data, $i);
			}
			else
			{  //insert
				if ($type == 'resume'){
					$data = array(
							'talentnum' =>  USERID,
							'resume'    => $resume,
							'about'    	=> '',
							'type'    	=> $i,
					);
				}
				if ($type == 'about'){
					$data = array(
							'talentnum' =>  USERID,
							'resume'    => '',
							'about'    	=> $resume,
							'type'    	=> $i,
					);
				}
				$insert = self::$_mapper->generalInsert('talent_resume', $data);
			}
		}

	}

	public function talentInfo2 ($x, $y)
	{
		$front = Zend_Controller_Front::getInstance();
		$userid = $front->getRequest()->getParam('id');

		if ($y == 'special_skills'){
			$ss = $x;
			$ex = '';
		}
		if ($y == 'experience'){
			$ss = '';
			$ex = $x;
		}

		return array(
				'talentnum' =>  $userid,
				'ethnicity' => '', 'ethnicity_other' => '', 'flang' => '', 'slang' => '', 'city1' => '', 'city2' => '',
				'city3' => '', 'minpay1' => '', 'minpay2' => '', 'minpay3' => '', 'sports' => '', 'accents' => '', 'musicalinstruments' => '',
				'dance' => '', 'modeltypes' => '', 'actortypes' => '', 'travel' => '', 'acting' => '', 'union_sag' => '', 'union_aftra' => '',
				'union_aea' => '', 'union_other' => '',
				'special_skills' => $ss,
				'nowork' => '', 'agent_name' =>'', 'agent_site' => '', 'extra_link' => '',
				'singingstyle' => '',
				'experience' => $ex,
				'ethnicity_x' => '', 'int_city1' => '', 'int_city2' => '', 'int_city3' => '', 'interest_1' => '0',
				'interest_2' => '0', 'interest_3' => '0', 'interest_4' => '0', 'interest_5' => '0', 'interest_6' => '0', 'interest_7' => '0', 'interest_8' => '0',
				'interest_9' => '0', 'interest_10' => '0'
		);
	}

	public function editActing($data)
	{
		$info = new Talents_Model_Talentci();
		$info1 = new Talents_Model_Talentinfo1();
		$info2 = new Talents_Model_Talentinfo2();

		$datas = array();
		$talentinfo1 = array();
		$talentinfo2 = array();

		foreach($data as $key=>$val)
		{
			$datas[$key] = $val;
		}

		$height = explode (".", round($datas['height'] / 12, 1));
		$height[1] = $datas['height'] - $height[0] * 12;

		$talentinfo1['talentnum'] 	= USERID;
		$talentinfo1['heightinches']= isset($height[1]) ? $height[1] : 0;
		$talentinfo1['heightfeet'] 	= isset($height[0]) ? $height[0] : 0;
		$talentinfo1['weightpounds']= $datas['weight'];
		$talentinfo1['weightkilos'] = round($datas['weight'] * 0.454);
		$talentinfo1['sex'] 		= $datas['sex'];
		$talentinfo1['bust'] 		= $datas['bust'];
		$talentinfo1['shirt'] 		= $datas['shirt'];
		$talentinfo1['waist'] 		= $datas['waist'];
		$talentinfo1['build'] 		= $datas['build'];
		$talentinfo1['hips'] 		= $datas['hips'];
		$talentinfo1['dobmm'] 		= $datas['dobmm'];
		$talentinfo1['dobdd'] 		= $datas['dobdd'];
		$talentinfo1['dobyyyy'] 	= $datas['dobyyyy'];
		$talentinfo1['haircolor'] 	= $datas['hair'];
		$talentinfo1['eyecolor'] 	= $datas['eyes'];
		$talentinfo1['shoes'] 		= $datas['shoe'];
		$talentinfo1['dress'] 		= $datas['dress'];
		$talentinfo1['suit'] 		= $datas['size'];
		$talentinfo1['hairstyle'] 	= $datas['hairstyle'];

		$talentinfo2['talentnum'] 	= USERID;
		$talentinfo2['city1'] 		= $datas['city'];
		$talentinfo2['ethnicity'] 	= $datas['ethnicity'];

		$info1->create($talentinfo1);
		$info2->create($talentinfo2);

		$exp = explode(',', $datas['city']);
		$info->create(array('talentnum'=>USERID, 'city'=>$exp[0], 'state'=>$exp[1]));
	}


	public function editMusician($data)
	{
	    //echo '<pre>'; print_r($data); exit;
		$music = new Talents_Model_Talentmusic();
		$info2 = new Talents_Model_Talentinfo2();

		$id = $music->fetchAll('talentnum = '.USERID);

		$tmId = isset($id) ? $id->getTmId() : null;

		$datas = array();
		$talentmusic = array();
		$talentinfo2 = array();

		foreach($data as $key=>$val)
		{
			$datas[$key] = $val;
		}

		$talentmusic['tm_id'] 				= $tmId;
		$talentmusic['date_created'] 		= time();
		$talentmusic['talentnum'] 			= USERID;
		$talentmusic['band_name'] 			= $datas['band_name'];
		$talentmusic['music_type2'] 		= $datas['music_type2'];
		$talentmusic['music_type3'] 		= $datas['music_type3'];
		$talentmusic['music_type4'] 		= $datas['music_type4'];
		$talentmusic['music_type5'] 		= $datas['music_type5'];
		$talentmusic['band_type'] 			= $datas['band_type'];
		$talentmusic['genre'] 				= $datas['genre'];
		$talentmusic['genre2'] 				= $datas['genre2'];
		$talentmusic['genre3'] 				= $datas['genre3'];
		$talentmusic['genre4'] 				= $datas['genre4'];
		$talentmusic['record_label'] 		= $datas['record_label'];
		$talentmusic['label_type'] 			= $datas['label_type'];
		$talentmusic['number_of_gigs'] 		= $datas['number_of_gigs'];
		$talentmusic['years_experience'] 	= $datas['years_experience'];
		$talentmusic['management'] 			= $datas['management'];
		$talentmusic['studio_musician'] 	= $datas['studio_musician'];
		$talentmusic['music_instruments'] 	= $datas['music_instruments'];
		$talentmusic['website'] 			= $datas['websites'];
		$talentmusic['des_1'] 				= $datas['des_1'];
		$talentmusic['major_influence'] 	= $datas['major_influence'];
		$talentmusic['searching_band'] 		= $datas['searching_band'];
		$talentmusic['searching_band_mem'] 	= $datas['searching_band_mem'];
		$talentmusic['searching_gig'] 		= $datas['searching_gig'];
		$talentmusic['searching_gig_des'] 	= $datas['searching_gig_des'];

		$talentinfo2['talentnum'] 			= USERID;
		$talentinfo2['city1'] 				= $datas['city'];

		$music->create($talentmusic);
		$info2->create($talentinfo2);
	}

	public function editDance($data)
	{
		$dance = new Talents_Model_Talentdance();
		$info2 = new Talents_Model_Talentinfo2();

		$id = $dance->fetchAll('talentnum = '.USERID);
		$tdId = isset($id) ? $id->getTdId() : null;

		$datas = array();
		$talentdance = array();
		$talentinfo2 = array();

		foreach($data as $key=>$val)
		{
			$datas[$key] = $val;
		}

		$talentdance['td_id'] 					= $tdId;
		$talentdance['talentnum'] 				= USERID;
		$talentdance['date_created'] 			= time();
		$talentdance['status'] 					= '';
		$talentdance['dance_type'] 				= '';
		$talentdance['years_experience'] 		= $datas['years_experience'];
		$talentdance['num_of_perfom'] 			= $datas['num_of_perfom'];
		$talentdance['management'] 				= $datas['management'];
		$talentdance['dance_style_1'] 			= $datas['dance_style_1'];
		$talentdance['dance_style_2'] 			= $datas['dance_style_2'];
		$talentdance['dance_style_3'] 			= $datas['dance_style_3'];
		$talentdance['dance_style_4'] 			= $datas['dance_style_4'];
		$talentdance['dance_style_5'] 			= '';
		$talentdance['website'] 				= $datas['websites'];
		$talentdance['dancer_background'] 		= $datas['dancer_background'];
		$talentdance['influences'] 				= $datas['influences'];
		$talentdance['searching_gig'] 			= $datas['searching_gig'];
		$talentdance['searching_gig_des'] 		= $datas['searching_gig_des'];
		$talentdance['group_name'] 				= $datas['group_name'];
		$talentdance['num_ppl_in_group'] 		= $datas['num_ppl_in_group'];
		$talentdance['searching_group_mem'] 	= '';
		$talentdance['searching_group_mem_des'] = $datas['searching_group_mem_des'];
		$talentdance['searching_group'] 		= '';

		$talentinfo2['talentnum'] 			= USERID;
		$talentinfo2['city1'] 				= $datas['city'];



		$dance->create($talentdance);
		$info2->create($talentinfo2);
	}

	public function city($city)
	{
		$data = array(
			'CA' => 'Los Angeles, CA'	, 'NY' => 'Albany, NY'			, 'NM' => 'Albuquerque, NM'		, 'GA' => 'Atlanta, GA'					, 'ME' => 'Augusta, ME',
			'TX' => 'Austin, TX'		, 'MD' => 'Baltimore, MD'		, 'MT' => 'Billings, MT'		, 'AL' => 'Birmingham, AL'				, 'ID' => 'Boise, ID',
			'MA' => 'Boston, MA'		, 'NY' => 'Buffalo, NY'			, 'SC' => 'Charleston, SC'		, 'WV' => 'Charleston, WV'				, 'NC' => 'Charlotte, NC',
			'WY' => 'Cheyenne, WY'		, 'IL' => 'Chicago, IL'			, 'OH' => 'Cleveland, OH'		, 'SC' => 'Columbia, SC'				, 'OH' => 'Columbus, OH',
			'TX' => 'Dallas, TX'		, 'CO' => 'Denver, CO'			, 'IA' => 'Des Moines, IA'		, 'MI' => 'Detroit, MI'					, 'TX' => 'El Paso, TX',
			'ND' => 'Fargo, ND'			, 'CO' => 'Grand Junction, CO'	, 'CT' => 'Hartford, CT'		, 'HI' => 'Honolulu, HI'				, 'TX' => 'Houston, TX',
			'IN' => 'Indianapolis, IN'	, 'MS' => 'Jackson, MS'			, 'FL' => 'Jacksonville, FL'	, 'KS' => 'Kansas City, KS'				, 'MO' => 'Kansas City, MO',
			'NV' => 'Las Vegas, NV'		, 'AR' => 'Little Rock, AR'		, 'CA' => 'Los Angeles, CA'		, 'KY' => 'Louisville, KY'				, 'TN' => 'Memphis, TN',
			'FL' => 'Miami, FL'			, 'WI' => 'Milwaukee, WI'		, 'MN' => 'Minneapolis, MN'		, 'TN' => 'Nashville, TN'				, 'LA' => 'New Orleans, LA',
			'NY' => 'New York City, NY'	, 'VA' => 'Norfolk, VA'			, 'OK' => 'Oklahoma City, OK'	, 'NE' => 'Omaha, NE'					, 'FL' => 'Orlando, FL',
			'PA' => 'Philadelphia, PA'	, 'AZ' => 'Phoenix, AZ'			, 'PA' => 'Pittsburgh, PA'		, 'ME' => 'Portland, ME'				, 'OR' => 'Portland, OR',
			'NC' => 'Raleigh, NC'		, 'SD' => 'Rapid City, SD'		, 'NV' => 'Reno, NV'			, 'MO' => 'St Louis, MO'				, 'UT' => 'Salt Lake City, UT',
			'TX' => 'San Antonio, TX'	, 'CA' => 'San Diego, CA'		, 'CA' => 'San Francisco, CA'	, 'WA' => '	Seattle, WA'				, 'FL' => 'Tampa, FL',
			'DC' => 'Washington, DC'	, 'KS' => 'Wichita, KS'			, 'Canada' => 'Canada'			, 'AB' => 'Calgary-Edmonton, AB'		, 'ON' => 'Ottawa, ON',
			'QC' => 'Montreal, QC'		, 'ON' => 'Toronto, ON'			, 'BC' => 'Vancouver, BC'		, 'United Kingdom' => 'United Kingdom'	, 'London' => 'London',
			'UK' => 'Birmingham, UK'	, 'Leeds/North' => 'Leeds/North', 'Scotland' => 'Scotland'		, 'Ireland' => 'Ireland'				, 'Wales' => 'Wales',
			'Australia' => 'Australia'	, 'New SW / Sydney' => 'New SW / Sydney'						, 'Victoria / Melbourne' => 'Victoria / Melbourne',
			'Queensland/Brisbane' => 'Queensland/Brisbane'				, 'West / Perth' => 'West / Perth'	, 'South / Adelaide' => 'South / Adelaide',
			'New Zealand' => 'New Zealand'								, 'Auckland' => 'Auckland'			, 'Wellington' => 'Wellington', 'Christchurch' => 'Christchurch'
				);

		$citys = '';
		foreach ($data as $k=>$v)
		{
			if($k == $city)
			{
				$citys = $v;
			}
		}

		return $citys;
	}

    public function multioptions($key, $value, $and)
    {
        $data = '';

        $optionCount = count($key);

            $j=0;
            foreach($key as $v){
                if ($j < $optionCount){
                    if (!empty($v)){
                        $data .= " $and ".$value." = '$v'";
                    }
                } else {
                    $data .= " ".$value." = '$v'";
                }
                $j++;
            }

        return '('.substr($data, 4).')';
    }




}