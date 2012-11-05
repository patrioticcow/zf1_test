<?php 
class Api_AclPlugin extends Zend_Controller_Plugin_Abstract
{
	public $userObj;
	
	public $acl;
	
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        /*$this->getResponse()
             ->appendBody("<p>routeStartup() called</p>\n")
             ->appendBody("We can use this as a menu plugin<br />
                           Or maybe we'll use it as a second DB conn. or even a partial!");*/
    }
 
   /* public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $this->getResponse()
             ->appendBody("<p>routeShutdown() called</p>\n");
    }
 
    public function dispatchLoopStartup(
        Zend_Controller_Request_Abstract $request)
    {
        $this->getResponse()
             ->appendBody("<p>dispatchLoopStartup() called</p>\n");
    }
 */
    
    private function getUserObject()
    {
    	$auth = Zend_Auth::getInstance();
        
        if($this->userObj = $auth->getStorage()->read())
            return $this->userObj;
    }
    
    public function acl($resource = null)
    {
    	$front = Zend_Controller_Front::getInstance();
    	$request = $front->getRequest();
    	
        $this->setUserObject();
    	
        $acl = new Application_Model_Acl();
        
    	$acl = $acl->init();
    	
    	// if not a valid user or not valid resource send back to login and set the refer path
        if (FALSE == $userObj || !$acl->isAllowed($userObj->role, 'talentResource')) 
    	{
    		$refpage = array('a' => $request->getActionName(), 
                             'c' => $request->getControllerName(),
                             'm' => $request->getModuleName());
    		return($refpage);
            //$front->_helper->redirector('index', 'login', 'default', array('refpage' => implode('-', $refpage)));                                  
    	}
    	return false;
    }
}
 