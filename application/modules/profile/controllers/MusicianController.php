<?php
class Profile_MusicianController extends Zend_Controller_Action {

	public $form;
	public $tnum;
	public $model;
	public $getMusic;
	public $musicinfo;
	private static $talentName;

    public function init()
    {
    	// added for seo
//    	$this->view->headTitle("Explore Talent | Search Our Talent for Auditions - ExploreTalent.com");
//    	$this->view->headMeta()->appendName('keywords', "casting calls, modeling jobs and acting auditions, modeling agencies, auditions for disney channel, disney channel auditions, movie extras, acting auditions, americas next top model, tyler perry casting, tyler perry studios, casting calls, disney casting auditions, plus size modeling, talent explore, reality show, game show, americas got talent auditions, reality shows, disney casting, movie auditions, plus size modeling agencies, nickelodeon auditions, singing auditions, auditions for disney, talent search, casting reality tv, modeling jobs, movie extra, casting auditions, disney channel auditions 2011, auditions for movies, auditions movie, teens modeling agency, disney channel casting, modeling agencies in chicago, singer jobs, glee auditions, disney channel audition, model search 2011, tyler perry auditions, hollywood auditions, become a model, model jobs, tyler perry studios jobs, pro scouts modeling and acting, casting real world, talent agency, extra in a movie, auditions for teens, singing auditions for kids, modeling jobs in atlanta, mtv auditions, modeling agencies in michigan, singing talent, music video auditions, explore talent, exploretalent, exploretalent.com" );
//    	$this->view->headMeta()->appendName('description', "Find Casting Calls | Thousands of New Jobs Posted Each Day | Free Access to Modeling Jobs, Acting Auditions, Music Jobs, Dance Auditions and Crew Jobs on ExploreTalent.com" );
//    	$this->view->headMeta()->appendName('og:title', "Explore Talent | Find Casting Calls, Modeling Jobs and Acting Auditions");

    	$this->view->title = "Acting/Modeling Profile";
    	$this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/profile/profile.css');

    	$this->_helper->layout->setLayout('profile');

    	$this->form 	= new Profile_Form_Factory();
    	$this->tnum 	= new Profile_Model_Profiles();
	    $this->tnum->useDependents(false);
    	$this->media 	= new Profile_Model_Mapper_Profiles();

	    $this->userid = Application_Model_Functions::getId();

		static::$talentName = Application_Model_Functions::getName(Application_Model_Functions::getId());

	    $auth = Application_Model_Functions::getName($this->userid);
	    $this->view->auth = $auth;

	    $this->view->info = static::$talentName;
	    $this->view->action_name = 'musician';
        $this->view->userid = $this->userid;
        $this->view->talentname = static::$talentName;
    }

    public function setMusic()
    {
    	$this->getMusic = $this->media->fetchGeneral('bam.talent_music', 'talentnum = '.$this->userid);

    	$this->musicinfo = $this->media->fetchMusicinfo($this->getMusic);
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

    	$this->setMusic();

    	$this->view->musicinfo = $this->musicinfo;

    	$musicMediaInfo = $this->media->fetchGeneral('bam.talent_media2_musician', 'talentnum = '.$this->userid, 'media_musician');
    	$this->view->musicmedia = $musicMediaInfo;

    	$modelResume = $this->media->fetchGeneral('bam.talent_resume', 'talentnum = '.$this->userid.' AND type = 3');
    	$resume = 'n/a'; $about = 'n/a';
        if(isset($modelResume[0])){
            $resume = $modelResume[0]->resume;
            $about = $modelResume[0]->about;
        }
        $this->view->resume = $resume;
        $this->view->about = $about;

        Profile_Model_ProfileSeo::putSeo($this->getInfo, 'musician');
    }

    public function similarTalentsAction()
    {
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/matchedProfiles.js');
    }

    public function audioAction()
    {
        $audio  = new Media_Model_Songs();

        $fetchAudio = $audio->fetchAll('talentnum = '.$this->userid.' AND type = 4 AND status = 1', 'song_id DESC');
        $this->view->audio = Application_Model_Functions::toArray($fetchAudio);
    }

    public function videoAction()
    {
        $video  = new Media_Model_Videos();

        $fetchVideos = $video->fetchAll('talentnum = '.$this->userid.' AND type = 4 AND status = 1');
        $this->view->videos = Application_Model_Functions::toArray($fetchVideos);
    }

    /**
     * this will generate teh gallerys
     */
    public function imageAction()
    {
        $model = new Profile_Model_Talentgallery();
        $pictures = $model->getImages(null, 'talent_media2_musician', 'media_musician');

        $this->view->allimages = $pictures;
    }

