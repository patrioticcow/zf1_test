<?php

class Session_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //Application_Model_Auth::authorize("user");

        //$this->_helper->layout->setLayout('default');
    }

    public function testAction()
    {
        $model = new Session_Model_Session();

        $result = $model->fetchAll('session_id = "'.Zend_Session::getId().'"', 'modified DESC');

        //Zend_Debug::dump($result);
        exit;
    }
}

