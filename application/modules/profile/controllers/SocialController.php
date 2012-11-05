<?php
class Profile_SocialController extends Zend_Controller_Action
{
    public $userid;

    private static $talentName;

    public function init()
    {
        $this->view->title = "Acting/Modeling Profile";
        $this->view->headLink ()->appendStylesheet ('/css/profile/profile.css');

        $this->_helper->layout->setLayout ('profile');

        $this->userid =$this->getRequest()->getParam('id');

        $this->view->headLink ()->appendStylesheet ('/css/jquery.Jcrop.css');
        $this->view->headScript()->appendFile ('/js/jquery.carouFredSel-5.6.2.js');
        $this->view->headScript()->appendFile ('/js/global/social_info_gallery.js');
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/sendmessage.js');

        $this->view->headScript ()->appendFile ('/js/jcrop/jquery.Jcrop.min.js');
        $this->view->headScript ()->appendFile ('/js/jcrop/crop.js');

        //save profile views
        if (LOGGEDIN) {
            $viewes = new Profile_Model_Profileviews();
            $viewes->profileViewes ();
        }

        $this->view->userid = $this->userid;
        static::$talentName = Application_Model_Functions::getName (Application_Model_Functions::getId());
    }

    public function indexAction()
    {
        $this->view->headScript ()->appendFile ('/js/global/myWall.js');
        $this->sidebarAction();

        //wall form here
        $formMsg = new Wallmessages_Form_Factory();
        $formCmm = new Wallcomments_Form_Factory();
        $this->view->messageform = $formMsg->wallMessages ();
        $this->view->commentform = $formCmm->wallComments ();

        $info = new Talents_Model_Talentci();

        $this->getInfo = $info->setTalentci();

        $this->view->info = $this->getInfo;
        $this->view->notme = $this->userid;
    }

    public function editinfoAction()
    {
        $this->_helper->redirector->gotoUrl (SECURE_DOMAIN . '/talents/index/update');
        $this->view->talentname = static::$talentName;
    }

    public function socialInfoAction()
    {
        $form = new Profile_Form_Factory();
        $coverForm = $form->imageUploadBoard('social-info');
        $request = $this->getRequest ();
        if ($request->isPost()) {
            if (isset($_POST['upload_picture_cover']) && $coverForm->isValid($_POST))
            {
                $model = new Application_Model_Upload();
                $data = $coverForm->getValues();
                $model->imageUpload($data['file_upload'], 'media/media_cover/', '8');
            }
            else if(isset($_POST['remove_picture_cover']))
            {
                $image = Media_Model_MediaAbstract::getSocialPic(USERID, 'media_cover', null, 'cover', true);
                unlink($image);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $flashMessenger->addMessage(array('success'=>'Image Removed Successfully'));
                $this->view->messages = $flashMessenger->getMessages();
            }
            else
            {
                $errorss = '';
                $errors = $coverForm->getMessages();
                if(isset( $errors['file_upload'])){
                    $errorss = $errors['file_upload'];
                }
                $this->view->errors = $errorss;
            }
        }

        // this is for the fucking old links.
        $tal = $this->getRequest()->getParam('talentnum');
        if(isset($tal)){
            $this->getRequest()->setParam('id', $this->getRequest()->getParam('talentnum'));
            $this->userid = $this->_request->id;
        }

        // if the id is missing, go to the homepage for now
        if($this->userid == null){
            $this->_helper->redirector->gotoUrl ('/');
        }

        $info = new Talents_Model_Talentci();

        $getInfo = $info->setTalentci();
        $this->view->info = $getInfo;

        $this->view->talentname = static::$talentName;

        $media = new Profile_Model_Mapper_Profiles();

        $socialResume = $media->fetchGeneral ('bam.talent_resume', 'talentnum = ' . $this->userid . ' AND type = 5');

        $resume = 'n/a';
        $about = 'n/a';
        if (isset($socialResume[0])) {
            $resume = $socialResume[0]->resume;
            $about = $socialResume[0]->about;
        }
        $this->view->resume = $resume;
        $this->view->about = $about;

        //relationship
        $arrtRel = new Profiles_Model_Attributesrelationship();
        $arrtRelData = $arrtRel->fetchAll('talentnum = '.$this->userid);

        $this->view->relationship = $arrtRelData != null ? $arrtRelData->getAttrRelationship()->getRelationshipType() : 'n/a';

        $this->view->notme = $this->userid;

        //cover photo
        $this->view->cover = $coverForm;
        Profile_Model_ProfileSeo::putSocialSeo($getInfo);
    }

