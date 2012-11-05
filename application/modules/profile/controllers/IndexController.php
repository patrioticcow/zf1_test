<?php
class Profile_IndexController extends Zend_Controller_Action {

 	public function init()
    {
    	// added for seo
    	$this->view->headTitle("Explore Talent | Search Our Talent for Auditions - ExploreTalent.com");
    	$this->view->headMeta()->appendName('keywords', "casting calls, modeling jobs and acting auditions, modeling agencies, auditions for disney channel, disney channel auditions, movie extras, acting auditions, americas next top model, tyler perry casting, tyler perry studios, casting calls, disney casting auditions, plus size modeling, talent explore, reality show, game show, americas got talent auditions, reality shows, disney casting, movie auditions, plus size modeling agencies, nickelodeon auditions, singing auditions, auditions for disney, talent search, casting reality tv, modeling jobs, movie extra, casting auditions, disney channel auditions 2011, auditions for movies, auditions movie, teens modeling agency, disney channel casting, modeling agencies in chicago, singer jobs, glee auditions, disney channel audition, model search 2011, tyler perry auditions, hollywood auditions, become a model, model jobs, tyler perry studios jobs, pro scouts modeling and acting, casting real world, talent agency, extra in a movie, auditions for teens, singing auditions for kids, modeling jobs in atlanta, mtv auditions, modeling agencies in michigan, singing talent, music video auditions, explore talent, exploretalent, exploretalent.com" );
    	$this->view->headMeta()->appendName('description', "Find Casting Calls | Thousands of New Jobs Posted Each Day | Free Access to Modeling Jobs, Acting Auditions, Music Jobs, Dance Auditions and Crew Jobs on ExploreTalent.com" );
    	$this->view->headMeta()->appendName('og:title', "Explore Talent | Find Casting Calls, Modeling Jobs and Acting Auditions");

    	$this->view->title = "Acting/Modeling Profile";

    	$this->view->headLink()->appendStylesheet(CDN_JS_CSS.'/css/profile/profile.css');

    	$this->_helper->layout->setLayout('profile');

        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/sendmessage.js');
    }

    public function indexAction(){}

    public function sendmessageAction()
    {
        $request = $this->getRequest();

        $message = $request->getParam('message');
        $from    = $request->getParam('from');
        $to      = $request->getParam('to');

        $model = new Profile_Model_Messages();

        $data = array( 'from'=>$from, 'too'=>$to, 'message'=>$message, 'sent_date'=>time() );

        $id = $model->create($data);

        echo $id; exit();
    }

    public function deletemessageAction()
    {
        $request = $this->getRequest();
        $msgid = $request->getParam('msgid');

        $model = new Profile_Model_Messages();

        $model->delete($msgid);
        echo $msgid;
        exit();
    }

    public function messagesAction()
    {
        $model = new Profile_Model_Messages();

        $data = $model->parseData();

        $this->view->messages = Application_Model_Functions::arrayObj($data);

    }

    public function viewedAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

        $model = new Profile_Model_Profileviews();
        $data = $model->parseData('viewed');

        $this->view->data = $data;

    }

    public function viewsAction()
    {
        if(!LOGGEDIN){ $this->_helper->redirector->gotoUrl('/');}

        $model = new Profile_Model_Profileviews();
        $data = $model->parseData('views');

        $this->view->data = $data;
    }

    public function recommendjobAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();

        //$job    = $request->getParam('job');
        $from   = USERID;
        $too    = $request->getParam('too');
        $link    = $request->getParam('link');
        $title    = $request->getParam('title');

        $message = "
            Check out this job <a href='".$link."'>".$title."</a>
        ";

        $model = new Profile_Model_Messages();

        $data = array( 'from'=>$from, 'too'=>$too, 'message'=>$message, 'sent_date'=>time() );

        $id = $model->create($data);

        echo $id;

        exit();
    }

    public function profileviewsAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $profileId = $request->getParam('profileId');

        $model = new Profile_Model_Profileviews();
        $model->delete($profileId);

        exit;
    }
}
