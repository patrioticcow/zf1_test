<?php

class Application_Model_Upload extends Application_Model_Mapper_Abstract
{

	/*
	 * -------------------------------------------------------------------------------
	 *  ATTENTION !!! - because of the fucked up database structure i have to give a
	 *  chinese massage to the code below to accommodate the Acting Profile,
	 *  witch uses another table "talent_media2"
	 * -------------------------------------------------------------------------------
     * NOTE: I added separate tables for different profiles. Acting fixed
	 * */

	public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

	public function imageUpload($image, $mediaDir, $type, $table = null, $multiUpload = null, $gallery = null, $contestId = null, $userid = null)
	{
        $userid = $userid != null ? $userid : USERID;

		$main_folder = '/var/www/';
		$folder = $this->currentFolder($userid);
		$talentFolder = str_pad( $userid, 10, '0', STR_PAD_LEFT );
		$talentFolderPath = $this->fullPath($main_folder, $mediaDir, $folder, $talentFolder);

        if($image != null) { $file = pathinfo($image, PATHINFO_EXTENSION); }

		if($type == 2)
		{
			return $this->uploadPrimaryImage($type, $table, $talentFolderPath, $mediaDir, $talentFolder, $file, $gallery); //primary image
		}
		else if ($type == 1)
		{
			return $this->uploadSecondaryImage($talentFolder, $file, $talentFolderPath, $type, $gallery, $table, $mediaDir); // secondary image
		}
        else if ($type == 3)
        {
            return $this->uploadContestImage($multiUpload, $talentFolder, $main_folder, $mediaDir); // contest image
        }
        else if($type == 4)
        {
            return $this->uploadContestantMultyImages($image, $talentFolder, $talentFolderPath); // contestant multy images
        }
        else if($type == 5)
        {
        	return $this->uploadContestantSingleImages($image, $talentFolder, $talentFolderPath, $contestId); // contestant single images
        }
		else if($type == 6)
        {
        	return $this->uploadForBusinessCards($image, $talentFolder, $talentFolderPath); // business cards
        }
        else if ($type == 7)
        {
        	return $this->uploadForDynamicProfilesMainImage($image, $talentFolder, $talentFolderPath); // dynamic profiles main image
        }
        else if ($type == 8)
        {
        	return $this->uploadNoDb($image, $talentFolderPath); // no db upload
        }
        else if ($type == 9)
        {
            return $this->uploadJoinPrimaryImage(2, $table, $talentFolderPath, $mediaDir, $talentFolder, $file, $gallery, $userid); // upload join images
        }
        else
        {
        	//return $discUpload;
        	return '';
        }

	}

	public function uploadJoinPrimaryImage($type, $table, $talentFolderPath, $mediaDir, $talentFolder, $file, $gallery, $userid)
	{
		$mediaPath = $this->primaryImage($type, $table, $userid); // get path
Zend_Debug::dump($talentFolderPath);
Zend_Debug::dump($mediaPath[0]->media_path);
		if ($mediaPath)
        {
			$discUpload = $this->uploadToDisk($talentFolderPath, $mediaPath[0]->media_path);

			if ($discUpload == 'success')
			{
                $this->uploadCroppedImage($talentFolderPath.'/'.$mediaPath[0]->media_path, 0, 0, 0, 0); //crop image

				$this->databaseUpdate($mediaPath[0]->id, $mediaPath[0]->media_path, $table);
			}
		}
        else
        {
			$filename = $talentFolder.'_PM_'.time().'.'.$file;// create file name
			$discUpload = $this->uploadToDisk($talentFolderPath, $filename); // check for disc upload

			if($discUpload == 'success')
			{
                $this->uploadCroppedImage($talentFolderPath.'/'.$filename, 0, 0, 0, 0); //crop image

				$this->databaseInsert($filename, $type, $gallery, $table, $userid);
			}
		}
	}

