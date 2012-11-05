<?php
/**
 * @todo
 * url-change-view_resume.php
 *
 */
class Application_Menu_Factory
{

    public static function getSubMenu($type = 'visitor')
	{
		$userid =  Application_Model_Functions::userid();

		$front 	= Zend_Controller_Front::getInstance();
		$id 	= $front->getRequest()->getParam('id');
		$action = $front->getRequest()->getParam('controller');
		$module = $front->getRequest()->getParam('module');

		$container = new Zend_Navigation();

		if (($module != 'profile') || (($module == 'profile') && (LOGGEDIN)) ){
			$container->addPage(array(
					'id' => 'welcome',
					'label' 	=> 'My Profile',
			        'uri' 	=> '/profile/social/'.$userid,
			        'class'  => 'nav_link'
			));
		}

		if ( ($module == 'profile') && ($userid == $id) ){
			$container->addPage(array(
					'id' => 'welcome',
					'label' 		 => 'Edit Profile',
			        'class'  => 'nav_link',
			        'uri' => '/profile/'.$action.'/edit/'.$userid
			));
		}

		if ( ($action == 'acting') || ($action == 'modeling') || ($action == 'musician') || ($action == 'dance') || ($action == 'social') ){
			$container->addPage(array(
					'id' => 'welcome',
					'label' 		 => 'Edit Videos',
			        'class'  => 'nav_link',
			        'uri' => '/profile/'.$action.'/editvideo/id/'.$userid
			));
		}

		if ( ($action == 'acting') || ($action == 'musician') || ($action == 'social') ){
			$container->addPage(array(
					'id' => 'welcome',
					'label' 		 => 'Edit Audio',
			        'class'  => 'nav_link',
			        'uri' => '/profile/'.$action.'/editaudio/id/'.$userid
			));
		}

        // edit resume
            $container->addPage(array(
                    'id' => 'welcome',
                    'label' 		 => 'Edit Resume',
                    'class'  => 'nav_link',
                    'originalTitle'  => 'Edit Resume',
                    'uri' => '/resume/index/edit/id/'.USERID
            ));

		return $container;
	}

    public static function getProfileMenu($type = 'visitor')
	{
		$profile = array();

		$front = Zend_Controller_Front::getInstance();
    	$userid = $front->getRequest()->getParam('id');
    	$action = $front->getRequest()->getParams();

    	if (!$userid){
    		$userid = USERID;
    	}

		$tnum = new Profile_Model_Profiles();
		$tnum->useDependents(false);
		$container = new Zend_Navigation();

		$dataType = $tnum->fetchProfiles('talentnum = '.$userid, null, null);
		foreach($dataType as $val)
		{
			$profile[] = $val->profile_type;
		}

		$acting 	= $action['controller'] == 'acting' 	? 'active_menu' : '';
		$musician 	= $action['controller'] == 'musician' 	? 'active_menu' : '';
		$dance 		= $action['controller'] == 'dance' 		? 'active_menu' : '';

		if (in_array("acting", $profile)) {
	    	$container->addPage(array('id' => 'profile_acting',
		                   'class'  => 'profile_icon profile_acting '.$acting,
		                   'label' 	=> 'Acting & Modeling',
		                   'uri'    => '/profile/acting/'.$userid,
                           'htmlfyLiId' => 'profile_acting_li',
                           'htmlfyUlId' => 'profile_acting_ul',
                           'htmlfyUlClass' => $acting,
		    ));
		}

		if (in_array("music", $profile)) {
	    	$container->addPage(array('id' => 'profile_musician',
		             	   'class'  => 'profile_icon profile_musician '.$musician,
		                   'label' 	=> 'Musician',
		                   'uri'    => '/profile/musician/'.$userid,
                           'htmlfyLiId' => 'profile_musician_li',
                           'htmlfyUlId' => 'profile_musician_ul',
                           'htmlfyUlClass' => $musician,
		    ));
		}

		if (in_array("dance", $profile)) {
			$container->addPage(array('id' => 'profile_dance',
		             	   'class'  => 'profile_icon profile_dance '.$dance,
		             	   'label'  => 'Dance',
		                   'uri'    => '/profile/dance/'.$userid,
                           'htmlfyLiId' => 'profile_dance_li',
                           'htmlfyUlId' => 'profile_dance_ul',
                           'htmlfyUlClass' => $dance,
		    ));
		}

		// get dynamic profiles
		$modelProfile = new Profiles_Model_Profile();
		$modelProfile->useDependents('menu');
		$fetchAllProfile = $modelProfile->fetchAll('talentnum = '.$userid.' AND profile_level_id = 1', null, null);

		if($fetchAllProfile != null){
			// add index 0 if no array present
			$fetchAllProfile = Application_Model_Functions::toArray($fetchAllProfile);
            $i=0;
			foreach ($fetchAllProfile as $val){
				$dynamicCatO  = $val->getProfilecategories()->getProfileCategory();
                $dynamicCat = str_replace(' ', '%20', $dynamicCatO);
				$profileCat  = $val->getProfileCategoryId();

				// set menu active
				$dynamicCatActive = '';
				if(isset($action['type'])){
					$dynamicCatActive  = ($action['type'] == $dynamicCat.'-'.$profileCat) ? 'active_menu' : '';
				}

				$container->addPage(array('id' => 'profile_dance',
						'class' => 'profile_icon profile_dance '.$dynamicCatActive,
						'label' 		 => ucwords($dynamicCatO),
						'uri' => '/profiles/dynamic/index/type/'.$dynamicCat.'-'.$profileCat.'/id/'.$userid,
                        'htmlfyLiId' => 'profile_dynamic_li'.$i,
                        'htmlfyUlId' => 'profile_dynamic_ul'.$i,
						'htmlfyUlClass' => $dynamicCatActive,
				));
                $i++;
			}
		}
		//end get dynamic profiles

        $view = Zend_Layout::getMvcInstance()->getView();

		$menu = self::htmlify($container, 'navigation', 'edit_profiles');

        $view->menu = $menu;
        return $menu;
        //return $container;

	}

    public static function getSitemapMenu()
	{
		$array = array(
		             array('id' 	=> 'index',
		                   'class' 	=> 'top_menu_item',
		                   'label' 	=> 'Index Page',
		                   'uri' 	=> '/index/index'
		             ),
		             array('id' 	=> 'contests',
		                   'label' 	=> 'Contests',
		                   'uri' 	=> '/contests/index'
		             )
		);

		$container = new Zend_Navigation(
		    $array
		);

		return $container;
	}

    public static function htmlify($container, $menu_name = null, $span = null)
    {
        $menu = '<ul id="'.$menu_name.'" >';
        foreach($container as $page)
        {
            $menu .= '<li id="'.$page->htmlfyLiId.'">';
                $menu .= '<a href="'.$page->uri.'">';
                    $menu .= '<div class="'.$page->class.'">'.$page->label.'</div>';
                $menu .= '</a>';
            $menu .= '</li>';

        }
		$menu .= '</ul>';
    return $menu;
    }

}