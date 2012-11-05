<?php
/*
 * Different includes
 * */
abstract class Application_Model_Includes
{

	public static function includeSettings()
	{

		$form = new Profile_Form_Factory();

		$settings = '<div id="enable_profile">'.$form->enableProfile().'</div>';
		
		return $settings;
	}

}