    public function uploadPrimaryImage($type, $table, $talentFolderPath, $mediaDir, $talentFolder, $file, $gallery)
    {
        $afModel = new Activityfeed_Model_Activityfeednotifications();
        $mediaPath = $this->primaryImage($type, $table); // get path

        if ($mediaPath)
        {
            $discUpload = $this->uploadToDisk($talentFolderPath, $mediaPath[0]->media_path);

            if ($discUpload == 'success')
            {
                $this->uploadCroppedImage($talentFolderPath.'/'.$mediaPath[0]->media_path, 0, 0, 0, 0); //crop image

                $this->databaseUpdate($mediaPath[0]->id, $mediaPath[0]->media_path, $table);
                //activity feed notifications
                $afModel->create( array( 'from_id'=>USERID, 'to_id'=>'', 'notification_id'=>16, 'date'=>time(), 'type'=>$this->not($mediaDir), 'picture'=>$mediaPath[0]->media_path) );
            }
        }
        else
        {
            $filename = $talentFolder.'_PM_'.time().'.'.$file;// create file name
            $discUpload = $this->uploadToDisk($talentFolderPath, $filename); // check for disc upload

            if($discUpload == 'success')
            {
                $this->uploadCroppedImage($talentFolderPath.'/'.$filename, 0, 0, 0, 0); //crop image

                $this->databaseInsert($filename, $type, $gallery, $table);
                //activity feed notifications
                $afModel->create( array( 'from_id'=>USERID, 'to_id'=>'', 'notification_id'=>16, 'date'=>time(), 'type'=>$this->not($mediaDir), 'picture'=>$filename) );
            }
        }
    }

	public function uploadSecondaryImage($talentFolder, $file, $talentFolderPath, $type, $gallery, $table, $mediaDir)
	{
		$afModel = new Activityfeed_Model_Activityfeednotifications();

		$filename = $talentFolder.'_SM_'.time().'.'.$file;
		$discUpload = $this->uploadToDisk($talentFolderPath, $filename);

		if($discUpload == 'success')
		{
			$this->databaseInsert($filename, $type, $gallery, $table);

			//activity feed notifications
			$afModel->create( array( 'from_id'=>USERID, 'to_id'=>'', 'notification_id'=>16, 'date'=>time(), 'type'=>$this->not($mediaDir), 'picture'=>$filename ) );
		}
	}

	public function uploadContestImage($multiUpload, $talentFolder, $main_folder, $mediaDir)
	{
		$afModel = new Activityfeed_Model_Activityfeednotifications();

		if (is_array($multiUpload)){
			$filenames = array();

			foreach($multiUpload as $key => $val){
				// get the file extension
				$ext = pathinfo($val, PATHINFO_EXTENSION);

				// create custom file name
				do {
					$filename = $talentFolder.'_CT_'.time(). '.' . $ext;
					$diskPath = $main_folder . $mediaDir . $filename;
				} while (file_exists($diskPath));

				$filenames[$key] = $filename;

				//send to the upload funtion
				// $val is the file to receive, $diskPath is where it will be moved to
				$discUpload = $this->uploadToDiskMulty($val, $diskPath);
				if($discUpload == 'success')
				{
					//activity feed notifications
					$afModel->create( array( 'from_id'=>USERID, 'to_id'=>'', 'notification_id'=>17, 'date'=>time(), 'type'=>$this->not($mediaDir), 'picture'=>$filename[0] ) );
				}
			}

			return $filenames;
		}
	}

	public function uploadContestantMultyImages($image, $talentFolder, $talentFolderPath)
	{
		// get the file extension
		$ext = pathinfo($image, PATHINFO_EXTENSION);

		do {
			$filename = $talentFolder.'_CM_'.time(). '.' . $ext;
			$diskPath = $talentFolderPath.'/'.$filename;
		} while (file_exists($diskPath));

		// upload to folder
		$this->uploadToDiskMulty($image, $diskPath);

		return $filename;
	}

	public function uploadContestantSingleImages($image, $talentFolder, $talentFolderPath, $contestId)
	{
		$modelContestant = new Contestantmedia_Model_Contestantmedia();
		$fetch = $modelContestant->fetchAll('contest_id = '.$contestId.' AND talentnum = '.USERID, 'id DESC', 1);

		if($fetch != null){
			$media = $fetch->getMedia();

			$explode = explode('/', $media);
			$filename = $explode[1];

		} else {
			$ext = pathinfo($image, PATHINFO_EXTENSION);
			$filename = $talentFolder.'_CM_'.time(). '.' . $ext;
		}

		$diskPath = $talentFolderPath.'/'.$filename;

		// upload to folder
		$this->uploadToDiskMulty($image, $diskPath);

		return $filename;
	}

