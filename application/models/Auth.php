<?php
/**
 * This is needed for multiple talentlogin names (which is stupid)
 * But checks 2 identity fields talentlogin and talentpass
 * @author Nick
 *
 */
class My_Auth_Adapter extends Zend_Auth_Adapter_DbTable
{
	protected $_columnName = 'pass';
	protected $_pass = false;

	public function setColumnName($name)
	{
		$this->_columnName = $name;
	}

	public function setPass($id)
	{
		$this->_pass = $id;
		return $this;
	}

	public function getPass()
	{
		return $this->_pass!==false ? $this->_pass : '';
	}

	public function _authenticateCreateSelect()
	{
		$select = parent::_authenticateCreateSelect();
		$select->where($this->_zendDb->quoteIdentifier($this->_columnName, true)." = ?", $this->getPass());
		return $select;
	}
}

class Application_Model_Auth
{
	public function processSi($id, $si, $usertype = 'talent')
	{
		$req = Zend_Controller_Front::getInstance()->getRequest();
		
		$usertype = (null != $req->getParam('usertype')) ? $req->getParam('usertype') : 'talent';
		
		 if($usertype == 'cd')
		 {
		 	$model = new Cduser_Model_Cduser();
		 	
		 	if($result = $model->fetchAll('user_id = '.$id))
		 	{
		 		$data['username'] = $result->getLogin();
		 		$data['password'] = $result->getPass();
		 	}
		 }	
		 else
		 {	 	
		 	$model = new Talents_Model_Talentci();
		 	
		 	if($result = $model->fetchAll('talentnum = '.$id))
		 	{
		 		$data['username'] = $result->getTalentlogin();
		 		$data['password'] = $result->getTalentpass();
		 	}	
		 }   
		 
		 if($this->process($data))
		 {
		    return TRUE;
		 }
		
	}
	
    public function process(array $values = null)
    {
    	if($values == null)
    	{
            $front = Zend_Controller_Front::getInstance();

            $values = $front->getRequest()->getParams();
    	}

		$user_type_table = array('cd', 'talent', 'user');
        //Zend_Debug::dump($values); exit;
    	foreach($user_type_table as $u)
		{
			$adapter[$u] = $this->_getAuthAdapter($u);

			if($u == 'talent')
			{
				$cname = 'talentpass';
			}
			elseif($u == 'user')
			{
				$cname = 'pass';
			}
			else
			{
				$cname = 'pass';
			}

			$adapter[$u]->setColumnName($cname);

            $adapter[$u]->setIdentity($values['username']);
            $adapter[$u]->setPass($values['password']);
            $adapter[$u]->setCredential($values['password']);

            $auth = Zend_Auth::getInstance();
            	
            $result [$u]= $auth->authenticate($adapter[$u]);
            
            //if authentication successful - else return false
            if ($result[$u]->isValid())
            {
        	    if($u == 'talent')
        	    {
                    $data = $adapter[$u]->getResultRowObject(array(
                        'talentlogin',
                        'talentpass',
                        'talentnum',
                    	'join_status'
                    ));

                    $data->username = $data->talentlogin;
                    $data->userid = $data->talentnum;
                    $data->role = 'talent';
                    $data->featured = $data->join_status > 5 ? TRUE : FALSE;
                    $data->pro = $data->join_status > 4 ? TRUE : FALSE;
                    $data->secret = md5(DOMAIN);
        	    }
        	    elseif($u == 'cd')
        	    {
        		    $data = $adapter[$u]->getResultRowObject(array(
        				'login',
        				'pass',
        				'user_id'
        		    ));

        		    $data->username = $data->login;
        		    $data->userid = $data->user_id;
        		    $data->role = 'cd';
        		    $data->featured = FALSE;
        		    $data->pro = FALSE;
        		    $data->secret = md5(DOMAIN);
        		    
        	    }
			    elseif($u == 'user')
        	    {
        		    $data = $adapter[$u]->getResultRowObject(array(
        				'username',
        				'pass',
        				'usernum',
        				'department',
        				'access'
        		    ));

				    //$data->username = $data->username;
        		    //$data->userid = $data->usernum;
					$data->roleAccess = $this->getDepartment($data->department, $data->access);
					$data->role = 'admin';
					$data->featured = FALSE;
					$data->pro = FALSE;
					$data->secret = md5(DOMAIN);
					$data->domain = DOMAIN;
        	    }

                $auth->getStorage()->write($data);
                
                //update bam.online_all
                //$onlineModel = new Etonline_Model_Etonline();
                //$onlineModel->addToOnlineAll($data->userid, 'online');

                return true;
            }
        }
        return false;
    }

    private function _getAuthAdapter($usertype = 'talent')
    {

        $authAdapter = new My_Auth_Adapter(Zend_Db_Table::getDefaultAdapter());

        if($usertype == 'talent')
        {
        	$authAdapter = new My_Auth_Adapter(Application_Model_ServiceLocator::getDb('db'));
            $authAdapter->setTableName('talentci')
                        ->setIdentityColumn(array('talentlogin'))
                        ->setCredentialColumn('talentpass');
                        //->setCredentialTreatment('SHA1(?)');
        }
        elseif($usertype == 'cd')
        {
        	$authAdapter = new My_Auth_Adapter(Application_Model_ServiceLocator::getDb('db'));
        	$authAdapter->setTableName('cd_user')
        	            ->setIdentityColumn(array('login'))
        	            ->setCredentialColumn('pass');
        	            //->setCredentialTreatment('SHA1(?)');
        }
        elseif($usertype == 'user')
        {
        	$authAdapter = new My_Auth_Adapter(Application_Model_ServiceLocator::getDb('db'));
        	$authAdapter->setTableName('user')
        	            ->setIdentityColumn(array('username'))
        	            ->setCredentialColumn('pass');
        	            //->setCredentialTreatment('MD5(?)');
        }

        return $authAdapter;
    }

    public static function authorize($resource_type = 'talent', $department = null)
    {
        $auth = Zend_Auth::getInstance();

        $userObj = $auth->getStorage()->read();

        $acl = new Application_Model_Acl();

    	// if not a valid user or not valid resource send back to login and set the refer path
        if (false == $userObj || !$acl->isAllowed(ROLE, $resource_type))
    	{
    		$redirector = new Zend_Controller_Action_Helper_Redirector();

    		if($resource_type == 'talent')
    		{
                $redirector->gotoSimple('index', 'login', '');
    		}
			elseif($resource_type == 'cs')
    		{
    			$redirector->gotoSimple('cs', 'login', '');
    		}
    		elseif($resource_type == 'cd')
    		{
    			$redirector->gotoUrl('cduser/join/index/');
    		}
            elseif($resource_type == 'admin')
    		{
    			$redirector->gotoSimple('admin', 'login', '');
    		}
    	}

    	return $userObj;
    }

	public static function getDepartment($department, $access)
    {
    	$model = new User_Model_Usertypes();

    	$result = $model->fetchAll('department = '.$department);

    	return $result->getRole();
    }

}