    public function socialEditAction()
    {
        if (!LOGGEDIN) {
            $this->_helper->redirector->gotoUrl ('/');
        }

        $request = $this->getRequest ();

        $form = new Profile_Form_Factory();
        $tnum = new Profile_Model_Profiles();
        $tnum->useDependents(false);

        $editActingProfile = $form->editActing ($this->changeDetails (), 'acting');

        if ($request->isPost ()) {
            if (isset($_POST['edit_acting_profile']) && $editActingProfile->isValid ($_POST)) {
                $data = $editActingProfile->getValues ();
                $tnum->editActing ($data);
            }
            if (isset($_POST['edit_talent_interests'])) {
                $tinfo2 = new Talents_Model_Talentinfo2();

                $tinfo2->saveInterests ($request->getParam('interest'));
            }
            if (isset($_POST['edit_talent_attr_relationship'])) {
                $arrtRel = new Profiles_Model_Attributesrelationship();
                $arrtRel->saveRelationship($request->getParams());
            }
        }

        //edit Talent info
        $this->view->editacting = $editActingProfile;

        // edit interests
        $editInterests = $form->editInterests('acting');
        $this->view->editinterests = $editInterests;

        // edit relationship
        $editRelationship = $form->editRelationship('acting');
        $this->view->editrelationship = $editRelationship;

        $this->view->talentname = static::$talentName;
    }

    public function editaudioAction()
    {
        if (!LOGGEDIN) {
            $this->_helper->redirector->gotoUrl ('/');
        }

        $request = $this->getRequest ();
        $audioConvert = new Application_Model_Audioconvertor();
        $audio = new Media_Model_Songs();

        $fetchAudio = $audio->fetchAll ('talentnum = ' . USERID . ' AND type = 5');
        $audioUpload = new Profile_Form_Factory();
        $fideoUploadForm = $audioUpload->editAudioUpload ('acting');
        $this->view->audioupload = $fideoUploadForm;
        $this->view->audio = Application_Model_Functions::toArray ($fetchAudio);


        if ($request->isPost ()) {
            if (isset($_POST['upload_audio']) && $fideoUploadForm->isValid ($_POST)) {
                $data = $fideoUploadForm->getValues ();

                $insertAudio = $audioConvert->insertAudio ($data, 5, 'acting');

                //move file from temp to tmp and rename it
                $file = pathinfo($data['file'], PATHINFO_EXTENSION);
                exec ("mv /var/www/multimedia/temp_audio/" . $data['file'] . " /var/www/multimedia/tmp_audio/" . $insertAudio . '_' . USERID . '.' . $file);

                //convert the video - edit the cron job will convert the videos
            }
        }

        $this->view->talentname = static::$talentName;

    }

    public function editvideoAction()
    {
        if (!LOGGEDIN) {
            $this->_helper->redirector->gotoUrl ('/');
        }

        $request = $this->getRequest ();
        $videoConvert = new Application_Model_Videoconvertor();
        $video = new Media_Model_Videos();

        $fetchVideos = $video->fetchAll ('talentnum = ' . USERID . ' AND type = 5');
        $videoUpload = new Profile_Form_Factory();
        $fideoUploadForm = $videoUpload->editVideoUpload ('acting');
        $this->view->videoupload = $fideoUploadForm;
        $this->view->videos = Application_Model_Functions::toArray ($fetchVideos);


        if ($request->isPost ()) {
            if (isset($_POST['upload_video']) && $fideoUploadForm->isValid ($_POST)) {
                $data = $fideoUploadForm->getValues ();

                $insertVideo = $videoConvert->insertVideo ($data, 5, 'social'); //returns the video_id.

                //move file from temp to tmp and rename it
                $file = pathinfo($data['file'], PATHINFO_EXTENSION);
                exec ("mv '/var/www/multimedia/temp/" . $data['file'] . "' /var/www/multimedia/tmp/" . $insertVideo . '_' . USERID . '.' . $file);

                //convert the video - edit the cron job will convert the videos
            }
        }
    }


