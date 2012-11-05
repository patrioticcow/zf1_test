<?php
class Profile_ActingController extends Zend_Controller_Action {

	public $getInfo;
	private $userid;
	private static $talentName;

    public function init()
    {
    	$this->view->title = "Acting/Modeling Profile";
    	$this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/profile/profile.css');

    	$this->_helper->layout->setLayout('profile');

        $front = Zend_Controller_Front::getInstance();
        $this->userid = $front->getRequest()->getParam('id');

		static::$talentName = Application_Model_Functions::getName(Application_Model_Functions::getId());

	    $this->view->auth = static::$talentName;
	    $this->view->info = static::$talentName;

        $this->view->action_name = 'acting';
        $this->view->userid = $this->userid;
        $this->view->talentname = static::$talentName;
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile (CDN_JS_CSS.'/js/jquery.carouFredSel-5.6.2.js');
        $this->view->headScript()->appendFile (CDN_JS_CSS.'/js/global/social_info_gallery.js');

        $form 	= new Profile_Form_Factory();
    	$info 	= new Talents_Model_Talentci();
	    $tnum 	= new Profile_Model_Profiles();
	    $tnum->useDependents(false);

    	$this->view->form = $form->enableProfile();

    	if ($this->getRequest()->isPost()){
    		$post = $this->getRequest()->getParams();
    		$data = array(
    				'acting' 	=> $post['acting'],
    				'musician'	=> $post['musician'],
    				'dancer' 	=> $post['dancer'],
    				'crew' 		=> $post['crew'],
    				'sports' 	=> $post['sports'],
    				'social' 	=> $post['social']
    			);
    		$tnum->updateProfile($data);
    	}

    	$this->getInfo = $info->setTalentci();
    	$this->view->info = $this->getInfo;
        $this->view->notme = $this->userid;

        // matched castings
        if(LOGGEDIN){
            $cast = new Castings_Model_Castcat();
            $castings = $cast->fetchAll('talentnum = '.USERID , null, null);

			$sc = new Auditions_Model_CastingCategories();

            $setCasting = $sc->setCastings($castings);

            $this->view->castings = $setCasting;
        }
        Profile_Model_ProfileSeo::putSeo($this->getInfo, 'acting');
    }

    public function similarTalentsAction()
    {
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/matchedProfiles.js');
    }

    public function audioAction()
    {
        $audio  = new Media_Model_Songs();

        $fetchAudio = $audio->fetchAll('talentnum = '.$this->userid, 'song_id DESC');
        $this->view->audio = Application_Model_Functions::toArray($fetchAudio);
    }

    public function videoAction()
    {
        $request = $this->getRequest();

        // this is for the fucking old links.
        $tal = $request->getParam('talentnum');
        if(isset($tal)){
            $request->setParam('id', $request->getParam('talentnum'));
            $this->userid = $this->_request->id;
        }

        $video  = new Media_Model_Videos();

        $fetchVideos = $video->fetchAll('talentnum = '.$this->userid.' AND (type = 0 OR type = 3) AND status = 1', 'video_id DESC');
        $this->view->videos = Application_Model_Functions::toArray($fetchVideos);
    }

    /**
     * this will generate the gallerys
     */
    public function imageAction()
    {
        $model = new Profile_Model_Talentgallery();
        $pictures = $model->getImages(null, 'talent_media2_acting', 'media_acting');

	    $this->view->allimages = $pictures;
    }

    /**
     * this will load the images from each gallery
     */
    public function galleryAction()
    {
        $request = $this->getRequest();

        // this is for the fucking old links.
        $tal = $request->getParam('talentnum');
        if(isset($tal)){
            $request->setParam('id', $request->getParam('talentnum'));
            $request->setParam('group', 1);
            $this->userid = $this->_request->id;
        }

        $galleryId = $request->getParam('group');

		$model = new Media_Model_Talentmedia2acting();

	    $model->useDependents(false);

	    $pictures = $model->fetchAll('talentnum = ? AND gallery = ?', null, null, null, null, [$this->userid, $galleryId]);

        $this->view->allimages = Application_Model_Functions::toArray($pictures);
    }

    public function editAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

    	$request = $this->getRequest();

    	$form 	= new Profile_Form_Factory();
    	$tnum 	= new Profile_Model_Profiles();
	    $tnum->useDependents(false);
    	$media 	= new Profile_Model_Mapper_Profiles();

    	//edit acting profile
    	$editActingProfile = $form->editActing($this->changeDetails(), 'acting');
    	$this->view->editacting = $editActingProfile;

