<?php

class TopmenuController extends Zend_Controller_Action
{
    public function init()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('topmenu', 'html')
                    ->initContext();
    }

    public function topmenuAction()
    {
        if(LOGGEDIN)
        {
            $friends = Application_Model_Functions::fetchFriends();
            $friendsCount = count($friends);

            $model = new Profile_Model_Messages(); $model->useDependents(false);
            $messageData = $model->fetchAll('too = '.USERID);
            $messagesCount = count($messageData);

            $totalCount = $messagesCount + $friendsCount;

            //
            $models = new Profile_Model_Profileviews(); $models->useDependents(false);
            $dataViewed = count( $models->parseData('viewed', 1) );
            $dataViews = count( $models->parseData('views', 1) );

            //get saved jobs
            $savedModel = new Notifications_Model_Savedjobs(); $savedModel->useDependents(false);
            $fetcsSaved = count($savedModel->fetchAll('talentnum = '.USERID));

            //$totalViews = $dataViewed + $dataViews + $fetcsIntOne + $fetcsIntTwo + $fetcsIntThree;
            $totalViews = $dataViewed;

            $xModel = new Auditions_Model_SubTalentSubmissions(USERID);
            $submissions = count($xModel->fetchAll('sub_type = 2'));

            $listCount = $fetcsSaved + $submissions;

            $this->view->totalCount     = $totalCount;
            $this->view->dataViews      = $dataViews;
            $this->view->totalViews     = $totalViews;
            $this->view->listCount      = $listCount;
            $this->view->messagesCount  = $messagesCount;
            $this->view->friendsCount   = $friendsCount;
            $this->view->fetcsSaved     = $fetcsSaved;
            $this->view->submissions    = $submissions;

        }
    }
}