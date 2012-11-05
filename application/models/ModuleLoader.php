<?php
class Application_Model_ModuleLoader
{
    private static $module = [];

    public static function load($name)
    {
    	if(is_array($name))
    	{
    		foreach($name as $val)
    		{
    			if(!static::isRegistered($val))
    			{
    				static::loadModule($val);
    			}
    		}
    	}
    	else
    	{
    		if(!static::isRegistered($name))
    		{
    			static::loadModule($name);
    		}
    	}
    }

    public static function checkModules($name = null)
    {
    	if($name == '') return FALSE;

    	if(is_dir(APPLICATION_PATH. '/modules/'.$name))
    	{
    		$func = '_initModule'.ucfirst($name);
    		if(is_callable(['Application_Model_ModuleLoader', $func]))
    		{
    		    return TRUE;
    		}
    	}
    	return FALSE;
    }

    protected static function loadModule($name)
    {
    	switch($name)
    	{
    		case 'profiles':
    			static::$module [$name] = 1;
    			static::_initModuleProfiles();
    		break;
    		case 'community_buzz':
    			static::$module [$name] = 1;
    			static::_initModuleCommunitybuzz();
    		break;
    		case 'activityfeed':
    			static::$module [$name] = 1;
    			static::_initModuleActivityfeed();
    		break;
    		case 'articles':
    			static::$module [$name] = 1;
    			static::_initModuleArticles();
    		break;
    		case 'bugs':
    			static::$module [$name] = 1;
    			static::_initModuleBugs();
    		break;
    		case 'notifications':
    			static::$module [$name] = 1;
    			static::_initModuleNotifications();
    		break;
    		case 'friendsnotification':
    			static::$module [$name] = 1;
    			static::_initModuleFriendsnotification();
    		break;
    		case 'wallmessages':
    			static::$module [$name] = 1;
    			static::_initModuleWallmessages();
    		break;
    		case 'wallcomments':
    			static::$module [$name] = 1;
    			static::_initModuleWallcomments();
    		break;
    		case 'messaging':
    			static::$module [$name] = 1;
    			static::_initModuleMessaging();
    		break;
    		case 'castings':
    			static::$module [$name] = 1;
    			static::_initModuleCastings();
    		break;
    		case 'calllog':
    			static::$module [$name] = 1;
    			static::_initModuleCalllog();
    		break;
            case 'cduser':
    			static::$module [$name] = 1;
    			static::_initModuleCduser();
    		break;
    		case 'producers':
    			static::$module [$name] = 1;
    			static::_initModuleProducers();
    		break;
    		case 'friends':
    			static::$module [$name] = 1;
    			static::_initModuleFriends();
    		break;
    		case 'fans':
    			static::$module [$name] = 1;
    			static::_initModuleFans();
    		break;
    		case 'testimonials':
    			static::$module [$name] = 1;
    			static::_initModuleTestimonials();
    		break;
    		case 'contestchat':
    			static::$module [$name] = 1;
    			static::_initModuleContestchat();
    		break;
    		case 'contests':
    			static::$module [$name] = 1;
    			static::_initModuleContests();
    		break;
    		case 'chat':
    			static::$module [$name] = 1;
    			static::_initModuleChat();
    		break;
    		case 'contestant':
    			static::$module [$name] = 1;
    			static::_initModuleContestant();
    		break;
    		case 'contestant_media':
    			static::$module [$name] = 1;
    			static::_initModuleContestantmedia();
    		break;
    		case 'roles':
    			static::$module [$name] = 1;
    			static::_initModuleRoles();
    		break;
    		case 'talents':
    			static::$module [$name] = 1;
    			static::_initModuleTalents();
    		break;
    		case 'online':
    			static::$module [$name] = 1;
    			static::_initModuleOnline();
    		break;
    		case 'zips':
    			static::$module [$name] = 1;
    			static::_initModuleZips();
    	    break;
    		case 'auditions':
    			static::$module [$name] = 1;
    			static::_initModuleAuditions();
    		break;
    		case 'profile':
    			static::$module [$name] = 1;
    			static::_initModuleProfile();
    		break;
    		case 'resume':
    			static::$module [$name] = 1;
    			static::_initModuleResume();
    		break;
		    case 'resumeprofile':
    			static::$module [$name] = 1;
    			static::_initModuleResumeprofile();
    		break;
    		case 'resources':
    			static::$module [$name] = 1;
    			static::_initModuleResources();
    		break;
    		case 'director':
    			static::$module [$name] = 1;
    			static::_initModuleDirector();
    		break;
    		case 'media':
    			static::$module [$name] = 1;
    			static::_initModuleMedia();
    		break;
    		case 'meters':
    			static::$module [$name] = 1;
    			static::_initModuleMeters();
    		break;
    		case 'join':
    			static::$module [$name] = 1;
    			static::_initModuleJoin();
    		break;
    		case 'store':
    			static::$module [$name] = 1;
    			static::_initModuleStore();
    		break;
    		case 'points':
    			static::$module [$name] = 1;
    			static::_initModulePoints();
    		break;
    		case 'requests':
    			static::$module [$name] = 1;
    			static::_initModuleRequests();
    		break;
    		case 'talentbcards':
    			static::$module [$name] = 1;
    			static::_initModuleTalentbcards();
    		break;
            case 'emailverification':
    			static::$module [$name] = 1;
    			static::_initModuleEmailverification();
    		break;
    		case 'talentrating':
    			static::$module [$name] = 1;
    			static::_initModuleTalentrating();
    		break;
			case 'tracker':
    			static::$module [$name] = 1;
    			static::_initModuleTracker();
    		break;
    		case 'generator':
    			static::$module [$name] = 1;
    			static::_initModuleGenerator();
    		break;
    		default:
    			throw new Exception($name . ' Module Does Not Exist!');
    		break;
    	}
    }

