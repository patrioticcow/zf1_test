<?php
class Profile_AjaxController extends Zend_Controller_Action {

	public function init()
	{
		$this->getHelper('viewRenderer')->setNoRender();
	}

	public function getmatchedtalentsAction()
	{
		$profileId = $this->getRequest()->getParam('profileid');

		$model = new Profile_Model_Widgets();
		$data = $model->getStaticProfilesUsers($profileId);

		foreach($data as $key=>$val)
		{
            $image = Media_Model_MediaAbstract::getSocialPic($val->getTalentnum(), 'media_social');

            $array[$key]['talentnum'] = $val->getTalentnum();
            $array[$key]['fname']     = $val->getTalentci()->getFname();
            $array[$key]['lname']     = $val->getTalentci()->getLname();
            $array[$key]['city']      = $val->getTalentci()->getCity();
            $array[$key]['state']     = $val->getTalentci()->getState();
			$array[$key]['image']     = $image;
		}
		echo Zend_Json_Encoder::encode($array);
		exit;
	}
}