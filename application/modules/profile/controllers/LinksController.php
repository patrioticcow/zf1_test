<?php
class Profile_LinksController extends Zend_Controller_Action
{
	public $userid;
	public function init()
	{
		$this->view->headLink ()->appendStylesheet ('/css/profile/profile.css');
		$this->_helper->layout->setLayout ('profile');

        $id = $this->getRequest()->getParam('id', $this->getRequest()->getParam('talentnum', null));
        if (empty($id)) {
            $this->_redirect('/');
        } else {
            $this->_setParam('id', $id);
        }
	}
	public function indexAction()
	{
		$info = new Talents_Model_Talentci();
		$this->getInfo = $info->setTalentci('talentnum=' . $this->getRequest()->getParam('id'));
		$this->view->info = $this->getInfo;

        $this->putSeo($this->getInfo->getFname() . ' ' .  $this->getInfo->getLname());
	}
    public function putSeo($seoStr)
    {
        $this->view->headTitle ("Explore Talent | Link to " . $seoStr);
        $this->view->headMeta ()->appendName ('keywords', Application_Model_Seo::getSeoKeywords(
            "Link to " . $seoStr,
            'link to explore talent',
            'modeling, acting, dance, music exploretalent'
        ));
        $this->view->headMeta ()->appendName ('description',
            Application_Model_Seo::getSeoDescription(
                "Link to " . $seoStr
            )
        );
        $this->view->headMeta ()->appendName ('og:title', "Explore Talent | Link to " . $seoStr);
        $this->view->headLink(
            array(
                'rel' => 'canonical',
                'href' => Application_Model_Seo::getProfileLinksCanonicalLink($this->getRequest()->getParam('id'))
            ),
            'PREPEND'
        );
    }

}