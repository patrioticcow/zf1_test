<?php

class Application_Model_Videoconvertor extends Application_Model_Mapper_Abstract
{
	/**
	 *  -i Input file name
	 *	-ar Audio sampling rate in Hz
	 *	-ab Audio bit rate in kbit/s
	 *	-f Output format
	 *	-s Output dimension
	 *  ex: exec("ffmpeg -i video.avi -ar 22050 -ab 32 -f flv -s 320x240 video.flv");
     *
     *
     * EDIT: THIS FUNCTIONS ARE NOT USED, BUT DO NOT FUCKING DELETE THEM
	 */

	public function convertVideo($videoName, $videoTitle ,$videoDes, $mediaDir, $lastId)
	{
		$main_folder = '/var/www/media2/videos/';
		//$temp_folder = '/var/www/multimedia/tmp/';

		$folder = $this->currentFolder();
		$talentFolder = str_pad( USERID, 10, '0', STR_PAD_LEFT );
		$this->fullPath($main_folder, $mediaDir, $folder, $talentFolder);
		//$x = explode('.',$videoName);
		//$file = $x[1];

		return 'saving';
	}

	/*
	 * insert video to get the video_id set
	 * */
	public function insertVideo($data, $type = 0, $videoCategory)
	{
	    $time = time();
		$video 	= new Media_Model_Videos();
		// add new video in the database
		$videos = array();
		$videos['talentnum']    = USERID;
		$videos['profile_id']   = USERID;
		$videos['date_created'] = $time;
        $videos['title']        = $data['video_title'];
        $videos['des']          = $data['video_description'];
        $videos['ip_uploaded']  = $_SERVER['SERVER_ADDR'];
        $videos['status']       = 0;
        $videos['approved']     = 0;
        $videos['type']         = $type;
        $videos['video_category'] = $videoCategory;

		$video->create($videos);

        $fetch = $video->fetchAll('talentnum = '.USERID.' AND date_created = '.$time, null, 1);
		return $fetch->getVideoId();
	}

	/*
	 * upload video
	 * */
	public function uploadVideo($data, $type = 0, $videoCategory)
	{
		$video 	= new Media_Model_Videos();
		// add new video in the database
		$videos = array();

		$videos['video_id'] = $data['video_id'];
		$videos['talentnum'] = USERID;
		$videos['title'] = $data['video_title'];
		$videos['des'] = $data['video_description'];
		$videos['ip_uploaded'] = $_SERVER['SERVER_ADDR'];
		$videos['status'] = 0;
		$videos['approved'] = 0;
		$videos['type'] = $type;

		$video->create($videos);
	}


	/*
	 * build the talent folder name  ex: //media_0000145198
	* */
	public function currentFolder()
	{
		$number = floor(USERID/10000);
		$number = str_pad($number, 3, "0", STR_PAD_LEFT);
		$folder = "media".$number;

		return $folder;
	}

	/*
	 * create the directory for upload
	* */
	public function fullPath($main_folder, $mediaDir, $folder, $talentFolder)
	{
		// check if media folder exists
		$mediaFolder = $main_folder.'/'.$folder;

		if( ! is_dir( $mediaFolder ) )
		{
			$mask_1 = umask( 0 );
			mkdir( $mediaFolder, 0777 );
			umask( $mask_1 );
		}

		// check if talent folder exists
		$talentFolderPath = $mediaFolder."/".$talentFolder;

		if( ! is_dir( $talentFolderPath ) )
		{
			$mask_2 = umask( 0 );
			mkdir( $talentFolderPath, 0777 );
			umask( $mask_2 );
		}

		return $talentFolderPath;
	}

	/* (non-PHPdoc)
	 * @see Application_Model_Mapper_Abstract::fetchAll()
	 */
	protected function fetchAll() {
		// TODO Auto-generated method stub

	}

	/* (non-PHPdoc)
	 * @see Application_Model_Mapper_Abstract::find()
	 */
	protected function find($id = null) {
		// TODO Auto-generated method stub

	}

	/* (non-PHPdoc)
	 * @see Application_Model_Mapper_Abstract::delete()
	 */
	protected function delete($id = null) {
		// TODO Auto-generated method stub

	}


}