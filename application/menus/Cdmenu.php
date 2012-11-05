<?php

class Application_Menu_Cdmenu
{

    public static function getSubMenu($type = 'visitor')
	{
		$action = '';
		if(isset($dataType)){
			foreach($dataType as $val)
			{
				$profile[] = $val->profile_type;
			}
				$action = $profile['0'];
		}

		$menu['talent'] = array(
		             array('id' => 'welcome',
		             		'class' => 'account-menu',
		                      'label' => 'My Profile',
		                      'uri' => '/talents/index'
		             ),
				     array('id' => 'update',
				     		'class' => 'account-menu',
						     'label' => 'Update Profile',
						     'uri' => '/talents/index/update'
				     )
		);

		$menu['cd'] = array(
				array('id' => 'welcome',
						'class' => 'account-menu',
						'label' => 'My Account',
						'uri' => '/cduser/account/myaccount'
				),
				array('id' => 'quick-post',
					    'class' => 'account-menu',
						'label' => 'Quick Post',
						'uri' => '/cduser/castings/quickpost'
				),
				array('id' => 'post-casting',
					    'class' => 'account-menu',
						'label' => 'Post New Casting',
						'uri' => '/cduser/account/postcasting'
				),
				array('id' => 'my-castings',
					    'class' => 'account-menu',
						'label' => Application_Model_Translate::t( 'My Castings' , 'top_menu' ),
						'uri' => '/cduser/castings'
				),
				array('id' => 'search-talent',
					    'class' => 'account-menu',
						'label' => Application_Model_Translate::t( 'Search Talent' , 'top_menu' ),
						'uri' => '/cduser/search'
				),
				array('id' => 'producers',
					    'class' => 'account-menu',
						'label' => 'Producers',
						'uri' => '/cduser/producers'
				),
				array('id' => 'cd-logout',
					    'class' => 'account-menu',
						'label' => 'Logout',
						'uri' => '/login/logout'
				),
				array('id' => 'cd-guide',
					    'class' => 'account-menu',
						'label' => 'Industry Guide',
						'uri' => '/assets/et_mediakit.pdf',
						'target' => '_blank',
				)
		);

		$menu['producer'] = array(
				array('id' => 'Dashboard',
						'class' => 'account-menu',
						'label' => 'Dashboard',
						'uri' => '/producers/dashboard'
				),
				array('id' => 'castings',
					    'class' => 'account-menu',
						'label' => 'Castings',
						'uri' => '/producers/castings'
				),

				array('id' => 'producer-logout',
					    'class' => 'account-menu',
						'label' => 'Logout',
						'uri' => SECURE_DOMAIN.'/login/logout'
				)
		);

		$menu['member'] = array(
				array('id' => 'welcome',
						'label' => 'My Account',
						'uri' => '/orders/account'
				)

		);

		$menu['talent_pro'] = array(
		             array('id' => 'welcome',
		                      'label' => 'Welcome Back '.USERNAME,
		                      'uri' => '/orders/'.$action
		             )

		);

		$menu['visitor'] = array(

		             array( 'id' => 'welcome',
		                      'label' => 'Welcome',
		                      'uri' => '/'
		             ),
		             array( 'id' => 'join',
				           'label' => 'Join For Free!',
				           'uri' => '/cduser/join'

		             ),
		             array( 'id' => 'login',
		                    'label' => Application_Model_Translate::t('CD Login'),
		                    'uri' => '/login/index/usertype/cd'
		             ),


		);

		$menu['developer'] = array(
		             array('id' => 'home',
		                      'label' => 'Home',
		                      'uri' => '/'
		             ),
		             array('id' => 'admin',
		                      'label' => 'Admin',
		                      'uri' => 'local.zend_et_admin/dashboard'
		             )
		);

		$menu['designer'] = array(
		             array('id' => 'home',
		                      'label' => 'Home',
		                      'uri' => '/'
		             ),
		             array('id' => 'admin',
		                      'label' => 'Admin',
		                      'uri' => 'local.zend_et_admin/dashboard'
		             )
		);

		$container = new Zend_Navigation(
		    $menu[$type]
		);

		return $container;
	}

    public static function getProfileMenu()
	{
		$profile = array();

		$tnum = new Profile_Model_Profiles();
		$tnum->useDependents(false);
		$container = new Zend_Navigation();

		$dataType = $tnum->fetchProfiles('talentnum = '.USERID, null, null);
		foreach($dataType as $val)
		{
			$profile[] = $val->profile_type;
		}

		if (in_array("acting", $profile)) {
	    	$container->addPage(array('id' => 'profile_acting',
		                   'class' => 'profile_acting',
		                   'label' => 'Acting/Modeling Profile',
		                   'uri' => '/profile/acting'
		    ));
		}
		if (in_array("modeling", $profile)) {
	    	$container->addPage(array('id' => 'profile_modeling',
		             	   'class' => 'profile_modeling',
		                   'label' => 'Modeling Profile',
		                   'uri' => '/profile/modeling'
		    ));
		}
		if (in_array("music", $profile)) {
	    	$container->addPage(array('id' => 'profile_musician',
		             	   'class' => 'profile_musician',
		                   'label' => 'Musician Profile',
		                   'uri' => '/profile/musician'
		    ));
		}
		if (in_array("social", $profile)) {
			$container->addPage(array('id' => 'profile_social',
		             	   'class' => 'profile_social',
		             	   'label' => 'Social Profile',
		                   'uri' => '/profile/social'
		    ));
		}
		if (in_array("crew", $profile)) {
			$container->addPage(array('id' => 'profile_crew',
		             	   'class' => 'profile_crew',
		             	   'label' => 'Crew Profile',
		                   'uri' => '/profile/crew'
		    ));
		}
		if (in_array("sports", $profile)) {
			$container->addPage(array('id' => 'profile_sports',
		             	   'class' => 'profile_sports',
		             	   'label' => 'Sports Profile',
		                   'uri' => '/profile/sports'
		    ));
		}

		return $container;
	}

	public static function getAccountMenu()
	{
		$container = new Zend_Navigation();

		$container->addPage(array('id' => 'new_subscription',
				'class' => 'sub_menu_item',
				'label' => 'Create a New Subscription',
				'uri' => '/orders'
		));

		$container->addPage(array('id' => 'account_info',
				'class' => 'sub_menu_item',
				'label' => 'My Account Info.',
				'uri' => '/orders/account/update'
		));

		$container->addPage(array('id' => 'cc_info',
				'class' => 'sub_menu_item',
				'label' => 'Update my Credit Cards',
				'uri' => '/orders/cc/update'
		));

		$container->addPage(array('id' => 'add_cc',
				'class' => 'sub_menu_item',
				'label' => 'Add New Credit Card',
				'uri' => '/orders/cc/add/update'
		));

		$container->addPage(array('id' => 'subscriptions',
				'class' => 'sub_menu_item',
				'label' => 'My Subscriptions',
				'uri' => '/orders/subscriptions/update'
		));

		return $container;
	}

    public static function getSitemapMenu()
	{
		$array = array(
		             array('id' => 'index',
		                   'class' => 'top_menu_item',
		                   'label' => 'Index Page',
		                   'uri' => '/index/index'
		             ),
		             array('id' => 'contests',
		                   'label' => 'Contests',
		                   'uri' => '/contests/index'
		             )
		);

		$container = new Zend_Navigation(
		    $array
		);

		return $container;
	}

}