    public function myactivityAction()
    {
        $this->sidebarAction ();

        $this->view->talentname = static::$talentName;

    }

    public function sidebarAction()
    {
        $this->view->headLink ()->appendStylesheet ('/css/global/wall.css');
        $this->view->headScript ()->appendFile ('/js/global/notifications.js');

        // enable profile
        $this->enableProfile();

        $this->view->userid = $this->userid;
        $this->view->friend = $this->userid;

        //check if online
        $online = Application_Model_Functions::getOnline ($this->userid);
        $this->view->isonline = $online;

        if (LOGGEDIN) {
            $friendsNot = Application_Model_Functions::fetchFriends ();
            $this->view->friendsnot = $friendsNot;
        }

        // get main pic
        $primaryimage = Media_Model_MediaAbstract::getSocialPic ($this->userid, 'media_social');
        $this->view->primaryimage = $primaryimage;

        // get main pic for the comment
        if (LOGGEDIN) {
            $commentImage = Media_Model_MediaAbstract::getSocialPic(USERID, 'media_social');
            $this->view->commentimage = $commentImage;
        }

    }

    public function enableProfile()
    {
        $tnum = new Profile_Model_Profiles(); $tnum->useDependents(false);

        if (isset($_POST['enable_profiles']))
        {
            $post = $this->getRequest()->getParams();

            $data = array(
                'acting' => $post['acting'],
                'musician' => $post['musician'],
                'dancer' => $post['dancer']
            );

            $tnum->updateProfile($data);
        }
    }

