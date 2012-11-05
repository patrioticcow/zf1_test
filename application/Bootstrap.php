<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    //not used
    protected function _initCookies()
    {
        //session_set_cookie_params(time()+14440, '/tmp', '.exploretalent.com', TRUE);
        /* $authNamespace = Zend_Session::setOptions(array(
                'cookie_domain' => '.exploretalent.com',
                'cookie_httponly' => TRUE,
                'name' => 'Zend_Auth',
        )); */

        //var_dump(Zend_Auth::getInstance());
        //echo 'test';
    }

    protected function _initAuthDbAdapter()
    {
        $db = Application_Model_ServiceLocator::getDb('db');
    }

    protected function _initSession()
    {
        $loader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Session',
            'basePath'  => APPLICATION_PATH . '/modules/session',
        ));

        $loader->addResourceType('form', 'forms', 'Form')
            ->addResourceType('model', 'models', 'Model')
            ->addResourceType('mappers', 'models/mappers', 'Model_Mapper')
            ->addResourceType('dbtable', 'models/DbTable', 'Model_DbTable');
    }

    protected function _initPlugin()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Api_Plugin());
        $front->registerPlugin(new Api_ProfilerPlugin());
    }

    protected function _initDomains()
    {
        if(!defined('DOMAIN'))
        {
            if(isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '127.0.0.1')
            {
                if(isset($_SERVER['HTTP_REFERER']))
                {
                    if(stristr($_SERVER['HTTP_REFERER'], 'nick'))
                        define('DOMAIN', 'http://nick.exploretalent.com'); // localhost
                    else
                        define('DOMAIN', 'http://cristi.exploretalent.com'); // localhost
                }
            }
            else
            {
                define('DOMAIN', 'http://dev-lv.exploretalent.com/');
            }
        }
        if(!defined('SECURE_DOMAIN'))
        {
            if(isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '127.0.0.1')
            {
                define('SECURE_DOMAIN', 'http://local.secure.exploretalent.com'); // localhost
            }
            else
            {
                define('SECURE_DOMAIN', 'http://secure.exploretalent.com');
            }
        }
        if(!defined('STAFF_DOMAIN'))
        {
            if(isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '127.0.0.1')
            {
                define('STAFF_DOMAIN', 'http://talent.exploretalent.com'); // localhost
            }
            else
            {
                define('STAFF_DOMAIN', 'http://talent.exploretalent.com');
            }
        }
        if(!defined('CDN_IMAGES')) //10.90.36.159
        {
            //define('CDN_IMAGES', 'http://images.exploretalent.com');
            define('CDN_IMAGES', 'http://download.exploretalent.com');
        }
        if(!defined('CDN_JS_CSS'))
        {
            //define('CDN_JS_CSS', 'http://public.exploretalent.com/');
            //define('CDN_JS_CSS', 'http://wac.9136.edgecastcdn.net/809136/cristi.exploretalent');
            define('CDN_JS_CSS', '');
        }
    }

    protected function _initCache()
    {
        $frontendOptions = array(
            'lifetime' => 60, // cache lifetime of 2 hours
            'automatic_serialization' => false,
            'regexps' => array(
                // cache the whole IndexController
                '^/$' => array('cache' => true),
                // cache the whole IndexController
                '^/index/' => array('cache' => true),
                // and we cache even there are some variables in $_POST
                'cache_with_post_variables' => true,

                // but the cache will be dependent on the $_POST array
                'make_id_with_post_variables' => true
            )
        );

        $backendOptions = array(
            'cache_dir' => 'tmp' // Directory where to put the cache files
        );

        $cache = Zend_Cache::factory('Output',
            'File',
            $frontendOptions,
            $backendOptions);

        Zend_Registry::set('cache', $cache);
    }

    protected function _initDocType()
    {
        $this->bootstrap('view');

        $view = $this->getResource('view');

        $view->doctype('XHTML1_STRICT');

        $view->addScriptPath(APPLICATION_PATH . "/partials");
    }

    protected function _initMenus()
    {
        $this->_resourceLoader->addResourceType('menu', 'menus', 'Menu');
    }


    protected function _initModuleDir()
    {
        $front = Zend_Controller_Front::getInstance();

        $front->addModuleDirectory(APPLICATION_PATH . '/modules');

        Application_Model_ModuleLoader::load(
            ['auditions',
            'activityfeed',
            'articles',
            'bugs',
            'calllog',
            'cduser',
            'producers',
            'contests',
            'chat',
            'fans',
            'talents',
            'friends',
            'notifications',
            'friendsnotification',
            'roles',
            'contestchat',
            'contests',
            'contestant',
            'contestant_media',
            'castings',
            'community_buzz',
            'emailverification',
            'zips',
            'online',
            'media',
            'meters',
            'join',
            'store',
            'points',
            'producers',
            'profile',
            'profiles',
            'requests',
            'resume',
            'resumeprofile',
            'resources',
            'wallmessages',
            'wallcomments',
            'generator',  // to remove
            'talentbcards',
            'talentrating',
            'testimonials',
            'tracker']
        );

    }

    protected function _initCustomRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $route = new Zend_Controller_Router_Route_Redirect('/flashjoin',
            array('module'=>'default', 'controller'=>'join', 'action'=>'flash'));
        $router->addRoute('b_route', $route);

        $this->_customRoutesAuditionSearch();
        $this->_customRoutesStaticPages();
        $this->_customRoutesAuditionPages();
        $this->_customRoutesProfilePages();
    }

    protected function _customRoutesProfilePages()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $route = new Zend_Controller_Router_Route('cs_profile.php',
            array( 'module'=>'profile', 'controller'=> 'social', 'action'=>'social-info') );
        $router->addRoute('d_route', $route);

        $route = new Zend_Controller_Router_Route('model_page.php',
            array('module'=>'profile', 'controller'=>'social', 'action'=>'social-info'));
        $router->addRoute('da_route', $route);


        $route = new Zend_Controller_Router_Route('view_resume.php',
            array('module'=>'resume', 'controller'=>'index', 'action'=>'index'));
        $router->addRoute('e_route', $route);

        $route = new Zend_Controller_Router_Route('model_page_pic.php',
            array('module'=>'profile', 'controller'=>'acting', 'action'=>'gallery'));
        $router->addRoute('s_route', $route);

        $route = new Zend_Controller_Router_Route('model_page_link.php',
            array('module'=>'profile', 'controller'=>'links', 'action'=>'index'));
        $router->addRoute('profile_link_route', $route);
    }

    protected function _customRoutesAuditionPages()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addRoute(
            'audition_detail',
            new Zend_Controller_Router_Route_Regex(
                'auditions/(.\s+)-(.\s+)-(.\s+)-(.\d+)_(.\d+)',
                array(
                     'module' => 'auditions',
                     'controller' => 'index',
                     'action'     => 'view'
                ),
                array(
                     1 => 'category',
                     2 => 'title',
                     3 => 'location',
                     4 => 'location_id',
                     5 => 'casting_id'
                ),
                'auditions/%s-%s-%s-%d_%d' //reverse
            )
        );
    }

    protected function _customRoutesStaticPages()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();


        $route = new Zend_Controller_Router_Route_Regex('american_eagle_modeling.php',
            array('module'=>'articles', 'controller'=>'modeling', 'action'=>'american-eagle-modeling'));
        $router->addRoute('a_route', $route);

        $route = new Zend_Controller_Router_Route_Regex('disney-channel-auditions.php',
            array('module'=>'articles', 'controller'=>'disney-channel', 'action'=>'disney-channel-auditions'));
        $router->addRoute('c_route', $route);

        $route = new Zend_Controller_Router_Route('explore-talent-scam.php',
            array('module'=>'index', 'controller'=>'about', 'action'=>'scam'));
        $router->addRoute('i_route', $route);

        $route = new Zend_Controller_Router_Route('explore-talent-scam.php',
            array('module'=>'index', 'controller'=>'about', 'action'=>'scam'));
        $router->addRoute('i_route', $route);

        $route = new Zend_Controller_Router_Route('tyler_perry_auditions.php',
            array('module'=>'articles', 'controller'=>'auditions', 'action'=>'tyler-perry-auditions'));
        $router->addRoute('j_route', $route);

        $route = new Zend_Controller_Router_Route('tyler_perry_auditions.php',
            array('module'=>'articles', 'controller'=>'auditions', 'action'=>'tyler-perry-auditions'));
        $router->addRoute('j_route', $route);

        $route = new Zend_Controller_Router_Route('tyler_perry.php',
            array('module'=>'articles', 'controller'=>'auditions', 'action'=>'tyler-perry-auditions'));
        $router->addRoute('k_route', $route);

        $route = new Zend_Controller_Router_Route('gabrielle_union.php',
            array('module'=>'index', 'controller'=>'industry', 'action'=>'gabrielle-union'));
        $router->addRoute('l_route', $route);

        $route = new Zend_Controller_Router_Route('american_eagle_modeling.php',
            array('module'=>'articles', 'controller'=>'modeling', 'action'=>'american-eagle-modeling'));
        $router->addRoute('m_route', $route);

        $route = new Zend_Controller_Router_Route('ariel_tweto.php',
            array('module'=>'index', 'controller'=>'industry', 'action'=>'ariel-tweto'));
        $router->addRoute('n_route', $route);

        $route = new Zend_Controller_Router_Route('become_a_victoria_secret_model.php',
            array('module'=>'articles', 'controller'=>'modeling', 'action'=>'become-a-victoria-secret-model'));
        $router->addRoute('o_route', $route);

        $route = new Zend_Controller_Router_Route('industry.php',
            array('module'=>'index', 'controller'=>'industry', 'action'=>'index'));
        $router->addRoute('p_route', $route);

        $route = new Zend_Controller_Router_Route('usher_raymond.php',
            array('module'=>'index', 'controller'=>'industry', 'action'=>'usher-raymond'));
        $router->addRoute('q_route', $route);

        $route = new Zend_Controller_Router_Route('david_banner.php',
            array('module'=>'index', 'controller'=>'industry', 'action'=>'david-banner'));
        $router->addRoute('ra_route', $route);

        $route = new Zend_Controller_Router_Route('auditions_for_disney_channel.php',
            array('module'=>'articles', 'controller'=>'disney-channel', 'action'=>'auditions-for-disney-channel'));
        $router->addRoute('rb_route', $route);

        $route = new Zend_Controller_Router_Route('disney-channel-auditions.php',
            array('module'=>'articles', 'controller'=>'disney-channel', 'action'=>'disney-channel-auditions'));
        $router->addRoute('r_route', $route);
    }

    protected function _customRoutesAuditionSearch()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $route = new Zend_Controller_Router_Route('search/acting',
            array('module'=>'auditions', 'controller'=>'index', 'action'=>'acting'));
        $router->addRoute('acting_route', $route);

        $route = new Zend_Controller_Router_Route('search/dance',
            array('module'=>'auditions', 'controller'=>'index', 'action'=>'dance'));
        $router->addRoute('dance_route', $route);

        $route = new Zend_Controller_Router_Route('search/modeling',
            array('module'=>'auditions', 'controller'=>'index', 'action'=>'modeling'));
        $router->addRoute('modeling_route', $route);

        $route = new Zend_Controller_Router_Route('search/music',
            array('module'=>'auditions', 'controller'=>'index', 'action'=>'music'));
        $router->addRoute('music_route', $route);

        $route = new Zend_Controller_Router_Route('search/crew',
            array('module'=>'auditions', 'controller'=>'index', 'action'=>'crew'));
        $router->addRoute('crew_route', $route);

        $route = new Zend_Controller_Router_Route('model_page_video.php',
            array('module'=>'profile', 'controller'=>'acting', 'action'=>'video'));
        $router->addRoute('sa_route', $route);
    }

}