	public function uploadForBusinessCards($image, $talentFolder, $talentFolderPath)
	{
		// get the file extension
		$ext = pathinfo($image, PATHINFO_EXTENSION);

		do {
			$filename = $talentFolder.'_BC_'.time(). '.' . $ext;
			$diskPath = $talentFolderPath.'/'.$filename;
		} while (file_exists($diskPath));

		// upload to folder
		$x = $this->uploadToDiskMulty($image, $diskPath);

		return $x == 'success' ? $filename : null;
	}

	public function uploadNoDb($image, $talentFolderPath)
	{
		// get the file extension
		$ext = pathinfo($image, PATHINFO_EXTENSION);

		do {
			$filename = USERID.'_COVER.'. $ext;
			$diskPath = $talentFolderPath.'/'.$filename;
		} while (file_exists($diskPath));

		// upload to folder
		$x = $this->uploadToDiskMulty($image, $diskPath);

		return $x == 'success' ? $filename : null;
	}

	public function uploadForDynamicProfilesMainImage($image, $talentFolder, $talentFolderPath)
	{
		// get the file extension
		$ext = pathinfo($image, PATHINFO_EXTENSION);

		do {
			$filename = $talentFolder.'_DP_'.time(). '.' . $ext;
			$diskPath = $talentFolderPath.'/'.$filename;
		} while (file_exists($diskPath));

		// upload to folder
		$x = $this->uploadToDiskMulty($image, $diskPath);

		if($x == 'success')
		{
			//activity feed notifications
			$afModel = new Activityfeed_Model_Activityfeednotifications();
			$afModel->create( array( 'from_id'=>USERID, 'to_id'=>'', 'notification_id'=>16, 'date'=>time(), 'type'=>6, 'picture'=>$filename ) );
		}

		$returnPath = str_replace('/var/www/media/', '', $diskPath);
		return $x == 'success' ? $returnPath : null;
	}

