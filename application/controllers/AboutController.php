<?php
class AboutController extends Zend_Controller_Action
{

	public function init()
	{
		$auth = Zend_Auth::getInstance();

		// added for seo
		echo $this->view->headTitle("Explore Talent | About The Largest Online Community for Talent");
		echo $this->view->headMeta()->appendName('keywords', "about us, about explore talent, about exploretalent.com, modeling jobs, acting auditions, casting calls, explore talent, exploretalent, exploretalent.com" );
		echo $this->view->headMeta()->appendName('description', "Explore Talent | About The World's Largest Online Community for Talent | Modeling Modeling Jobs Acting Auditions & Casting Calls - ExploreTalent.com" );

        $this->userObj = $userObj = $auth->getStorage()->read();

        $this->view->title = "Resources";

        $this->_helper->layout->setLayout('default');

        $this->view->headScript()->appendFile(CDN_JS_CSS.'/js/global/scroll.js');
	}

	public function indexAction(){}

	public function aboutUsAction(){}

	public function scamAction(){}

	public function genuineAction(){}

	public function fraudAction(){}

	public function legitAction(){}

	public function buzzAction(){}

	public function privacyAction(){}

	public function disclaimerAction(){}

	public function advertiseAction(){}

	public function industryAction()
	{
		// added for seo
		echo $this->view->headTitle("Explore Talent | Glossary of Industry Terms - ExploreTalent.com");
		echo $this->view->headMeta()->appendName('keywords', "industry terms, industry glossary, terms glossary, entertainment industry terms, entertainment glossary, modeling jobs, acting auditions, casting calls, explore talent, exploretalent, exploretalent.com" );
		echo $this->view->headMeta()->appendName('description', "Explore Talent | Glossary of Entertainment Industry Terms | Acting Auditions, Modeling, Modeling Jobs & Casting Calls - Only on ExploreTalent.com" );

	}

	public function contactusAction(){}

	public function faqAction(){}

	public function sitemapAction(){}

	public function howToGetVotesAction(){}

	public function scamAlertAction(){}

	public function castingCalendarHelpAction(){}

	public function mediaKitAction(){}

	public function agreementAction(){}

	public function helpAction()
	{
		$form = Requests_Form_Factory::formRequests();

		$request = $this->getRequest();

		if($request->isPost() && $form->isValid($request->getParams())){
			$data = $request->getParams();

			$model = new Requests_Model_Requests();
			$model->parseData($data);
			$model->sendEmail($data);
        }

		$this->view->form = $form;
	}

	public function exploreTalentAction(){}

	public function errorAction(){}

}