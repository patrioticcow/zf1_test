<?php
/*
 * this method does the logic for the points
 * this methods will be grouped by the tables needed to save the information into
 *
 * CURL
 * index 	- $ curl http://example.com/article
 * get 		- $ curl http://example.com/article/1
 * post 	- $ curl -d "article=myarticle" http://example.com/article/
 * put 		- $ curl -d "article=updatedarticle" -X PUT http://example.com/article/1
 * delete 	- curl -X DELETE http://example.com/article/1
 */
abstract class Application_Model_Points
{

	/**
	 * subscription types
	 */
	public static function subscriptionPoints()
	{
		$api = new Application_Model_Api();

		$result = $api->init(array('talentnum' => USERID));

		$response = array();

		if (count((array)$result->node)){

			foreach($result->node as $subscription)
			{
				if($subscription->term == 1){
					$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>10, 'points'=>150, 'status'=>1, 'last_updated'=>time());
				}
				if($subscription->term == 3){
					$response[1] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>11, 'points'=>300, 'status'=>1, 'last_updated'=>time());
				}
				if($subscription->term == 6){
					$response[2] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>12, 'points'=>600, 'status'=>1, 'last_updated'=>time());
				}
				if($subscription->term == 12){
					$response[3] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>13, 'points'=>1200, 'status'=>1, 'last_updated'=>time());
				}

			}

		}
        return $response;
	}


	/**
	 * last name, first anme, phone, zip.
	 */
	public static function talentciPoints($obj)
	{
		$response = array();

		if($obj->getLname() != null){
			$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>4, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}
		if($obj->getFname() != null){
			$response[1] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>8, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}
		if($obj->getDphone() != null){
			$response[2] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>7, 'points'=>20, 'status'=>1, 'last_updated'=>time());
		}
		if($obj->getZip() != null){
			$response[3] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>9, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}

		return $response;
	}

	/**
	 * sex, age
	 */
	public static function talentinfo1Points($obj)
	{
		$response = array();

		if($obj->getSex() != null){
			$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>3, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}
		if($obj->getDobmm() != null && $obj->getDobdd() != null && $obj->getDobyyyy() != null){
			$response[1] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>2, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}

		return $response;

	}

	/**
	 * ethnicity
	 */
	public static function talentinfo2Points($obj)
	{
		$response = array();

		if($obj->getEthnicity() != null){
			$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>1, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}

		return $response;
	}

	/**
	 * votes over 100
	 */
	public static function contestPoints($obj)
	{
		$response = array();

		foreach($obj as $val){
			if($val->getPoints() % 100 == 0){
				$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>21, 'points'=>20, 'status'=>1, 'last_updated'=>time());
			}
		}

		return $response;
	}

	/**
	 * every vote given or received
	 */
	public static function contestantPoints($obj)
	{
		$response = array();

		if($obj['talentnum'] != null && $obj['voted_talent'] != null){
				$response[0] = array('talentnum_aff'=>$obj['voted_talent'], 'talentnum_of'=>$obj['talentnum'], 'date_created'=>time(), 'type' =>22, 'points'=>2, 'status'=>1, 'last_updated'=>time());
				$response[1] = array('talentnum_aff'=>$obj['talentnum'], 'talentnum_of'=>$obj['voted_talent'], 'date_created'=>time(), 'type' =>21, 'points'=>2, 'status'=>1, 'last_updated'=>time());
		}

		return $response;
	}

	/**
	 * pictures
	 */
	public static function picturePoints($obj)
	{
		$response = array();

		if(isset($obj['primary'])){
				$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>5, 'points'=>20, 'status'=>1, 'last_updated'=>time());
		}
		if(isset($obj['secondary'])){
				$response[0] = array('talentnum_of'=>USERID, 'date_created'=>time(), 'type' =>6, 'points'=>10, 'status'=>1, 'last_updated'=>time());
		}

		return $response;
	}

}