<?php

class Roles_IndexController extends Zend_Controller_Action
{

    public $userObj = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        
        $this->userObj = $userObj = $auth->getStorage()->read();
        
        $this->view->title = "Code Generator";
        
        $this->_helper->layout->setLayout('homelayout');
    }

    public function indexAction()
    {
        $model = new Roles_Model_Roles();
        
        $result = $model->fetchAll(null, null, 10);
        
        $this->view->result = $result;
    }

    public function saveAction($data = null)
    {
        $model = new Roles_Model_Roles();
        
        $result = (true == $this->getRequest()->isPost()) ? $model->create() : $this->showForm();
        
        $this->view->result = $result;
    }

    public function fetchAction()
    {
        $model = new Roles_Model_Roles();
        
        $result = $model->fetchAll();
        
        $this->view->result = $result;
        
        $this->render("index");
    }

    public function findAction($id = null)
    {
        $model = new Roles_Model_Roles();
        
        $id = (null == $id) ? $this->getRequest()->getParam('id') : $id;
        
        $result = $model->find($id);
        
        $this->view->result = $result;
        
        $this->render("index");
    }

    public function deleteAction($id = null)
    {
        $model = new Roles_Model_Roles();
        
        $id = (null == $id) ? $this->getRequest()->getParam('id') : $id;
        
        $id = $model->delete($id);
        
        $this->view->result = $id . "Deleted.";
        
        $this->render("index");
    }


}

