<?php
class Profile_DanceController extends Zend_Controller_Action {

	public $getInfo;
	public $getDance;
	private static $talentName;

    public function init()
    {
    	// added for seo
//    	$this->view->headTitle("Explore Talent | Search Our Talent for Auditions - ExploreTalent.com");
//    	$this->view->headMeta()->appendName('keywords', "casting calls, modeling jobs and acting auditions, modeling agencies, auditions for disney channel, disney channel auditions, movie extras, acting auditions, americas next top model, tyler perry casting, tyler perry studios, casting calls, disney casting auditions, plus size modeling, talent explore, reality show, game show, americas got talent auditions, reality shows, disney casting, movie auditions, plus size modeling agencies, nickelodeon auditions, singing auditions, auditions for disney, talent search, casting reality tv, modeling jobs, movie extra, casting auditions, disney channel auditions 2011, auditions for movies, auditions movie, teens modeling agency, disney channel casting, modeling agencies in chicago, singer jobs, glee auditions, disney channel audition, model search 2011, tyler perry auditions, hollywood auditions, become a model, model jobs, tyler perry studios jobs, pro scouts modeling and acting, casting real world, talent agency, extra in a movie, auditions for teens, singing auditions for kids, modeling jobs in atlanta, mtv auditions, modeling agencies in michigan, singing talent, music video auditions, explore talent, exploretalent, exploretalent.com" );
//    	$this->view->headMeta()->appendName('description', "Find Casting Calls | Thousands of New Jobs Posted Each Day | Free Access to Modeling Jobs, Acting Auditions, Music Jobs, Dance Auditions and Crew Jobs on ExploreTalent.com" );
//    	$this->view->headMeta()->appendName('og:title', "Explore Talent | Find Casting Calls, Modeling Jobs and Acting Auditions");

    	$this->view->title = "Dance Profile";
    	$this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/profile/profile.css');

    	$this->_helper->layout->setLayout('profile');

    	$this->form 	= new Profile_Form_Factory();
    	$this->tnum 	= new Profile_Model_Profiles();
	    $this->tnum->useDependents(false);
    	$this->media 	= new Profile_Model_Mapper_Profiles();

        $this->userid = Application_Model_Functions::getId();

		static::$talentName = Application_Model_Functions::getName(Application_Model_Functions::getId());

	    $this->view->auth = static::$talentName;
	    $this->view->info = static::$talentName;

        $this->view->action_name = 'dance';
        $this->view->userid = $this->userid;
        $this->view->talentname = static::$talentName;
    }

    public function setTalentdance()
    {
        $dance = new Talents_Model_Talentdance();

    	$this->getDance = $dance->fetchAll('talentnum = '.$this->userid, null, null);

    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile ('/js/jquery.carouFredSel-5.6.2.js');
        $this->view->headScript()->appendFile ('/js/global/social_info_gallery.js');

    	$this->view->form = $this->form->enableProfile();

    	if ($this->getRequest()->isPost()){
    		$post = $this->getRequest()->getParams();
    		$data = array(
    				'modeling' 	=> $post['modeling'],
    				'acting' 	=> $post['acting'],
    				'musician'	=> $post['musician'],
    				'dancer' 	=> $post['dancer'],
    				'crew' 		=> $post['crew'],
    				'sports' 	=> $post['sports'],
    				'social' 	=> $post['social']
    			);

    		$this->tnum->updateProfile($data);
    	}

        $info = new Talents_Model_Talentci();

    	$this->getInfo = $info->setTalentci();
    	$this->view->info = $this->getInfo;

    	$this->setTalentdance();
    	$this->view->danceinfo = $this->getDance;

    	$modelResume = $this->media->fetchGeneral('bam.talent_resume', 'talentnum = '.$this->userid.' AND type = 4');
    	$resume = 'n/a'; $about = 'n/a';
        if(isset($modelResume[0])){
            $resume = $modelResume[0]->resume;
            $about = $modelResume[0]->about;
        }
        $this->view->resume = $resume;
        $this->view->about = $about;

		$this->view->loggedinuser = $this->userid;

        Profile_Model_ProfileSeo::putSeo($this->getInfo, 'dance');
    }

    public function similarTalentsAction()
    {
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/matchedProfiles.js');
    }

    public function videoAction()
    {
        $video    = new Media_Model_Videos();

        $fetchVideos = $video->fetchAll('talentnum = '.$this->userid.' AND type = 2 AND status = 1');
        $this->view->videos = $fetchVideos;
    }

