<?php

class Generator_IndexController extends Zend_Controller_Action
{
	private $acl;

	private $userObj;

    public function init()
    {
    	$this->view->title = "Code Generator";

        $this->_helper->layout->setLayout('default');
    }

    public function generateAction()
    {
    	if($this->getRequest()->isPost())
    	{

    		$model = new Generator_Model_Generator();

    		$proxy = $model->generate();

    		$module = $proxy->_modulename;

    		//var_dump(Zend_Registry::get('profiler'));
    		if($proxy->_bootstrap != null)
    		{
    		    $this->view->bootstrap = $proxy->_bootstrap;
    		    $this->view->proxy = $proxy;
    		}
    		else
    		{
    		    $this->_helper->redirector('index', 'index', $module);
    		}
    	}
    	else
    	{
    		$model = new Generator_Model_Generator();

    		$dbname = $model->getDbName();

    		$modules = Generator_Model_Generator::getExistingModules();

    		$form = Generator_Form_Factory::getForm();

    		$form->setDefaults(array('database_name' => $dbname));

    	    $this->view->form = $form;
    	}

    }

    public function overwriteAction()
    {
    	$model = new Generator_Model_Generator();

    	$proxy = $model->generate();

    	//var_dump($object = $proxy->_modulename);

    	$this->_helper->redirector('index', 'index', strtolower($object));
    }


    public function indexAction()
    {
        $this->view->title = "Code Generator";

        $this->generateAction();

        $this->render('generate');

    }

}