    public function uploadCroppedImage($image, $x, $y, $w, $h)
    {
        $explode = explode('/', $image);
	    $saveImage = '/var/www/media/'.$explode['3'].'/'.$explode['4'].'/'.$explode['5'].'/'.$explode['6'];
        $saveImage = $this->cropHelper($saveImage);

	    $smallImage = '/var/www/media/'.$explode['3'].'/'.$explode['4'].'/'.$explode['5'].'/th'.$explode['6'];
	    $smallImage = $this->cropHelper($smallImage); // small image

        $mediumImage = '/var/www/media/'.$explode['3'].'/'.$explode['4'].'/'.$explode['5'].'/md'.$explode['6'];
        $mediumImage = $this->cropHelper($mediumImage); // medium image

        $targ_w = 200; $targ_ws = 40; $targ_wm = 90;
        $targ_h = 300; $targ_hs = 60; $targ_hm = 135;
        $jpeg_quality = 90;

        $local = "/var/www/html/media";
        $image = str_replace('http://download.exploretalent.com', $local, $image);

        $img_r = imagecreatefromstring(file_get_contents($image));
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h ); // large image
        $dst_rs = ImageCreateTrueColor( $targ_ws, $targ_hs ); // small image
        $dst_rm = ImageCreateTrueColor( $targ_wm, $targ_hm ); // medium image

        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h); // large image
        imagecopyresampled($dst_rs, $img_r, 0, 0, $x, $y, $targ_ws, $targ_hs, $w, $h); // small image
        imagecopyresampled($dst_rm, $img_r, 0, 0, $x, $y, $targ_wm, $targ_hm, $w, $h); // medium image

        imagejpeg($dst_r, $saveImage, $jpeg_quality); // large image
        imagejpeg($dst_rs, $smallImage, $jpeg_quality); // small image
        imagejpeg($dst_rm, $mediumImage, $jpeg_quality); // medium image
    }

    public function cropHelper($saveImage)
    {
        $saveNewImage = str_replace('//', '/', $saveImage);
        $newImage = str_replace('/media/media/', '/media/', $saveNewImage);
        return $newImage;
    }


	/*
	 * get the primary image.
	 *
	 * If the primary image exists we will overite it, else insert one.
	 * */
	public function primaryImage($type, $table, $userid = null)
	{
        $userid = $userid != null ? $userid : USERID;

		$select = $this->db->select()
			             ->from($table)
			             ->where('talentnum = '.$userid.' AND type = '.$type );
		$result = $this->db->fetchAll($select);

		return $result;
	}

	/*
	* update images(mostly used for the primary image)
	* */
	public function databaseUpdate ($id, $filename, $table)
	{
		$image_data = array(
					'media_path'    => $filename
		);

		$this->db->update($table, $image_data, array('id = ?' => $id));
	}

	/*
	 * insert images in the database
	 * */
	public function databaseInsert($filename, $type, $gallery, $table, $userid = null)
	{
        $userid = $userid != null ? $userid : USERID;

		$image_data = array(
					'talentnum'     => $userid,
					'media_path'    => $filename,
					'type'    		=> $type,
					'gallery'       => $gallery
		);

		$this->db->insert($table, $image_data);
	}

	/*
	 * delete image
	 */
	public function deleteImage($id, $table, $table_key = null)
	{

		if($table_key == null){
			$table_key = 'id';
		}

		if (is_array($id)){
			foreach($id as $v){
			    $this->db->delete($table, array( $table_key.' = ?' => $v ) );
			}
		} else {
		    $this->db->delete($table, array( $table_key.' = ?' => $id ) );
		}

        return 'success';
	}

	/*
	 * upload images to disc
	 * */
	public function uploadToDisk($talentFolderPath, $filename) // old one
	{
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$adapter->addFilter( 'Rename',array(
				'target' => $talentFolderPath."/".$filename,
				'overwrite' => true
		));
		return $adapter->receive() ? "success" : "fail";
	}

    public function uploadToDiskMulty($talentFolderPath, $filename)
    {
        $adapter = new Zend_File_Transfer_Adapter_Http();
        $adapter->addFilter('Rename', array(
                'target'    => $filename,
                'overwrite' => true
        ));
	    return $adapter->receive($talentFolderPath) ? "success" : "fail";
     }

	/*
	 * build the talent folder name  ex: //media_0000145198
	 * */
	public function currentFolder($userid)
	{
		$number = floor($userid/10000);
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
		$mediaFolder = $main_folder.$mediaDir.$folder;
		if( ! is_dir( $mediaFolder ) )
		{
			$mask_1 = umask( 0 );
			@mkdir( $mediaFolder, 0777 );
			umask( $mask_1 );
		}

		// check if talent folder exists
		$talentFolderPath = $mediaFolder."/".$talentFolder;

		if( ! is_dir( $talentFolderPath ) )
		{
			$mask_2 = umask( 0 );
			@mkdir( $talentFolderPath, 0777 );
			umask( $mask_2 );
		}

		return $talentFolderPath;
	}

    /**
     * calculate the id for the notification type
     * acting - type 0, dancer - type 1, modeling - type 2, music - type 3, social - type 4, dynamic = 6
     */
    public function not($mediaDir = null)
    {
        $notification = explode('/', $mediaDir);
        $notDir = $notification[1];

        $id = 4;

        if ($notDir == 'media_musician'){
            $id = 3;
        } else if ($notDir == 'media_acting'){
            $id = 0;
        } else if ($notDir == 'media_dance'){
            $id = 1;
        } else if ($notDir == 'media_modeling'){
            $id = 2;
        } else if ($notDir == 'media_social'){
            $id = 4;
        }

        return $id;
    }

	public function unlinkFile($fileName)
	{
		if (file_exists($fileName)) {
			unlink($fileName);
		}
	}

	protected function fetchAll() {}
	protected function find($id = null) {}
	protected function delete($id = null) {}
}