    /**
     * this will generate teh gallerys
     */
    public function imageAction()
    {
        $model = new Profile_Model_Talentgallery();
        $pictures = $model->getImages(null, 'talent_media2_dance', 'media_dance');

        $this->view->allimages = $pictures;
    }

    /**
     * this will load the images from each gallery
     */
    public function galleryAction()
    {
        $request = $this->getRequest();

        $galleryId = $request->getParam('group');

	    $model = new Media_Model_Talentmedia2dance();

	    $model->useDependents(false);

	    $pictures = $model->fetchAll('talentnum = ? AND gallery = ?', null, null, null, null, [$this->userid, $galleryId]);

	    $this->view->allimages = Application_Model_Functions::toArray($pictures);
    }


    public function getmainPic()
    {
        $musicMediaMain = $this->media->fetchGeneral('bam.talent_media2_dance', 'talentnum = '.USERID.' AND type = 2', 'media_dance');
	    if($musicMediaMain!= null && isset($musicMediaMain[0])){
            $val = $musicMediaMain[0]->full_path;
        } else {
            $val = '';
        }

        $this->view->imagepath = $val;
    }


    public function editAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

    	$request = $this->getRequest();

    	// edit dance info
		$this->setTalentdance();
    	$editDanceProfile = $this->form->editDance($this->getDance, 'dance');
    	$this->view->editdance = $editDanceProfile;

    	if ($request->isPost()) {
    		if (isset($_POST['edit_dance_profile']) && $editDanceProfile->isValid($_POST)) {
    			$data = $editDanceProfile->getValues();

    			$this->tnum->editDance($data);
    		}
    	}

    	//edit resume
    	$modelResume = $this->media->fetchGeneral('bam.talent_resume', 'talentnum = '.USERID.' AND type = 4');

    	$formEditResume = $this->form->editResume($modelResume, 'dance');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_resumes']) && $formEditResume->isValid($_POST)) {
    			$data = $formEditResume->getValues();

