<?php

class Profile_Form_Factory {

	public static function enableProfile()
	{
		$id = USERID ? USERID : null;
		$formAll = new Profile_Form_Enableprofile(array(
				'name' => 'enableprofile',
				'action' => '/profile/social/'.$id,
				'method' => 'post'
		));

		return $formAll;
	}

	public static function imageUploadBoard($action)
	{
	    $id = USERID ? USERID : null;
		$formAll = new Profile_Form_Imageuploadboard(array(
				'name' => 'imageupload',
				'action' => '/profile/'.$action.'/editimages/id/'.$id,
				'method' => 'post'
		), $action);

		return $formAll;
	}

    public static function imageUpload($action)
	{
	    $id = USERID ? USERID : null;
		$formAll = new Profile_Form_Imageupload(array(
				'name' => 'imageupload',
				'action' => '/profile/'.$action.'/editimages/id/'.$id,
				'method' => 'post'
		), $action);

		return $formAll;
	}

    public static function imageUploadJoin()
    {
        $formAll = new Profile_Form_Imageupload(array(
            'name' => 'imageupload',
            'action' => '/join/flash/upload',
            'method' => 'post'
        ));

        return $formAll;
    }

	public static function imageUploadSecond($action)
	{
	    $id = USERID ? USERID : null;
		$formAll = new Profile_Form_Imageuploadsecond(array(
				'name' => 'imageuploadsecond',
				'action' => '/profile/'.$action.'/editimages/id/'.$id,
				'method' => 'post'
		));

		return $formAll;
	}

	public static function imageDelete($id = null, $action)
	{
		$formAll = new Profile_Form_Imagedelete(array(
				'name' => 'imagedelete',
				'action' => '/profile/'.$action.'/editimages/',
				'method' => 'post'
		), $id);

		return $formAll;
	}

	public static function addCategory($action)
	{
		$formAll = new Profile_Form_Addcategory(array(
				'name' => 'addcategory',
				'action' => '/profile/'.$action.'/editimages/',
				'method' => 'post'
		));

		return $formAll;
	}

	public static function editResume($value, $action)
	{
		$formAll = new Profile_Form_Editresume(array(
				'name' => 'editresume',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		), $value);

		return $formAll;
	}

	public static function editAbout($value, $action)
	{
		$formAll = new Profile_Form_Editabout(array(
				'name' => 'editabout',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		), $value);

		return $formAll;
	}

	public static function editActing($value, $action)
	{
		$formAll = new Profile_Form_Editacting(array(
				'name' => 'editacting',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		), $value);

		return $formAll;
	}

    public static function editRelationship($action)
	{
		$formAll = new Profile_Form_Editrelationship(array(
				'name' => 'editrelationship',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		));

		return $formAll;
	}

	public static function editInterests($action)
	{
		$formAll = new Profile_Form_Editinterests(array(
				'name' => 'editinterests',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		));

		return $formAll;
	}

	public static function editMusician($value, $action)
	{
		$formAll = new Profile_Form_Editmusician(array(
				'name' => 'editmusician',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		), $value);

		return $formAll;
	}

	public static function editDance($value, $action)
	{
		$formAll = new Profile_Form_Editdance(array(
				'name' => 'editdance',
				'action' => '/profile/'.$action.'/edit/',
				'method' => 'post'
		), $value);

		return $formAll;
	}

	public static function editVideoUpload($action, $id = null)
	{
		$formAll = new Profile_Form_Videoupload(array(
				'name' => 'videoupload',
				'action' => '/profile/'.$action.'/editvideo/id/'.$id,
				'method' => 'post'
		));

		return $formAll;
	}

	public static function editAudioUpload($action)
	{
		$formAll = new Profile_Form_Audioupload(array(
				'name' => 'audioupload',
				'action' => '/profile/'.$action.'/editaudio',
				'method' => 'post'
		));

		return $formAll;
	}

	public static function sendMessage()
	{
		$formAll = new Profile_Form_Sendmessage(array(
				'name' => 'sendmessage',
				'action' => '/profile/index/sendmessage',
				'method' => 'post'
		));

		return $formAll;
	}

}