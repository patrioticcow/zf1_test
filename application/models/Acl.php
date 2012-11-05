<?php
class Application_Model_Acl extends Zend_Acl
{
	public function __construct()
	{
		$this->init();

		return $this;
	}

	public function init()
	{
		 $this->addRoles();

        $this->addResources();

        $this->allowResources();

        $this->denyResources();
	}

	private function allowResources()
	{
		$this->allow(array('talent'), array('talent'));

        $this->allow(array('admin'), array('talent', 'admin', 'cd', 'visitor'));

        $this->allow(array('cd'), array('cd'));

        $this->allow(array('visitor'), array('visitor', 'visitor'));
	}

    private function denyResources()
	{
		$this->deny(array('visitor'), array('developer', 'cd', 'manager'));
	}

	private function addRoles()
	{
		$this->addRole(new Zend_Acl_Role('admin'));
		
		$this->addRole(new Zend_Acl_Role('cd'));

    	$this->addRole(new Zend_Acl_Role('talent'));

    	$this->addRole(new Zend_Acl_Role('visitor'));

    	return;
	}

	private function addResources()
	{
		$this->addResource('visitor');

		$this->addResource('admin');

        $this->addResource('developer');

        $this->addResource('manager');

        $this->addResource('talent');

        $this->addResource('cd');
	}
}
