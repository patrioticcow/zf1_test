<?php

class SidebarController extends Zend_Controller_Action
{
    public function init()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('auditions-widget', 'html')
                    ->addActionContext('friends-widget', 'html')
                    ->initContext();
    }

    public function auditionsWidgetAction()
    {
        $x = new Profile_Model_Widgets();
        $data = $x->getAuditionsCount();

        $this->view->data = $data['data'];
        $this->view->total = $data['total'];
    }

    public function friendsWidgetAction()
    {
        $userid = Application_Model_Functions::getId();

        if($userid == null){$userid = USERID;}

        $name = 'My';
        if($userid != USERID){
            $getName = Application_Model_Functions::getName($userid);
            $name = $getName['fname']."'s";
        }

        $model = new Friends_Model_Etfriends();
        $friends = $model->getAcceptedFriends();

        $this->view->friends = $friends;
        $this->view->name = $name;
        $this->view->id = Application_Model_Functions::getId();
    }

}