    /**
     * this will load the images from each gallery
     */
    public function galleryAction()
    {
        $request = $this->getRequest();

        $galleryId = $request->getParam('group');

	    $model = new Media_Model_Talentmedia2musician();

	    $model->useDependents(false);

	    $pictures = $model->fetchAll('talentnum = ? AND gallery = ?', null, null, null, null, [$this->userid, $galleryId]);

	    $this->view->allimages = Application_Model_Functions::toArray($pictures);
    }


    public function getmainPic()
    {
        $musicMediaMain = $this->media->fetchGeneral('bam.talent_media2_musician', 'talentnum = '.USERID.' AND type = 2', 'media_musician');
        if($musicMediaMain != null && isset($musicMediaMain[0])){
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

    	//edit details
    	$this->setMusic();
    	$formEditMusician = $this->form->editMusician($this->musicinfo, 'musician');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_acting_profile']) && $formEditMusician->isValid($_POST)) {
    			$data = $formEditMusician->getValues();

    			$this->tnum->editMusician($data);
    		}
    	}

    	//edit resume
    	$modelResume = $this->media->fetchGeneral('bam.talent_resume', 'talentnum = '.USERID.' AND type = 3');
    	$formEditResume = $this->form->editResume($modelResume, 'musician');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_resumes']) && $formEditResume->isValid($_POST)) {
    			$data = $formEditResume->getValues();

