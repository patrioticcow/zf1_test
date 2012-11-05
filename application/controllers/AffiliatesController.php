<?php
class AffiliatesController extends Zend_Controller_Action
{

	public function init()
	{
		$auth = Zend_Auth::getInstance();

        $this->userObj = $userObj = $auth->getStorage()->read();

        $this->view->title = "Resources";

        $this->_helper->layout->setLayout('default');
	}

	public function indexAction()
	{

	}
}