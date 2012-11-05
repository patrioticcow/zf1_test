<?php

class Session_Model_Session extends Application_Model_Proxy
{
    protected static $_mapper = null;

    protected $_session_id = null;

    protected $_save_path = null;

    protected $_name = null;

    protected $_modified = null;

    protected $_lifetime = null;

    protected $_session_data = null;

    public function __construct()
    {
        static::$_mapper = new Session_Model_Mapper_Session();
        
        $this->initLogin();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();
        
            $data = $front->getRequest()->getParams();
        }
        
        $this->_session_id = !empty($data["session_id"]) ? $data["session_id"] : null;
        
        $this->_save_path = !empty($data["save_path"]) ? $data["save_path"] : null;
        
        $this->_name = !empty($data["name"]) ? $data["name"] : null;
        
        $this->_modified = !empty($data["modified"]) ? $data["modified"] : new Zend_Db_Expr("NOW()");
        
        $this->_modified = !empty($data["modified"]) ? $data["modified"] : null;
        
        $this->_lifetime = !empty($data["lifetime"]) ? $data["lifetime"] : null;
        
        $this->_session_data = !empty($data["session_data"]) ? $data["session_data"] : null;
        
        $id = static::$_mapper->save($this);
        
        return $id;
    }

    public function initLogin()
    {
        if($req = Zend_Controller_Front::getInstance()->getRequest())
        {
            if($si = $req->getParam('si') && $id =$req->getParam('id'))
            {
            	$auth = new Application_Model_Auth();
            	$auth->processSi($id, $si, $req->getParam('usertype'));
            }
            	$this->initConstants();
        }   
    }
    
    /* public function initSessionStorage()
    {
    	$config = array(
    		'name'              => 'session', //table name as per Zend_Db_Table
    		'primary'           => array(
    				'session_id',    //the sessionID given by PHP
    				'save_path',    //session.save_path
    				'name',         //session name
    		),
    		'primaryAssignment' => array(
    				'sessionId', //first column of the primary key is of the sessionID
    				'sessionSavePath', //second column of the primary key is the save path
    				'sessionName', //third column of the primary key is the session name
    		),
    		'modifiedColumn'    => 'modified',     //time the session should expire
    		'dataColumn'        => 'session_data', //serialized data
    		'lifetimeColumn'    => 'lifetime',     //end of life for a specific record
        );
    
        //Zend_Session::rememberMe(84600);
        //Tell Zend_Session to use your Save Handler
        Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($config));
        
        if($req = Zend_Controller_Front::getInstance()->getRequest())
        {
            if($req->getParam('si'))
                Zend_Session::setId($req->getParam('si'));
        }
        
        $this->initConstants();
    }   */
    
    public function initConstants()
    {
    	if(!defined('SITENAME'))
    		define('SITENAME', 'exploretalent.com');
    
    	$userObj = Zend_Auth::getInstance()->getStorage()->read();
    
        if(isset($userObj) && $userObj->role == 'talent')
        {
        	if(!defined('LOGGEDIN'))
            define('LOGGEDIN', TRUE);
        	
        	if(!defined('USERNAME'))
            define('USERNAME', $userObj->username);
        	
        	if(!defined('USERID'))
            define('USERID', $userObj->userid);
        	
        	if(!defined('ROLE'))
            define('ROLE', $userObj->role);

        	if(!defined('PRO'))
            define('PRO', $userObj->pro);
        	
        	if(!defined('FEATURED'))
            define('FEATURED', $userObj->featured);
        }
	    elseif(isset($userObj) && $userObj->role == 'cd')
        {
        	if(!defined('LOGGEDIN'))
        	define('LOGGEDIN', FALSE);
        	
        	if(!defined('CD_LOGGEDIN'))
        	define('CD_LOGGEDIN', TRUE);

        	if(!defined('USERNAME'))
        	define('USERNAME', $userObj->username);
        	
        	if(!defined('USERID'))
        	define('USERID', $userObj->userid);
        	
        	if(!defined('ROLE'))
        	define('ROLE', $userObj->role);

        	if(!defined('PRO'))
        	define('PRO', FALSE);
        	
        	if(!defined('FEATURED'))
        	define('FEATURED', FALSE);

        }
        elseif(isset($userObj) && $userObj->role == 'admin')
        {
        	if(!defined('LOGGEDIN'))
        	define('LOGGEDIN', FALSE);
        	
        	if(!defined('ADMIN_LOGGEDIN'))
        	define('ADMIN_LOGGEDIN', TRUE);

        	if(!defined('USERNAME'))
        	define('USERNAME', $userObj->username);
        	
        	if(!defined('USERID'))
        	define('USERID', $userObj->userid);
        	
        	if(!defined('ROLE'))
        	define('ROLE', $userObj->role);

        	if(!defined('PRO'))
        	define('PRO', FALSE);
        	
        	if(!defined('FEATURED'))
        	define('FEATURED', FALSE);
        }
	    else
	    {
	    	if(!defined('LOGGEDIN'))
		        define('LOGGEDIN', FALSE);

	    	if(!defined('USERNAME'))
	    	    define('USERNAME', 'Visitor');

	    	if(!defined('USERID'))
		        define('USERID', NULL);

	    	if(!defined('ROLE'))
		        define('ROLE', 'visitor');

	    	if(!defined('PRO'))
		        define('PRO', FALSE);

	    	if(!defined('FEATURED'))
		        define('FEATURED', FALSE);  
	    }
    }
}

