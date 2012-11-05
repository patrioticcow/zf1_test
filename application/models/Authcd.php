<?php
class Application_Model_Authcd 
{
    public function process() 
    { 
        $front = Zend_Controller_Front::getInstance();
        
        $values = $front->getRequest()->getParams();
        
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        
        $adapter->setIdentity($values['login']); 
        
        $adapter->setCredential($values['pass']);
        
        $auth = Zend_Auth::getInstance();
       
        $result = $auth->authenticate($adapter);
        
        //if authentication successful - else return false 
        if ($result->isValid()) 
        {   
            $data = $adapter->getResultRowObject(array(
                    'login',
                    'pass',
                    'user_id'
            ));

            $data->username = $data->login;
            $data->userid = $data->user_id;
            $data->role = 'cd';
            
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            
            $auth->getStorage()->write($data);
            
            return true;
        }
        return false;
    }
    
    private function _getAuthAdapter() 
    { 
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        
        $authAdapter->setTableName('cd_user')
                    ->setIdentityColumn(array('login'))
                    ->setCredentialColumn('pass');
                    //->setCredentialTreatment('SHA1(?)');
        
        return $authAdapter;
    }
    
    public static function authorize($resource_type = 'cd')
    {
        $auth = Zend_Auth::getInstance();
        
        $userObj = $auth->getStorage()->read();
    	
        $acl = new Application_Model_Acl();
        
		$redirector = new Zend_Controller_Action_Helper_Redirector();
		
    	// if not a valid user or not valid resource send back to login and set the refer path
        if (false == $userObj || !$acl->isAllowed(ROLE, $resource_type)) 
    	{
           $redirector->gotoSimple('index', 'cdlogin', '');                                  
    	}
		elseif ($userObj && $acl->isAllowed(ROLE, $resource_type)) 
    	{
    		if(ROLE == 'cd')
			{
				//$redirector->gotoSimple('index', 'index', 'cduser');  
			}
        }

        return $userObj;
    }
    
    public static function getRole($department) 
    {
    	return 'cd';
		/*
    	$model = new User_Model_Usertypes();
    	         
    	$result = $model->fetchAll('department = '.$department);
    	
    	return $result->getRole();
		*/
    }
    
}