    	if ($request->isPost()) {
    		if (isset($_POST['edit_acting_profile']) && $editActingProfile->isValid($_POST)) {
    			$data = $editActingProfile->getValues();
    			$tnum->editActing($data);
    		}
    	}

    	//edit resume
    	$modelResume = $media->fetchGeneral('bam.talentinfo2', 'talentnum = '.USERID.'');

    	$formEditResume = $form->editResume($modelResume, 'acting');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_resumes']) && $formEditResume->isValid($_POST)) {
    			$data = $formEditResume->getValues();
    			$tnum->updatedResume($data['id'], USERID, $data['edit_resume'], 'experience', '', $modelResume[0]->special_skills);
    		}
    	}

    	//edit about
    	$formEditAbout = $form->editAbout($modelResume, 'acting');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_abouts']) && $formEditAbout->isValid($_POST)) {
    			$data = $formEditAbout->getValues();
    			$tnum->updatedResume($data['id'], USERID, $data['edit_about'], 'special_skills', '', $modelResume[0]->experience);
    		}
    	}

    	$this->view->editresume = $formEditResume;
    	$this->view->editabout 	= $formEditAbout;
    }

    public function editimagesAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/jcrop/jquery.Jcrop.min.js');
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/jcrop/crop.js');
        $this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/jquery.Jcrop.css');

        $request = $this->getRequest();

        $form   = new Profile_Form_Factory();
        $media  = new Profile_Model_Mapper_Profiles();
        $model  = new Application_Model_Upload();

        $formImageUpload = $form->imageUpload('acting');

        //primary image
        if ($request->isPost()) {

            if (isset($_POST['upload_picture']) ) {
                $data = $formImageUpload->getValues();
            	$pictureName = $data['file_upload'];

                $model->imageUpload($pictureName, 'media/media_acting/', '2', 'bam.talent_media2_acting', null, 99);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('primary'=>'primary'));

            }
            if (isset($_POST['cropped_image_acting'])) {
                $model->uploadCroppedImage($_POST['filename'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
            }
        }

		//add/edit gallery
		$modelg = new Profile_Model_Talentgallery();

		$addGallery = $form->addCategory('acting');
		if ($request->isPost()) {
            if (isset($_POST['add_gallery']) && $addGallery->isValid($_POST)) {
				$addRes = $modelg->crudGallery($addGallery->getValues());
				$this->view->add_result = $addRes;
            }
            if (isset($_POST['delete_gallery'])) {
				$modelg->deleteGallery($request->getParams(), 'acting');
            }
        }
		$galleryData = $modelg->fetchAll('talentnum = '.USERID);
		$this->view->gallery = Application_Model_Functions::toArray($galleryData);

        //secondary images
        $formImageSecond = $form->imageUploadSecond('acting');
        if ($request->isPost()) {
            if (isset($_POST['upload_picture_second']) && $formImageSecond->isValid($_POST)) {
                $data = $formImageSecond->getValues();
                $model->imageUpload($data['picture'], 'media/media_acting/', '1', 'bam.talent_media2_acting', null, $data['user_gallery']);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('secondary'=>'secondary'));
            }
        }


        // delete secondary images
        $musicMediaInfo = $media->fetchGeneral('bam.talent_media2_acting', 'talentnum = '.USERID.' AND type = 1', 'media_acting');
        $formImageDelete = $form->imageDelete($musicMediaInfo, 'acting');

        if ($request->isPost()) {
	            if (isset($_POST['delete_picture']) && $formImageDelete->isValid($_POST)) {
                $data = $formImageDelete->getValues();
                $deleteArray = '';

                foreach($data as $key=>$val){
                    if($val == 1){ $deleteArray[] = $key; }
                }
                $model->deleteImage($deleteArray, 'talent_media2_acting');
            }
        }

        $this->view->form               = $formImageUpload;
        $this->view->addgallery    		= $addGallery;
        $this->view->formImageSecond    = $formImageSecond;
        $this->view->deleteimage        = $formImageDelete;

        $picVal = $this->getmainPic();

        $this->view->imagepath = $picVal;
    }

    public function getmainPic()
    {
        $media  = new Profile_Model_Mapper_Profiles();
        $musicMediaMain = $media->fetchGeneral('bam.talent_media2_acting', 'talentnum = '.USERID.' AND type = 2', 'media_acting');
	    if($musicMediaMain!= null && isset($musicMediaMain[0])){
            $val = $musicMediaMain[0]->full_path;
        } else {
            $val = '';
        }

        return $val;
    }

    /* acting is type 0 * dancer is type 2 * modeling is type 3 * musician is type 4 * if needed social is type 5 */
    public function editvideoAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

    	$request = $this->getRequest();
    	$videoConvert = new Application_Model_Videoconvertor();
    	$video 	= new Media_Model_Videos();

    	$fetchVideos = $video->fetchAll('talentnum = '.USERID.' AND (type = 0 OR type = 3)', 'video_id DESC');
    	$videoUpload = new Profile_Form_Factory();
    	$fideoUploadForm = $videoUpload->editVideoUpload('acting');

    	if ($request->isPost()) {
    		if (isset($_POST['upload_video']) && $fideoUploadForm->isValid($_POST)) {
    			$data = $fideoUploadForm->getValues();

    			$insertVideo = $videoConvert->insertVideo($data, 0, 'acting');  //returns the video_id.

    			//move file from temp to tmp and rename it
			    $file = pathinfo($data['file'], PATHINFO_EXTENSION);
    			exec ( "mv '/var/www/multimedia/temp/".$data['file']."' /var/www/multimedia/tmp/".$insertVideo.'_'.USERID.'.'.$file );

    			//convert the video - edit the cron job will convert the videos
    		}
    	}

    	$this->view->videoupload = $fideoUploadForm;
    	$this->view->videos = Application_Model_Functions::toArray($fetchVideos);
    }


    /* acting is type 0 * dancer is type 2 * modeling is type 3 * musician is type 4 * if needed social is type 5 */
    public function editaudioAction()
    {
    	$request = $this->getRequest();
    	$audioConvert = new Application_Model_Audioconvertor();
    	$audio 	= new Media_Model_Songs();

    	$fetchAudio = $audio->fetchAll('talentnum = '.USERID, 'song_id DESC');
    	$audioUpload = new Profile_Form_Factory();
    	$fideoUploadForm = $audioUpload->editAudioUpload('acting');
    	$this->view->audioupload = $fideoUploadForm;
    	$this->view->audio = Application_Model_Functions::toArray($fetchAudio);;

    	if ($request->isPost()) {
    		if (isset($_POST['upload_audio']) && $fideoUploadForm->isValid($_POST)) {
    			$data = $fideoUploadForm->getValues();

    			$insertAudio = $audioConvert->insertAudio($data, 0, 'acting');

    			//move file from temp to tmp and rename it
			    $file = pathinfo($data['file'], PATHINFO_EXTENSION);

                exec ( "mv '/var/www/multimedia/temp_audio/".$data['file']."' /var/www/multimedia/tmp_audio/".$insertAudio.'_'.USERID.'.'.$file );

                //convert the video - edit the cron job will convert the videos
    		}
    	}

    }

    public function changeDetails()
    {
    	$info 	= new Talents_Model_Talentci();

    	$this->getInfo = $info->setTalentci();
    	$prop = $this->getInfo;

    	$height = ($prop->getTalentInfo1()->getHeightfeet() * 12) + $prop->getTalentInfo1()->getHeightinches();

    	return array(
    			'city' 		=>$prop->getTalentInfo2()->getCity1(),
    			'height'	=>$height,
    			'sex'       =>$prop->getTalentInfo1()->getSex(),
    			'weight'	=>$prop->getTalentInfo1()->getWeightpounds(),
    			'build'		=>$prop->getTalentInfo1()->getBuild(),
    			'bust'		=>$prop->getTalentInfo1()->getBust(),
    			'shirt'		=>$prop->getTalentInfo1()->getShirt(),
    			'waist'		=>$prop->getTalentInfo1()->getWaist(),
    			'hips'		=>$prop->getTalentInfo1()->getHips(),
    			'dobmm'		=>$prop->getTalentInfo1()->getDobmm(),
    			'dobdd'		=>$prop->getTalentInfo1()->getDobdd(),
    			'dobyyyy'	=>$prop->getTalentInfo1()->getDobyyyy(),
    			'hair'		=>$prop->getTalentInfo1()->getHaircolor(),
    			'hairstyle'	=>$prop->getTalentInfo1()->getHairstyle(),
    			'eyes'		=>$prop->getTalentInfo1()->getEyecolor(),
    			'dress'		=>$prop->getTalentInfo1()->getDress(),
    			'size'		=>$prop->getTalentInfo1()->getSuit(),
    			'shoe'		=>$prop->getTalentInfo1()->getShoes(),
    			'ethnicity' =>$prop->getTalentInfo2()->getEthnicity()
    		);
    }
}