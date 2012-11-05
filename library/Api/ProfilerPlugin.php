<?php
class Api_ProfilerPlugin extends Zend_Controller_Plugin_Abstract
{
	protected static $dbTypes = array();

	protected static $profilers = array();

	protected static $out = array();

	public static $benchmark_start;

	public static $benchmark_finish;

    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->setProfilers();

        foreach(self::$profilers as $key=>$profiler)
        {
        	$this->printer($profiler, $dbType = $key);
        }

	    $layout = new Zend_Layout();

		$view = $layout->getView();

		foreach(self::$out as $key=>$out)
		{
            $view->footer_content .= '<h2>'.self::$dbTypes[$key].' Zend_Db_Profiler</h2><br />'.$out;
		}
    }

    protected function setProfilers()
    {
    	$dbConn = array();

    	$dbConn ['innoDb-115']= Application_Model_ServiceLocator::getDb('db');
    	$dbConn ['db-19']     = Application_Model_ServiceLocator::getDb('db19');
    	$dbConn ['db_write']  = Application_Model_ServiceLocator::getDb('db_write');

    	foreach($dbConn as $key=>$db)
    	{
    		//Zend_Debug::dump($db); exit;
    	    self::$dbTypes [$key]= $key;
    	    self::$profilers [$key] = $db->getProfiler();
    	}
    }

    private function printer($profiler, $dbType = null)
    {
    	$combinedTime = 0; $queryCount = 0;

    	$totalTime    = $profiler->getTotalElapsedSecs();
        $combinedTime += $totalTime;
        $queryCount   += $profiler->getTotalNumQueries();

        $longestQuery = null;

        if(null ==($profiler->getQueryProfiles())) return;

		$query = $profiler->getQueryProfiles();

		$out = '';

		foreach($query as $q)
		{
			$out .= $q->getQuery();
			$out .= '<br />';
		    $out .= $q->getElapsedSecs();
			$out .= '<hr />';
		}

		$out .= '<br />'.$queryCount.' queries combined time: '.$combinedTime;

		self::$out [$dbType]= $out;
    }
}
