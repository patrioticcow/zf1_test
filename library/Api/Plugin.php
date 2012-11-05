<?php
class Api_Plugin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$front = Zend_Controller_Front::getInstance();

		$model = new Session_Model_Session();

		if(!$front->getDispatcher()->isDispatchable($request))
		{
			// see if talent exists
			$name = $request->getControllerName();

			$model = new Talents_Model_Talentci();

			if($result = $model->fetchAll('talentlogin = "'.$name.'"'))
			{
				if(is_array($result))
				{
				    foreach($result as $val)
					{
						$array []= $val->getTalentnum();
						$talentnum = $array[0];
					}
				}
				else
				{
					$talentnum = $result->getTalentnum();
				}

				    $request->setModuleName('profile')
                             ->setControllerName('social')
                             ->setActionName('social-info')
                             ->setParam('id', $talentnum)
                             ->setParam('talentlogin', $name);


			}
			else
			{
				$request->setControllerName('error');
			}

		}
	}

    public function getTalentId()
    {
        //return static::$talentID;
    }

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    	// headers here
    	$this->displayHeaders();
    }

    public function displayHeaders()
    {
    	$response = $this->getResponse();
    	$response->setHeader('Pragma', 'public', true);
    	//$response->setHeader('Cache-control', 'max-age=3600', true);
    	//$response->setHeader('Last_Modified', gmdate('D, d M Y H:i:s', time()).' GMT', true);
    	$response->setHeader('If-Modified-Since', 'Sat, 29 Oct 1994 19:43:31 GMT');
    	$response->setHeader('ETag', md5(time()), true);
    	$response->setHeader('Pragma', '', true);
    }

}