    			$this->tnum->updatedResume($data['id'], USERID, $data['edit_resume'], 'resume', '3', '');
    		}
    	}

    	//edit about
    	$formEditAbout = $this->form->editAbout($modelResume, 'musician');

    	if ($request->isPost()) {
    		if (isset($_POST['edit_abouts']) && $formEditAbout->isValid($_POST)) {
    			$data = $formEditAbout->getValues();

    			$this->tnum->updatedResume($data['id'], USERID, $data['edit_about'], 'about', '3', '');
    		}
    	}

    	$this->view->editresume 		= $formEditResume;
    	$this->view->editabout 			= $formEditAbout;
    	$this->view->editmusician 		= $formEditMusician;
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
        $formImageUpload = $this->form->imageUpload('musician');

    	if ($request->isPost()) {

    		if (isset($_POST['upload_picture']) && $formImageUpload->isValid($_POST)) {
    			$data = $formImageUpload->getValues();

    			$uploadModel->imageUpload($data['picture'], 'media/media_musician/', '2', 'bam.talent_media2_musician', null, 99);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('primary'=>'primary'));
    		}
    		if (isset($_POST['cropped_image_musician'])) {
    		    $uploadModel->uploadCroppedImage($_POST['filename'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
    		}
    	}

    	$this->getmainPic();

		//add/edit gallery
		$modelg = new Profile_Model_Talentgallery();

		$addGallery = $form->addCategory('musician');
		if ($request->isPost()) {
            if (isset($_POST['add_gallery']) && $addGallery->isValid($_POST)) {
				$addRes = $modelg->crudGallery($addGallery->getValues());
				$this->view->add_result = $addRes;
            }
            if (isset($_POST['delete_gallery'])) {
				$modelg->deleteGallery($request->getParams(), 'musician');
            }
        }
		$galleryData = $modelg->fetchAll('talentnum = '.USERID);
		$this->view->gallery = Application_Model_Functions::toArray($galleryData);

    	//secondary images
    	$formImageSecond = $this->form->imageUploadSecond('musician');

    	if ($request->isPost()) {
    		if (isset($_POST['upload_picture_second']) && $formImageSecond->isValid($_POST)) {
    			$data = $formImageSecond->getValues();

    			$uploadModel->imageUpload($data['picture'], 'media/media_musician/', '1', 'bam.talent_media2_musician', null, $data['user_gallery']);

				//add points
				$points = new Points_Model_Etpoints();
				$points->addPoints('picture', array('secondary'=>'secondary'));
    		}
    	}


    	// delete secondary images
    	$musicMediaInfo = $this->media->fetchGeneral('bam.talent_media2_musician', 'talentnum = '.USERID.' AND type = 1', 'media_musician');
    	$formImageDelete = $this->form->imageDelete($musicMediaInfo, 'musician');

    	if ($request->isPost()) {
    		if (isset($_POST['delete_picture']) && $formImageDelete->isValid($_POST)) {
    			$data = $formImageDelete->getValues();
    			$deleteArray = '';

    			foreach($data as $key=>$val){
    				if($val == 1)
    				$deleteArray[] = $key;
    			}

    			$uploadModel->deleteImage($deleteArray, 'talent_media2_musician');
    		}
    	}

    	$this->view->form 				= $formImageUpload;
        $this->view->addgallery    		= $addGallery;
    	$this->view->formImageSecond 	= $formImageSecond;
    	$this->view->deleteimage 		= $formImageDelete;
    }

    public function editvideoAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

        $video  = new Media_Model_Videos();

    	$request = $this->getRequest();
	    $id = $request->getParam('id');

    	$fetchVideos = $video->fetchAll('talentnum = '.USERID.' AND type = 4 AND status = 1');
	    $this->view->videos = Application_Model_Functions::toArray($fetchVideos);

    	$videoUpload = new Profile_Form_Factory();
    	$fideoUploadForm = $videoUpload->editVideoUpload('musician', $id);

    	$this->view->videoupload = $fideoUploadForm;

    	if ($request->isPost()) {

    		if (isset($_POST['upload_video']) && $fideoUploadForm->isValid($_POST)) {
    			$data = $fideoUploadForm->getValues();

			    $videoConvert = new Application_Model_Videoconvertor();
    			$insertVideo = $videoConvert->insertVideo($data, 4, 'musician');  //returns the video_id.

                //move file from temp to tmp and rename it
			    $file = pathinfo($data['file'], PATHINFO_EXTENSION);

                exec ( "mv '/var/www/multimedia/temp/".$data['file']."' /var/www/multimedia/tmp/".$insertVideo.'_'.USERID.'.'.$file );

                //convert the video - edit the cron job will convert the videos
    		}
    	}
    }

    public function editaudioAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

    	$this->view->headScript()->appendFile(CDN_JS_CSS.'/js/tinymce/tiny_mce.js');

    	$request = $this->getRequest();
    	$audioConvert = new Application_Model_Audioconvertor();

        $audio  = new Media_Model_Songs();

    	$fetchAudio = $audio->fetchAll('talentnum = '.USERID.' AND type = 4 AND status = 1');
    	$audioUpload = new Profile_Form_Factory();
    	$fideoUploadForm = $audioUpload->editAudioUpload('musician');
    	$this->view->audioupload = $fideoUploadForm;
    	$this->view->audio = Application_Model_Functions::toArray($fetchAudio);


    	if ($request->isPost()) {
    		if (isset($_POST['upload_audio']) && $fideoUploadForm->isValid($_POST)) {
    			$data = $fideoUploadForm->getValues();

    			$insertAudio = $audioConvert->insertAudio($data, 4, 'musician');

                //move file from temp to tmp and rename it
			    $file = pathinfo($data['file'], PATHINFO_EXTENSION);
                exec ( "mv '/var/www/multimedia/temp_audio/".$data['file']."' /var/www/multimedia/tmp_audio/".$insertAudio.'_'.USERID.'.'.$file );
                //convert the audio - edit the cron job will convert the audio
    		}
    	}
    }

    public function changeDetails()
    {
    	$talentnum = Application_Model_Functions::userid();
    	$model = new Talents_Model_Talentinfo2();
    	$prop = $model->fetchAll('talentnum = '.$talentnum);

    	$city = explode(",", str_replace(" ", "", $prop->getCity1()) );
	    $x = $city[1] ? $city[1] : $city[0];

    	if ($this->setMusic()){

    		$this->setMusic();
    		$music = $this->musicinfo;
    		//print_r($music); exit;
	    	return array(
	    			'city' 				=>$x,
	    			'band_name'			=>$music->band_name,
	    			'music_type2'		=>$music->music_type2,
	    			'music_type3'		=>$music->music_type3,
	    			'music_type4'		=>$music->music_type4,
	    			'music_type5'		=>$music->music_type5,
	    			'band_type'			=>$music->band_type,
	    			'genre'				=>$music->genre,
	    			'genre2'			=>$music->genre2,
	    			'genre3'			=>$music->genre3,
	    			'genre4'			=>$music->genre4,
	    			'record_label'		=>$music->record_label,
	    			'label_type'		=>$music->label_type,
	    			'number_of_gigs'	=>$music->number_of_gigs,
	    			'years_experience'	=>$music->years_experience,
	    			'management'		=>$music->management,
	    			'studio_musician' 	=>$music->studio_musician,
	    			'music_instruments' =>$music->music_instruments,
	    			'websites' 			=>$music->website,
	    			'des_1' 			=>$music->des_1,
	    			'major_influence' 	=>$music->major_influence,
	    			'searching_band'	=>$music->searching_band,
	    			'searching_band_mem'=>$music->searching_band_mem,
	    			'searching_gig' 	=>$music->searching_gig,
	    			'searching_gig_des' =>$music->searching_gig_des
	    	);
    	} else {
    		return array(
	    			'city' =>$x, 'band_name'=>'', 'music_type2'=>'', 'music_type3'=>'', 'music_type4'=>'', 'music_type5'=>'',
	    			'band_type'=>'', 'genre'=>'', 'genre2'=>'', 'genre3'=>'', 'genre4'=>'', 'record_label'=>'', 'label_type'=>'',
	    			'number_of_gigs'=>'', 'years_experience'=>'', 'management'=>'', 'studio_musician' =>'', 'music_instruments' =>'',
	    			'websites' =>'', 'des_1' =>'', 'major_influence' =>'', 'searching_band'=>'', 'searching_band_mem'=>'',
	    			'searching_gig' =>'', 'searching_gig_des' =>''
	    	);
    	}
    }
}