    public function editAction()
    {
        if (!LOGGEDIN) {
            $this->_helper->redirector->gotoUrl ('/');
        }

        $form = new Profile_Form_Factory();
        $tnum = new Profile_Model_Profiles(); $tnum->useDependents(false);
        $media = new Profile_Model_Mapper_Profiles();
        $model = new Application_Model_Upload();

        $request = $this->getRequest ();

        //primary image
        $formImageUpload = $form->imageUpload ('social');

        if ($request->isPost ()) {
            if (isset($_POST['upload_picture']) && $formImageUpload->isValid ($_POST)) {
                $data = $formImageUpload->getValues ();

                $model->imageUpload ($data['file_upload'], 'media/media_social/', '2', 'bam.talent_media2_social', null, 99);

                //add points
                $points = new Points_Model_Etpoints();
                $points->addPoints ('picture', array('primary' => 'primary'));

            }
            if (isset($_POST['cropped_image_social'])) {

                $model->uploadCroppedImage ($_POST['filename'], $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
            }
        }

        //add/edit gallery
        $modelg = new Profile_Model_Talentgallery();

        $addGallery = $form->addCategory ('social');
        if ($request->isPost ()) {
            if (isset($_POST['add_gallery']) && $addGallery->isValid ($_POST)) {
                $addRes = $modelg->crudGallery ($addGallery->getValues ());
                $this->view->add_result = $addRes;
            }
            if (isset($_POST['delete_gallery'])) {
                $modelg->deleteGallery ($request->getParams (), 'social');
            }
        }
        $galleryData = $modelg->fetchAll ('talentnum = ' . USERID);
        $this->view->gallery = Application_Model_Functions::toArray ($galleryData);


        //secondary images
        $formImageSecond = $form->imageUploadSecond ('social');

        if ($request->isPost ()) {
            if (isset($_POST['upload_picture_second']) && $formImageSecond->isValid ($_POST)) {
                $data = $formImageSecond->getValues ();

                $model->imageUpload ($data['picture'], 'media/media_social/', '1', 'bam.talent_media2_social');

                //add points
                $points = new Points_Model_Etpoints();
                $points->addPoints ('picture', array('secondary' => 'secondary'));
            }
        }


        // delete secondary images
        $musicMediaInfo = $media->fetchGeneral ('bam.talent_media2_social', 'talentnum = ' . USERID . ' AND type = 1', 'media_social');
        $formImageDelete = $form->imageDelete ($musicMediaInfo, 'social');

        if ($request->isPost ()) {
            if (isset($_POST['delete_picture']) && $formImageDelete->isValid ($_POST)) {
                $data = $formImageDelete->getValues ();
                $deleteArray = '';

                foreach ($data as $key => $val) {
                    if ($val == 1)
                        $deleteArray[] = $key;
                }

                $model->deleteImage ($deleteArray, 'bam.talent_media2_social');
            }
        }


        //edit resume
        $modelResume = $media->fetchGeneral ('bam.talent_resume', 'talentnum = ' . USERID . ' AND type = 5');
        $formEditResume = $form->editResume ($modelResume, 'modeling');

        if ($request->isPost ()) {
            if (isset($_POST['edit_resumes']) && $formEditResume->isValid ($_POST)) {
                $data = $formEditResume->getValues ();

                $tnum->updatedResume ($data['id'], USERID, $data['edit_resume'], 'resume', '5', '');
            }
        }

        //edit about
        $formEditAbout = $form->editAbout ($modelResume, 'modeling');

        if ($request->isPost ()) {
            if (isset($_POST['edit_abouts']) && $formEditAbout->isValid ($_POST)) {
                $data = $formEditAbout->getValues ();

                $tnum->updatedResume ($data['id'], USERID, $data['edit_about'], 'about', '5', '');
            }
        }

        $this->view->form = $formImageUpload;
        $this->view->formImageSecond = $formImageSecond;
        $this->view->deleteimage = $formImageDelete;
        $this->view->editresume = $formEditResume;
        $this->view->editabout = $formEditAbout;

        $picVal = $this->getmainPic ();

        $this->view->imagepath = $picVal;

        $this->view->talentname = static::$talentName;
        $this->view->infoedit = $this->getRequest()->getParam('info');

    }

    public function getmainPic()
    {
        $media = new Profile_Model_Mapper_Profiles();
        $musicMediaMain = $media->fetchGeneral ('bam.talent_media2_social', 'talentnum = ' . USERID . ' AND type = 2', 'media_social');
        if ($musicMediaMain != null) {
            $val = $musicMediaMain[0]->full_path;
        } else {
            $val = '';
        }

        return $val;
    }

    public function changeDetails()
    {
        $info = new Talents_Model_Talentci();

        $this->getInfo = $info->setTalentci ();
        $prop = $this->getInfo;

        $height = ($prop->getTalentInfo1 ()->getHeightfeet () * 12) + $prop->getTalentInfo1 ()->getHeightinches ();
        //$city = explode(",", str_replace(" ", "", $prop->getTalentInfo2()->getCity1()) );
        //$x = $city[1] ? $city[1] : $city[0];

        return array(
            'city' => $prop->getTalentInfo2 ()->getCity1 (),
            'height' => $height,
            'sex' => $prop->getTalentInfo1 ()->getSex (),
            'weight' => $prop->getTalentInfo1 ()->getWeightpounds (),
            'build' => $prop->getTalentInfo1 ()->getBuild (),
            'bust' => $prop->getTalentInfo1 ()->getBust (),
            'shirt' => $prop->getTalentInfo1 ()->getShirt (),
            'waist' => $prop->getTalentInfo1 ()->getWaist (),
            'hips' => $prop->getTalentInfo1 ()->getHips (),
            'dobmm' => $prop->getTalentInfo1 ()->getDobmm (),
            'dobdd' => $prop->getTalentInfo1 ()->getDobdd (),
            'dobyyyy' => $prop->getTalentInfo1 ()->getDobyyyy (),
            'hair' => $prop->getTalentInfo1 ()->getHaircolor (),
            'hairstyle' => $prop->getTalentInfo1 ()->getHairstyle (),
            'eyes' => $prop->getTalentInfo1 ()->getEyecolor (),
            'dress' => $prop->getTalentInfo1 ()->getDress (),
            'size' => $prop->getTalentInfo1 ()->getSuit (),
            'shoe' => $prop->getTalentInfo1 ()->getShoes (),
            'ethnicity' => $prop->getTalentInfo2 ()->getEthnicity ()
        );
    }

    public function socialinfogalleryAction()
    {
        $this->getHelper('viewRenderer')->setNoRender();

        $userid = $this->getRequest()->getParam('userid');

        $data = $this->getSocialInfoPic($userid);

        $actingArray = $modelingArray = $musicianArray = $danceArray = $dynamicArray =array();
        if($data['actingResult'] != null){
            foreach($data['actingResult'] as $key=>$value){
                $actingArray[$key]['path'] = $value->getFullMediaPath();
            }
        }
        if($data['modelingResult'] != null){
            foreach($data['modelingResult'] as $key=>$value){
                $modelingArray[$key]['path'] = $value->getFullMediaPath();
            }
        }
        if($data['musicianResult'] != null){
            foreach($data['musicianResult'] as $key=>$value){
                $musicianArray[$key]['path'] = $value->getFullMediaPath();
            }
        }
        if($data['danceResult'] != null){
            foreach($data['danceResult'] as $key=>$value){
                $danceArray[$key]['path'] = $value->getFullMediaPath();
            }
        }
        if($data['dynamicResult'] != null){
            foreach($data['dynamicResult'] as $key=>$value){
                $dynamicArray[$key]['path'] = $value->getFullMediaPath();
            }
        }

        $main = array_merge($actingArray, $modelingArray, $musicianArray, $danceArray, $dynamicArray);

        echo Zend_Json_Encoder::encode($main); exit;
    }

    public function contestsAction()
    {
        $this->sidebarAction ();

        //get contesta
        $front = Zend_Controller_Front::getInstance ();
        $this->userid = $front->getRequest ()->getParam ('id');

        //add points for contests
        if (LOGGEDIN) {
            $model = new Contestant_Model_Contestant();
            $model->useDependents (false);
            $data = $model->fetchAll ('talentnum = ' . USERID);

            $points = new Points_Model_Etpoints();
            $points->addPoints ('contest', Application_Model_Functions::toArray ($data));
        }

        $c = new Contests_Model_Contests();
        $this->view->contests = $c->getContests ($this->userid);

        $this->view->talentname = static::$talentName;
    }

    public function getSocialInfoPic($userid = null)
    {
        if($userid == null){
            $userid = $this->getRequest()->getParam ('id');
        }

        $mediaActingModel = new Media_Model_Talentmedia2acting();
        $mediaActingModel->useDependents (false);
        $mediaModelingModel = new Media_Model_Talentmedia2modeling();
        $mediaModelingModel->useDependents (false);
        $mediaMusicianModel = new Media_Model_Talentmedia2musician();
        $mediaMusicianModel->useDependents (false);
        $mediaDanceModel = new Media_Model_Talentmedia2dance();
        $mediaDanceModel->useDependents (false);
        $mediaDinamicModel = new Profiles_Model_Profilemedia();
        $mediaDinamicModel->useDependents (false);

        $mediaActingResult = $mediaActingModel->fetchAll ('talentnum = ? AND type <> ?', 'id DESC', 5, null, null, [$userid, 2]);
        $mediaModelingResult = $mediaModelingModel->fetchAll ('talentnum = ? AND type <> ?', 'id DESC', 5, null, null, [$userid, 2]);
        $mediaMusicianResult = $mediaMusicianModel->fetchAll ('talentnum = ? AND type <> ?', 'id DESC', 5, null, null, [$userid, 2]);
        $mediaDanceResult = $mediaDanceModel->fetchAll ('talentnum = ? AND type <> ?', 'id DESC', 5, null, null, [$userid, 2]);
        $mediaDynamicResult = $mediaDinamicModel->fetchAll ('talentnum = ? AND type <> ?', 'profile_media_id DESC', 5, null, null, [$userid, 1]);

        $actingResult = Application_Model_Functions::toArray ($mediaActingResult);
        $modelingResult = Application_Model_Functions::toArray ($mediaModelingResult);
        $musicianResult = Application_Model_Functions::toArray ($mediaMusicianResult);
        $danceResult = Application_Model_Functions::toArray ($mediaDanceResult);
        $dynamicResult = Application_Model_Functions::toArray ($mediaDynamicResult);

        return array('actingResult' => $actingResult, 'modelingResult' => $modelingResult, 'musicianResult' => $musicianResult, 'danceResult' => $danceResult, 'dynamicResult' => $dynamicResult);
    }
}