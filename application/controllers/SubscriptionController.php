<?php
class SubscriptionController extends Zend_Controller_Action
{

    public function init()
    {
        if(!LOGGEDIN)
		{
			$this->_redirect('/join/flash');
		}
        $this->view->title = "Resources";

        $this->_helper->layout->setLayout('simple');
    }

    public function indexAction()
    {

    }

}