    			$this->tnum->updatedResume($data['id'], USERID, $data['edit_resume'], 'resume', '4', '');
    		}
    	}

    	//edit about
    	$formEditAbout = $this->form->editAbout($modelResume, 'dance');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_abouts']) && $formEditAbout->isValid($_POST)) {
    			$data = $formEditAbout->getValues();

    			$this->tnum->updatedResume($data['id'], USERID, $data['edit_about'], 'about', '4', '');
    		}
    	}

    	$this->view->editresume 		= $formEditResume;
    	$this->view->editabout 			= $formEditAbout;
    }

    public function editimagesAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

        $uploadModel = new Application_Model_Upload();
		$form   = new Profile_Form_Factory();

        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/jcrop/jquery.Jcrop.min.js');
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/jcrop/crop.js');
        $this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/jquery.Jcrop.css');

    	$request = $this->getRequest();

    	//primary image
        $formImageUpload = $this->form->imageUpload('dance');

    	if ($request->isPost()) {
    		if (isset($_POST['upload_picture']) && $formImageUpload->isValid($_POST)) {
    			$data = $formImageUpload->getValues();
    			$uploadModel->imageUpload($data['picture'], 'media/media_dance/', '2', 'bam.talent_media2_dance', null, 99);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('primary'=>'primary'));
    		}
            if (isset($_POST['cropped_image_dance'])) {
                $uploadModel->uploadCroppedImage($_POST['filename'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
            }
    	}
        $this->getmainPic();

		//add/edit gallery
		$modelg = new Profile_Model_Talentgallery();

		$addGallery = $form->addCategory('dance');
		if ($request->isPost()) {
            if (isset($_POST['add_gallery']) && $addGallery->isValid($_POST)) {
				$addRes = $modelg->crudGallery($addGallery->getValues());
				$this->view->add_result = $addRes;
            }
            if (isset($_POST['delete_gallery'])) {
				$modelg->deleteGallery($request->getParams(), 'dance');
            }
        }
		$galleryData = $modelg->fetchAll('talentnum = '.USERID);
		$this->view->gallery = Application_Model_Functions::toArray($galleryData);

    	//secondary images
    	$formImageSecond = $this->form->imageUploadSecond('dance');

    	if ($request->isPost()) {
    		if (isset($_POST['upload_picture_second']) && $formImageSecond->isValid($_POST)) {
    			$data = $formImageSecond->getValues();

    			$uploadModel->imageUpload($data['picture'], 'media/media_dance/', '1', 'bam.talent_media2_dance', null, $data['user_gallery']);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('secondary'=>'secondary'));
    		}
    	}

    	// delete secondary images
    	$musicMediaInfo = $this->media->fetchGeneral('bam.talent_media2_dance', 'talentnum = '.USERID.' AND type = 1', 'media_dance');
    	$formImageDelete = $this->form->imageDelete($musicMediaInfo, 'dance');

    	if ($request->isPost()) {
    		if (isset($_POST['delete_picture']) && $formImageDelete->isValid($_POST)) {
    			$data = $formImageDelete->getValues();
    			$deleteArray = '';

    			foreach($data as $key=>$val){
    				if($val == 1)
    					$deleteArray[] = $key;
    			}

    			$uploadModel->deleteImage($deleteArray, 'talent_media2_dance');
    		}
    	}

    	$this->view->form 				= $formImageUpload;
        $this->view->addgallery    		= $addGallery;
    	$this->view->formImageSecond 	= $formImageSecond;
    	$this->view->deleteimage 		= $formImageDelete;
    }

    public function editvideoAction()
    {
    	$request = $this->getRequest();
    	$videoConvert = new Application_Model_Videoconvertor();
        $video    = new Media_Model_Videos();

    	$fetchVideos = $video->fetchAll('talentnum = '.USERID.' AND type = 2 AND status = 1');

    	$videoUpload = new Profile_Form_Factory();
    	$fideoUploadForm = $videoUpload->editVideoUpload('dance');

    	if ($request->isPost()) {
    		if (isset($_POST['upload_video']) && $fideoUploadForm->isValid($_POST)) {
    			$data = $fideoUploadForm->getValues();

    			$insertVideo = $videoConvert->insertVideo($data, 2, 'dance');  //returns the video_id.

                //move file from temp to tmp and rename it
			    $file = pathinfo($data['file'], PATHINFO_EXTENSION);
                exec ( "mv '/var/www/multimedia/temp/".$data['file']."' /var/www/multimedia/tmp/".$insertVideo.'_'.USERID.'.'.$file );

                //convert the video - edit the cron job will convert the videos
    		}
    	}

    	$this->view->videoupload = $fideoUploadForm;
    	$this->view->videos = $fetchVideos;
    }

    public function changeDetails()
    {
    	$talentnum = Application_Model_Functions::userid();
    	$model = new Talents_Model_Talentinfo2();
    	$prop = $model->fetchAll('talentnum = '.$talentnum);

    	$city = explode(",", str_replace(" ", "", $prop->getCity1()) );
	    $x = $city[1] ? $city[1] : $city[0];


    	if ($this->setTalentdance()){

	    	$this->setTalentdance();
	    	$propDance = $this->getDance;

	    	return array(
	    			'city' 				=>$x,
	    			'group_name' 		=>$propDance->getGroupName(),
	    			'dance_style_1' 	=>$propDance->_dance_style_1,
	    			'dance_style_2' 	=>$propDance->_dance_style_2,
	    			'dance_style_3' 	=>$propDance->_dance_style_3,
	    			'dance_style_4' 	=>$propDance->_dance_style_4,
	    			'num_ppl_in_group' 	=>$propDance->getNumPplInnGroup(),
	    			'num_of_perfom' 	=>$propDance->getNumOfPerfom(),
	    			'years_experience' 	=>$propDance->getYearsExperience(),
	    			'management' 		=>$propDance->getManagement(),
	    			'websites' 			=>$propDance->getWebsites(),
	    			'dancer_background' =>$propDance->getDancerBackground(),
	    			'influences' 		=>$propDance->getInfluences(),
	    			'searching_gig' 			=>$propDance->getSearchingGig(),
	    			'searching_gig_des' 		=>$propDance->getSearchingGigDes(),
	    			'searching_group_mem_des' 	=>$propDance->getSearchingGroupMemDes()
    		);
    	} else {
    		return array(
	    			'city' 				=>$x,
	    			'group_name' 		=>'',
	    			'dance_style_1' 	=>'',
	    			'dance_style_2' 	=>'',
	    			'dance_style_3' 	=>'',
	    			'dance_style_4' 	=>'',
	    			'num_ppl_in_group' 	=>'',
	    			'num_of_perfom' 	=>'',
	    			'years_experience' 	=>'',
	    			'management' 		=>'',
	    			'websites' 			=>'',
	    			'dancer_background' =>'',
	    			'influences' 		=>'',
	    			'searching_gig' 			=>'',
	    			'searching_gig_des' 		=>'',
	    			'searching_group_mem_des' 	=>''
    		);
    	}
    }

}