    public static function isRegistered($module_name)
    {
    	if($module_name)
    	{
    	    if(array_key_exists($module_name, static::$module))
    	    {
    		    return TRUE;
    	    }
    	}
	    return FALSE;
    }

    protected static function _initModuleTracker()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Tracker',
    			'basePath'  => APPLICATION_PATH . '/modules/tracker',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

	protected static function _initModuleGenerator()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Generator',
    			'basePath'  => APPLICATION_PATH . '/modules/generator',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleProfiles()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Profiles',
    			'basePath'  => APPLICATION_PATH . '/modules/profiles',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
                ->addResourceType('menu', 'menus', 'Menu')
                ->addResourceType('model', 'models', 'Model')
                ->addResourceType('partial', 'partials', 'Partial')
                ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
                ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleCalllog()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Calllog',
    			'basePath'  => APPLICATION_PATH . '/modules/calllog',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleChat()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Chat',
    			'basePath'  => APPLICATION_PATH . '/modules/chat',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleEmailverification()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Emailverification',
    			'basePath'  => APPLICATION_PATH . '/modules/emailverification',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
                ->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleArticles()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Articles',
    			'basePath'  => APPLICATION_PATH . '/modules/articles',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('partial', 'partials', 'Partial')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleStore()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Store',
    			'basePath'  => APPLICATION_PATH . '/modules/store',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModulePoints()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Points',
    			'basePath'  => APPLICATION_PATH . '/modules/points',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }
    protected static function _initModuleRequests()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Requests',
    			'basePath'  => APPLICATION_PATH . '/modules/requests',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleBugs()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Bugs',
    			'basePath'  => APPLICATION_PATH . '/modules/bugs',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleMeters()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Meters',
    			'basePath'  => APPLICATION_PATH . '/modules/meters',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
                ->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleTalentrating()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Talentrating',
    			'basePath'  => APPLICATION_PATH . '/modules/talentrating',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
                ->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleTalentbcards()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

	    $router->addRoute(
    			'talentbcards',
    			new Zend_Controller_Router_Route(
    					'talentbcards/:id',
    					array(
    							'module' => 'talentbcards',
    							'controller' => 'index',
    							'action' => 'index'
    					)
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Talentbcards',
    			'basePath'  => APPLICATION_PATH . '/modules/talentbcards',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
                ->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleWallmessages()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Wallmessages',
    			'basePath'  => APPLICATION_PATH . '/modules/wallmessages',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleWallcomments()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Wallcomments',
    			'basePath'  => APPLICATION_PATH . '/modules/wallcomments',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleJoin()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Join',
    			'basePath'  => APPLICATION_PATH . '/modules/join',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('flash', 'flash', 'Flash')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleCduser()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

        $router->addRoute(
    			'cduser',
    			new Zend_Controller_Router_Route(
    					'cduser/',
    					array(
    							'module' => 'cduser',
    							'controller' => 'castings',
    							'action' => 'index'
    					)
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Cduser',
    			'basePath'  => APPLICATION_PATH . '/modules/cduser',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleProducers()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Producers',
    			'basePath'  => APPLICATION_PATH . '/modules/producers',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('widget', 'widgets', 'Widget')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleCastings()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'castings',
    			new Zend_Controller_Router_Route(
    					'castings/:casting',
    					array(
    							'module' => 'castings',
    							'controller' => 'index',
    							'action' => 'index'
    					)
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Castings',
    			'basePath'  => APPLICATION_PATH . '/modules/castings',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleOnline()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Online',
    			'basePath'  => APPLICATION_PATH . '/modules/online',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleZips()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Zips',
    			'basePath'  => APPLICATION_PATH . '/modules/zips',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleFriendsnotification()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Friendsnotification',
    			'basePath'  => APPLICATION_PATH . '/modules/friendsnotification',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleCommunitybuzz()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Communitybuzz',
    			'basePath'  => APPLICATION_PATH . '/modules/communitybuzz',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('widget', 'widgets', 'Widget')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleResume()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addRoute(
            'resumeView',
            new Zend_Controller_Router_Route(
                'resume/view/:id',
                array(
                    'module' => 'resume',
                    'controller' => 'index',
                    'action' => 'index'
                )
            )
        );

        $loader = new Zend_Application_Module_Autoloader(array(
		    'namespace' => 'Resume',
		    'basePath'  => APPLICATION_PATH . '/modules/resume',
	    ));

	    $loader->addResourceType('form', 'forms', 'Form')
		    ->addResourceType('menu', 'menus', 'Menu')
		    ->addResourceType('model', 'models', 'Model')
		    ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
		    ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

	protected static function _initModuleResumeprofile()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'resumeprofileView',
    			new Zend_Controller_Router_Route(
    					'resumeprofile/view/:id',
    					array(
    							'module' => 'resumeprofile',
    							'controller' => 'index',
    							'action' => 'index'
    					)
    			)
    	);

        $loader = new Zend_Application_Module_Autoloader(array(
	        'namespace' => 'Resumeprofile',
	        'basePath'  => APPLICATION_PATH . '/modules/resumeprofile',
        ));

        $loader->addResourceType('form', 'forms', 'Form')
               ->addResourceType('menu', 'menus', 'Menu')
	           ->addResourceType('model', 'models', 'Model')
	           ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
	           ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    }


    protected static function _initModuleTalents()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'talents',
    			new Zend_Controller_Router_Route(
    					'talents/browse/:firstpage/:secondpage',
    					array(
    							'module' => 'talents',
    							'controller' => 'browse',
    							'action' => 'index'
    					)
    			)
    	);

        $loader = new Zend_Application_Module_Autoloader(array(
	        'namespace' => 'Talents',
	        'basePath'  => APPLICATION_PATH . '/modules/talents',
        ));

        $loader->addResourceType('form', 'forms', 'Form')
               ->addResourceType('menu', 'menus', 'Menu')
	           ->addResourceType('model', 'models', 'Model')
	           ->addResourceType('partial', 'partials', 'Partial')
	           ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
	           ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    }

    protected static function _initModuleAuditions()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

        $router->addRoute(
                'auditions',
                new Zend_Controller_Router_Route(
                        'auditions/:auditionurl',
                        array(
                                'module' => 'auditions',
                                'controller' => 'index',
                                'action' => 'index'
                        ),
                        array(
                                'auditionurl' => '\S*(\d{2}||\d{3})'
                        )
                )
        );

        $router->addRoute(
                'auditionscreate',
                new Zend_Controller_Router_Route(
                        'auditions/create',
                        array(
                                'module' => 'auditions',
                                'controller' => 'index',
                                'action' => 'create'
                        )
                )
        );

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Auditions',
    			'basePath'  => APPLICATION_PATH . '/modules/auditions',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('partial', 'partials', 'Partial')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    	Zend_Paginator::setDefaultScrollingStyle('Sliding');
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial(
    			'/pagination/my_pagination_control.phtml'
    	);

    }

    protected static function _initModuleActivityfeed()
    {

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Activityfeed',
    			'basePath'  => APPLICATION_PATH . '/modules/activityfeed',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
               ->addResourceType('widget', 'widgets', 'Widget')
    	       ->addResourceType('model', 'models', 'Model')
    	       ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	       ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    	Zend_Paginator::setDefaultScrollingStyle('Sliding');
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial(
    			'/pagination/my_pagination_control.phtml'
    	);

    }

    protected static function _initModuleNotifications()
    {

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Notifications',
    			'basePath'  => APPLICATION_PATH . '/modules/notifications',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
               ->addResourceType('widget', 'widgets', 'Widget')
    	       ->addResourceType('model', 'models', 'Model')
    	       ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	       ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    	Zend_Paginator::setDefaultScrollingStyle('Sliding');
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial(
    			'/pagination/my_pagination_control.phtml'
    	);

    }


    protected static function _initModuleRoles()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'roles',
    			new Zend_Controller_Router_Route(
    					'roles/:auditionurl',
    					array(
    							'module' => 'roles',
    							'controller' => 'index',
    							'action' => 'index'
    					),
    					array(
    							'auditionurl' => '\S*(\d{2}||\d{3})'
    					)
    			)
    	);
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Roles',
    			'basePath'  => APPLICATION_PATH . '/modules/roles',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');

    	Zend_Paginator::setDefaultScrollingStyle('Sliding');
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial(
    			'/pagination/my_pagination_control.phtml'
    	);
    }

    protected static function _initModuleContests()
    {

    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'contestsUrl',
    			new Zend_Controller_Router_Route(
    					'contests/:contesturl',
    					array(
    							'module' => 'contests',
    							'controller' => 'index',
    							'action' => 'contest'
    					)
    			)
    	);

    	$router->addRoute(
    			'contestsUrlJoin',
    			new Zend_Controller_Router_Route(
    					'contests/join/:contest/:name',
                        array(
                                'module' => 'contests',
                                'controller' => 'join',
                                'action' => 'index'
                        )
    			)
    	);

    	$router->addRoute(
    			'contestsUrlSave',
    			new Zend_Controller_Router_Route(
    					'contests/join/savemedia/:contest',
                        array(
                                'module' => 'contests',
                                'controller' => 'join',
                                'action' => 'savemedia'
                        )
    			)
    	);

    	$router->addRoute(
    			'contestsPast',
    			new Zend_Controller_Router_Route(
    					'contests/past/',
                        array(
                                'module' => 'contests',
                                'controller' => 'index',
                                'action' => 'past'
                        )
    			)
    	);

    	$router->addRoute(
    			'contestsUpcoming',
    			new Zend_Controller_Router_Route(
    					'contests/upcoming',
                        array(
                                'module' => 'contests',
                                'controller' => 'index',
                                'action' => 'upcoming'
                        )
    			)
    	);

    	$router->addRoute(
    			'contestsWinner',
    			new Zend_Controller_Router_Route(
    					'contests/winners/:contestid',
                        array(
                                'module' => 'contests',
                                'controller' => 'index',
                                'action' => 'winners'
                        )
    			)
    	);

    	$router->addRoute(
    			'contestsUpcoming',
    			new Zend_Controller_Router_Route(
    					'contests/about',
                        array(
                                'module' => 'contests',
                                'controller' => 'index',
                                'action' => 'about'
                        )
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Contests',
    			'basePath'  => APPLICATION_PATH . '/modules/contests',
    	));
    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('partial', 'partials', 'Partial')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('contests', 'models/DbTable/contests', 'Model_DbTable_Contests')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleContestchat()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Contestchat',
    			'basePath'  => APPLICATION_PATH . '/modules/contestchat',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('menu', 'menus', 'Menu')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleContestantmedia()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $router->addRoute(
                'contestantUrlDelete',
                new Zend_Controller_Router_Route(
                        'contestantmedia/index/delete/:id',
                        array(
                                'module' => 'contestantmedia',
                                'controller' => 'index',
                                'action' => 'delete'
                        )
                )
        );

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Contestantmedia',
    			'basePath'  => APPLICATION_PATH . '/modules/contestantmedia',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('menu', 'menus', 'Menu')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleContestant()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();


        $router->addRoute(
                'contestantUrl',
                new Zend_Controller_Router_Route(
                        'contestant/:contest/:name',
                        array(
                                'module' => 'contestant',
                                'controller' => 'index',
                                'action' => 'index'
                        )
                )
        );

        $router->addRoute(
                'contestantCompliments',
                new Zend_Controller_Router_Route(
                        'contestant/index/compliments',
                        array(
                                'module' => 'contestant',
                                'controller' => 'index',
                                'action' => 'compliments'
                        )
                )
        );
        $router->addRoute(
                'contestantVote',
                new Zend_Controller_Router_Route(
                        'contestant/index/contestvote',
                        array(
                                'module' => 'contestant',
                                'controller' => 'index',
                                'action' => 'contestvote'
                        )
                )
        );




    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Contestant',
    			'basePath'  => APPLICATION_PATH . '/modules/contestant',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('menu', 'menus', 'Menu')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleTestimonials()
    {
	    $front = Zend_Controller_Front::getInstance();
	    $router = $front->getRouter();

	    $router->addRoute('testimonials-winners',
		    new Zend_Controller_Router_Route(
			    '/testimonials-winners',
			    array(
				    'module' => 'testimonials',
				    'controller' => 'index',
				    'action' => 'testimonials-winners'

			    )
		    )
	    );
	    $router->addRoute('testimonials-prize',
		    new Zend_Controller_Router_Route(
			    '/top-prize-winners',
			    array(
				    'module' => 'testimonials',
				    'controller' => 'index',
				    'action' => 'top-prize-winners'

			    )
		    )
	    );

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Testimonials',
    			'basePath'  => APPLICATION_PATH . '/modules/testimonials',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('menu', 'menus', 'Menu')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleMessaging()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Messaging',
    			'basePath'  => APPLICATION_PATH . '/modules/messaging',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleFriends()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Friends',
    			'basePath'  => APPLICATION_PATH . '/modules/friends',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleFans()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Fans',
    			'basePath'  => APPLICATION_PATH . '/modules/fans',
    	));

    	$loader->addResourceType('form', 'forms', 'Form')
            	->addResourceType('model', 'models', 'Model')
            	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleProfile()
    {
    	$front = Zend_Controller_Front::getInstance();

        //$api = new Api_Plugin();
        //var_dump($api->getTalentId());

    	$router = $front->getRouter();



    	// used to get userid
    	$router->addRoute('getUserid',
    			new Zend_Controller_Router_Route(
    					'/profile/talent/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'index'

    					)
    			)
    	);

    	$router->addRoute('Profile_social_id',
    			new Zend_Controller_Router_Route(
    					'/profile/social/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'index'
    					)
    			)
    	);

        $router->addRoute('Profile_links_id',
            new Zend_Controller_Router_Route(
                '/profile/links/:id',
                array(
                    'module' => 'profile',
                    'controller' => 'links',
                    'action' => 'index'
                )
            )
        );

    	$router->addRoute('Profile_acting_id',
    			new Zend_Controller_Router_Route(
    					'/profile/acting/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'acting',
    							'action' => 'index'
    					)
    			)
    	);

        /*end subpages*/
    	$router->addRoute('Profile_modeling_id',
    			new Zend_Controller_Router_Route(
    					'/profile/modeling/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'modeling',
    							'action' => 'index'
    					)
    			)
    	);
    	$router->addRoute('Profile_musician_id',
    			new Zend_Controller_Router_Route(
    					'/profile/musician/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'musician',
    							'action' => 'index'
    					)
    			)
    	);
    	$router->addRoute('Profile_dance_id',
    			new Zend_Controller_Router_Route(
    					'/profile/dance/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'dance',
    							'action' => 'index'
    					)
    			)
    	);

        //partial related
    	$router->addRoute('Profile_audio_id',
    			new Zend_Controller_Router_Route(
    					'/profile/audio/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'audio'
    					)
    			)
    	);
    	$router->addRoute('Profile_video_id',
    			new Zend_Controller_Router_Route(
    					'/profile/video/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'video'
    					)
    			)
    	);
    	$router->addRoute('Profile_photos_id',
    			new Zend_Controller_Router_Route(
    					'/profile/photos/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'photos'
    					)
    			)
    	);
    	$router->addRoute('Profile_myactivity_id',
    			new Zend_Controller_Router_Route(
    					'/profile/myactivity/:id',
    					array(
    							'module' => 'profile',
    							'controller' => 'social',
    							'action' => 'myactivity'
    					)
    			)
    	);


        /*profile views*/

        $router->addRoute('Profile_viewed',
                new Zend_Controller_Router_Route(
                        '/profile/viewed/:id',
                        array(
                                'module' => 'profile',
                                'controller' => 'index',
                                'action' => 'viewed'
                        )
                )
        );
        $router->addRoute('Profile_views',
                new Zend_Controller_Router_Route(
                        '/profile/views/:id',
                        array(
                                'module' => 'profile',
                                'controller' => 'index',
                                'action' => 'views'
                        )
                )
        );

        /* end profile views*/

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Profile',
    			'basePath'  => APPLICATION_PATH . '/modules/profile',
    	));
    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleDirector()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();
    	$router->addRoute(
    			'Director',
    			new Zend_Controller_Router_Route(
    					'/director/:user_login',
    					array(
    							'module' => 'director',
    							'controller' => 'index',
    							'action' => 'index'
    					)
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Director',
    			'basePath'  => APPLICATION_PATH . '/modules/director',
    	));
    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleResources()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();
    	$router->addRoute(
    			'Director',
    			new Zend_Controller_Router_Route(
    					'/resources/:user_login',
    					array(
    							'module' => 'resources',
    							'controller' => 'index',
    							'action' => 'index'
    					)
    			)
    	);

    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Resources',
    			'basePath'  => APPLICATION_PATH . '/modules/resources',
    	));
    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected static function _initModuleMedia()
    {
    	$loader = new Zend_Application_Module_Autoloader(array(
    			'namespace' => 'Media',
    			'basePath'  => APPLICATION_PATH . '/modules/media',
    	));

    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();

    	$router->addRoute(
    			'remove',
    			new Zend_Controller_Router_Route(
    					'media/remove/:toaction/:from/:talentnum/:videoid',
    					array(
    							'module' => 'media',
    							'controller' => 'index',
    							'action' => 'remove'
    					)
    			)
    	);

    	$router->addRoute(
    			'search_video',
    			new Zend_Controller_Router_Route(
    					'media/video/search/:id',
    					array(
    							'module' => 'media',
    							'controller' => 'video',
    							'action' => 'search'
    					)
    			)
    	);

    	$router->addRoute(
    			'testimonials',
    			new Zend_Controller_Router_Route(
    					'media/video/testimonials/:id',
    					array(
    							'module' => 'media',
    							'controller' => 'video',
    							'action' => 'testimonials'
    					)
    			)
    	);

    	$loader->addResourceType('form', 'forms', 'Form')
    	->addResourceType('menu', 'menus', 'Menu')
    	->addResourceType('model', 'models', 'Model')
    	->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
    	->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }
    
    
}
