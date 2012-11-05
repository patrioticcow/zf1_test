<?php

class Application_Model_Audioconvertor extends Application_Model_Mapper_Abstract
{
	/**
	 *  -i Input file name
	 *	-ar Audio sampling rate in Hz
	 *	-ab Audio bit rate in kbit/s
	 *	-f Output format
	 *	-s Output dimension
	 *  ex: exec("ffmpeg -i video.avi -ar 22050 -ab 32 -f flv -s 320x240 video.flv");
	 */

	public function convertAudio($audioName, $audioTitle ,$audioDes, $mediaDir, $lastId)
	{
		$main_folder = '/var/www/media2/audio/';
		//$temp_folder = '/var/www/multimedia/tmp/';

		$folder = $this->currentFolder();
		$talentFolder = str_pad( USERID, 10, '0', STR_PAD_LEFT );
		$this->fullPath($main_folder, $mediaDir, $folder, $talentFolder);
		//$x = explode('.',$audioName);
        //$file = $x[1];

		return 'saving';
	}

	/*
	 * insert video to get the video_id set
	 * */
	public function insertAudio($data, $type = 0, $audioCategory)
	{
	    $time = time();
		$audio 	= new Media_Model_Songs();
		// add new video in the database
		$audios = array();
		$audios['talentnum'] = USERID;
        $audios['date_created'] = $time;
        $audios['title'] = $data['audio_title'];
        $audios['des'] = $data['audio_description'];
        $audios['ip_uploaded'] = $_SERVER['SERVER_ADDR'];
        $audios['status'] = 0;
        $audios['approved'] = 0;
        $audios['type'] = $type;
        $videos['video_category'] = $audioCategory;

		$audio->create($audios);

        $fetch = $audio->fetchAll('talentnum = '.USERID.' AND date_created = '.$time, null, 1);

		return $fetch->getSongId();
	}

	/*
	 * upload video
	 * */
	public function uploadAudio($data, $type = 0)
	{
		$audio 	= new Media_Model_Songs();
		// add new video in the database
		$audios = array();

		$audios['song_id'] = $data['song_id'];
		$audios['talentnum'] = USERID;
		$audios['date_created'] = time();
		$audios['title'] = $data['audio_title'];
		$audios['des'] = $data['audio_description'];
		$audios['ip_uploaded'] = $_SERVER['SERVER_ADDR'];
		$audios['status'] = 0;
		$audios['approved'] = 0;
		$audios['type'] = $type;

		$audio->create($audios);
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