<?php
ini_set('max_execution_time', 90);
class TestController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->setLayout('default');
	}

	public function indexAction()
	{
		$db = Application_Model_ServiceLocator::getDb('db');

		$data = [];

		$j = 1;
		for($i = 1; $i < 1000; $i++)
		{
			if($j >= 61)
			{
				$j = 1;
			}
			$data['talentnum'] = $i;
			$data['attribute_id'] = $j++;

			try {
				$db->insert('profile_attribute_names', $data);
			}
			catch(Exception $e)
			{
				$db->update('profile_attribute_names', $data, array('talentnum = ?' => $data['talentnum']));
			}
		}

		$select = $db->select()->from('profile_attribute_names', 'count(*) as count');

		$count = $db->fetchOne($select);

		print($count.' Records inserted'); exit;

		//$this->_helper->viewRenderer->setNoRender(TRUE);
	}

	public function testAction()
	{
		$db = Application_Model_ServiceLocator::getDb('db');
		//$select = $db->select()->from('profile_attribute_names', 'count(*) as count');

		$select = $db->select()
		->from('profile_attribute_names')
		->where('attribute_id = 60');

		$result = $db->fetchAll($select);

		Zend_Debug::dump($result);

		$this->_helper->viewRenderer->setNoRender(TRUE);
	}

	public function talentAction()
	{
		$model = new Talents_Model_Talentci();
		$model->usePaginator(TRUE);
		$model->useDependents(FALSE);

		$talentnum = 145198;
		$talentlogin = 'hey2';
		$dphone = 3108480157;
//
		$result = $model->fetchAll('dphone = ?', null, 1, null, [$dphone]);
		//$result = $model->fetchAll('talentnum = ?', null, 1, null, $talentnum);
		$this->view->result = ($result);

		$this->render('index');
	}

	public function modelsearchAction()
	{
		$limit = 35;

		$db = Application_Model_ServiceLocator::getDb('db');
		//$select = $db->select()->from('profile_attribute_names', 'count(*) as count');
		$d = new Zend_Db_Expr('UNIX_TIMESTAMP(NOW(), INTERVAL 6 MONTH)');
		$select = $db->select()
                             ->from (
                                array ('a' => 'bam.talentci'),
                                array('a.talentnum', 'a.fname', 'a.lname', 'a.city as city1', 'a.state', 'a.zip', 'a.email1')
                             )

                             ->joinRight (
                                array ('d' => 'bam.talent_media2_social' ), //table
                                'a.talentnum = d.talentnum', //join on
                                array ('d.id', 'd.media_path', 'd.type', 'd.gallery') //join what?
                             )

                             ->joinLeft (
                                array ('b' => 'bam.talentinfo2' ), //table
                                'a.talentnum = b.talentnum', //join on
                                array ('b.ethnicity', 'b.union_sag', 'b.union_aftra', 'b.union_aea', 'b.union_other') //join what?
                             )

                             ->joinLeft (
                                array ('c' => 'bam.talentinfo1' ), //table
                                'a.talentnum = c.talentnum', //join on
                                array ('c.sex', 'c.dobdd', 'c.dobmm', 'c.dobyyyy', 'c.heightinches', 'c.heightfeet', 'c.weightpounds', 'c.haircolor', 'c.hairstyle', 'c.eyecolor') //join what?
                             )

							 ->joinLeft (
                                array ('e' => 'bam.online_all' ), //table
                                'a.talentnum = e.talentnum', //join on
                                array ('e.last_access') //join what?
                             )
                             ->where(1)
                             ->where('e.last_access > ?')
                             ->bind($d)
                            // ->order($order)
                             ->limit($limit);

		$result = $db->fetchAll($select);

		Zend_Debug::dump($result);
		exit;
	}

	public function testcduserAction()
	{
		$model = new Cduser_Model_Cduser();
		$model->useDependents(TRUE);

		$results = $model->fetchAll(null, null, 10);

		Zend_Debug::dump($results);
		exit;
	}
}