<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout->setLayout('homelayout');
        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/communitybuzz/ajax.js');

        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('acting', 'html')
                    ->addActionContext('modeling', 'html')
                    ->addActionContext('music', 'html')
                    ->addActionContext('dance', 'html')
                    ->addActionContext('crew', 'html')
                    ->addActionContext('contests', 'html')
                    ->addActionContext('featured', 'html')
                    ->initContext();
    }

    public function phpinfoAction()
    {
       Zend_Debug::dump(phpinfo()); exit;
    }

    // set the auditions area
    public function indexAction()
    {
 		$this->showAuditionSearchForm();
    	//$this->render('index');
    }

    public function actingAction()
    {
        $model = new Auditions_Model_Castings();
		$model->useDependents(false);
        $rows = $model->findByProjectType('acting', null , 6);

        $this->view->acting = Application_Model_Functions::toArray($rows);
    }

    public function modelingAction()
    {
    	$model = new Auditions_Model_Castings();
	    $model->useDependents(false);
        $rows = $model->findByProjectType('modeling', null, 6);

        $this->view->modeling = Application_Model_Functions::toArray($rows);
    }

    public function modelinggAction()
    {
    	$model = new Auditions_Model_Castings();
	    $model->useDependents(false);
        $rows = $model->findByProjectType('modeling', null, 6);

        $this->view->modeling = Application_Model_Functions::toArray($rows);
    }

    public function musicAction()
    {
    	$model = new Auditions_Model_Castings();
	    $model->useDependents(false);
    	$rows = $model->findByProjectType('music', null, 6);

    	$this->view->music = Application_Model_Functions::toArray($rows);
    }

    public function danceAction()
    {
    	$model = new Auditions_Model_Castings();
	    $model->useDependents(false);
        $rows = $model->findByProjectType('dance', null, 6);

    	$this->view->dance = Application_Model_Functions::toArray($rows);
    }

    public function crewAction()
    {
    	$model = new Auditions_Model_Castings();
	    $model->useDependents(false);
    	$rows = $model->findByProjectType('crew', null, 6);

    	$this->view->crew = Application_Model_Functions::toArray($rows);
    }

    public function showAuditionSearchForm()
    {
    	$form = new Application_Form_Auditionsearch(array(
            'name' => 'castings_form',
            'action' => '/auditions/index/index/',
            'method' => 'post'
        ));

    	$this->view->auditionSearch = $form;
    }

    public function contestsAction()
    {
        $model = new Contests_Model_Contests();
        $model->useDependents(false);
        $fetchContests = $model->fetchAll ('start_date < ' . time(), 'end_date DESC', 6);

        $this->view->result = Application_Model_Functions::toArray ($fetchContests);
    }

    public function featuredAction()
    {
        $model = new Talents_Model_Ftsearch();
        $model->useDependents (false);
        $result = $model->fetchAll (null, 'RAND()', 8);

        $this->view->result = Application_Model_Functions::toArray($result);
    }

    public function ExposureForm()
    {
    	$form = new Application_Form_Exposure(array(
            'name' => 'exposure_form',
            'action' => '/exposure/',
            'method' => 'post'
        ));

    	$this->view->exposure = $form;
    }

    public function setCounts()
    {
    	$view = $this->view;

    	$view->acting_count     = Auditions_Model_Castings::getCount('acting');
    	$view->modeling_count   = Auditions_Model_Castings::getCount('modeling');
    	$view->music_count      = Auditions_Model_Castings::getCount('music');
    	$view->dance_count      = Auditions_Model_Castings::getCount('dance');
    	$view->crew_count       = Auditions_Model_Castings::getCount('crew');
    	$view->all_count        = Auditions_Model_Castings::getCount('all');
    	$view->member_count     = Talents_Model_Talentci::getCount();
    }

    public function countAction()
    {
	    $this->getHelper('viewRenderer')->setNoRender();

	    $acting     = number_format(Auditions_Model_Castings::getCount('acting'));
	    $modeling   = number_format(Auditions_Model_Castings::getCount('modeling'));
	    $music      = number_format(Auditions_Model_Castings::getCount('music'));
	    $dance      = number_format(Auditions_Model_Castings::getCount('dance'));
	    $crew       = number_format(Auditions_Model_Castings::getCount('crew'));
	    $all        = number_format(Auditions_Model_Castings::getCount('all'));
	    $member     = number_format(Talents_Model_Talentci::getCount());

	    $array = array('acting'=>$acting, 'modeling'=>$modeling, 'music'=>$music, 'dance'=>$dance,
		            'crew'=>$crew, 'all'=>$all, 'member'=>$member);

	    echo Zend_Json::encode($array);
	    exit;
    }

}