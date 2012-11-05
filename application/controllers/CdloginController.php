<?php
class CdloginController extends Zend_Controller_Action
{
	/**
	 * login  = 1
	 * logout = 2
	 */
	public function init()
	{
		$this->view->title = "Casting Director Login";

		$this->_helper->layout->setLayout('simple');
	}

    public function indexAction()
    {
    	$auth = Zend_Auth::getInstance();

    	if (FALSE == $auth->hasIdentity())
    	{
            $this->view->form = $this->getForm();
    	}
		else
		{
			$userObj = $auth->getStorage()->read();

			if($userObj->role != 'talent')
			{
			    $message = 'You must be a Talent to user this portion of the site.';

			    $this->view->messages = $message;

			    $this->view->form = $this->getTalentLoginForm();
			}
		}
    }

	public function getForm()
    {
        return new Application_Form_Cdlogin(array(
            'action' => '/cdlogin/process',
            'method' => 'post',
        ));
    }

	public function getTalentLoginForm()
    {
        return new Application_Form_Login(array(
            'action' => '/login/process',
            'method' => 'post',
        ));
    }

    public function logoutAction()
    {
    	Zend_Auth::getInstance()->getStorage()->read();

        Zend_Auth::getInstance()->clearIdentity();

        $this->_helper->redirector('index', 'login'); // back to login page
    }

    public function processAction()
    {
    	$request = $this->getRequest();

        $form = $this->getForm();

        if (!$form->isValid($request->getPost()))
        {
              // Invalid entries
            $this->view->form = $form;

            return $this->render('index'); // re-render the login form
        }

        //this is for redirecting back to referrer page and uses a hidden field in login form
    	//$refpage = explode('-',$request->getParam('refpage'));

        // authenticate
    	$auth = new Application_Model_Authcd();

    	if(false == $auth->process())
    	{
    		$form->setDescription('Invalid credentials provided');

    		$this->view->form = $form;

    		$this->render('index');

    		return;
    	}
    	else
    	{
    	    $userObj = Zend_Auth::getInstance()->getStorage()->read();

    		if($userObj->role == 'cd')
    		{
    			$this->_helper->redirector('index', 'index', 'cduser');
    		}
    	}

    	$this->_helper->viewRenderer->setNoRender(true);
    }
}
