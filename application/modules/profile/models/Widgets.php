<?php

class Profile_Model_Widgets extends Application_Model_Proxy
{

	public function getStaticProfilesUsers($profileType, $talentnum = null)
	{
		$where = 'a.profile_type_id & '.$profileType;
		if($talentnum != null){
			$where .= ' AND talent = '.$talentnum;
		}
        $where.= ' AND p.type = 2 ';
		$profile = new Profile_Model_Profiles();
		$result = $profile->fetchAll($where, 'talent DESC', 35);

		return Application_Model_Functions::toArray($result);
	}

	public function getAuditionsCount()
	{
		$casting = new Auditions_Model_Mapper_Castings();
		$getCasting = $casting->fetchCastingsRoles('castings.status = 1', null, null,  'castings.cat'); //and castings.asap > '.time().'

		$y = new Auditions_Model_CastingCategories();
		$data = $y->getCategoriesArray($getCasting);

		return array('data'=>$data, 'total'=>array_sum($getCasting));
	}

	public function create($data = null){}
}