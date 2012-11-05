<?php
class LoginController extends Zend_Controller_Action
{
	/**
	 * login  = 1
	 * logout = 2
	 */
	public function init()
	{
		$this->view->title = "LOGIN HERE";
		
		$this->_helper->layout->setLayout('default');
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
			
			    $this->view->form = $this->getForm();
			}
			
		}
    }
	
	public function cdloginAction()
    {
    	$auth = Zend_Auth::getInstance();
		
    	if (FALSE == $auth->hasIdentity()) 
    	{
            $this->view->form = $this->getForm();
    	}
		else 
		{
			$userObj = $auth->getStorage()->read(); 
			
			if($userObj->role != 'cd')
			{
			    $message = 'You must be a Casting Director to user this portion of the site.';
			
			    $this->view->messages = $message;
			
			    $this->view->form = $this->getCdLoginForm();
			}
			
		}
		$this->render('index');
    }
    
    public function adminAction()
    {
    	$auth = Zend_Auth::getInstance();
    
    	if (FALSE == $auth->hasIdentity())
    	{
    		$this->view->form = $this->getForm();
    	}
    	else
    	{
    		$userObj = $auth->getStorage()->read();
    			
    		if($userObj->role != 'admin')
    		{
    			$message = 'You must be an Administrator to user this portion of the site.';
    				
    			$this->view->messages = $message;
    				
    			$this->view->form = $this->getForm();
    		}
    			
    	}
    	$this->render('index');
    }
	
	public function getCdLoginForm()
    {
        return new Application_Form_Cdlogin(array(
            'action' => '/cdlogin/process',
            'method' => 'post',
        ));
    }
    
    public function getForm()
    {
        return new Application_Form_Login(array(
            'action' => SECURE_DOMAIN.'/login/process',
            'method' => 'post',
        ));
    }

    public function logoutAction()
    {
    	$userObj = Zend_Auth::getInstance()->getStorage()->read();
    	
    	if($userObj->role == 'cd')
        {
        	Zend_Auth::getInstance()->clearIdentity();
        
            $this->_helper->redirector('index', 'login'); // back to login page
        }
    	
        If(ROLE == 'talent')
        {
    	$setLogin = new Online_Model_Etonline();
    	
    	$getTalent = $setLogin->fetchAll('talentnum = '.$userObj->talentnum, null, 1);
    	
    	$setLogin->create(array(
    			'id' 		=> $getTalent->_id,
    			'talentnum' => $userObj->talentnum,
    			'type' => 2
    	)); 
    	
        }
        Zend_Auth::getInstance()->clearIdentity();
        
        $this->_redirect(STAFF_DOMAIN.'/logout.php');
        //exit;
        //$this->_helper->redirector('index', 'login'); // back to login page
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
    	$refpage = explode('-',$request->getParam('refpage'));
    	
        // authenticate
    	$auth = new Application_Model_Auth();
    	
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
    	     
    	    /*set user as login*/
    	    $setLogin = new Online_Model_Etonline();
    	    
    	    $getTalent = $setLogin->fetchAll('talentnum = '.$userObj->talentnum, null, 1);

    	    if($getTalent != null)
    	    {
	    	    $setLogin->create(array(
	    	    		'id' 		=> $getTalent->_id,
	    	    		'talentnum' => $userObj->talentnum,
	    	    		'type' 		=> 1
	    	    ));
    	    } 
    	    else 
    	    {
    	    	$setLogin->create(array(
    	    			'talentnum' => $userObj->talentnum,
    	    			'type' 		=> 1
    	    	));
    	    }
    	    
    		 if($userObj->role == 'talent')
    		 { 
    			 $this->_helper->redirector($userObj->talentnum, 'social', 'profile');
    		 }
    		 else 
    		 {   
    			if($refpage[0] == '')
    			{ 
    				 $this->_helper->redirector('index', 'index', '');
    			}
    			else 
    			{
    		        $this->_helper->redirector($refpage[0], $refpage[1], $refpage[2]);
    			}
    		}
    	}
    	
    	$this->_helper->viewRenderer->setNoRender(true);
    }
}
