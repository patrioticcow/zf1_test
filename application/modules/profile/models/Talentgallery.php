<?php

class Profile_Model_Talentgallery extends Application_Model_Proxy
{

    protected static $_mapper 	= null;

    protected $_gallery_id 		= null;
    protected $_gallery_name 	= null;
    protected $_talentnum 		= null;

    //protected $_dependent_table = null;

    public function __construct()
    {
        self::$_mapper = new Profile_Model_Mapper_Talentgallery();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();
            $data = $front->getRequest()->getParams();
        }

        $this->_gallery_id 		= !empty($data["gallery_id"]) 	? $data["gallery_id"] 	: null;
        $this->_gallery_name 	= !empty($data["gallery_name"]) ? $data["gallery_name"] : null;
        $this->_talentnum 		= !empty($data["talentnum"]) 	? $data["talentnum"] 	: null;

        $id = self::$_mapper->save($this);

        return $id;
    }

    public function getImages($type = null, $table, $folder = null)
    {
        $pic = new Media_Model_Media();
        
        $front = Zend_Controller_Front::getInstance();
        $userid = $front->getRequest()->getParam('id');

        // get main pic
        $modelModelInfo = $pic->getPictures($userid, $type, $table, $folder);

        return $modelModelInfo;
    }

	public function crudGallery($data)
	{
		$gallery = $data['gallery'];
		$galleryFetch = $this->fetchAll('gallery_name = "'.$gallery.'" AND talentnum = '.USERID);

		$return = false;
		if($galleryFetch == null){
			$this->create(array('gallery_name'=>$gallery, 'talentnum'=>USERID));
			$return = true;
		}

		return $return;
	}

	public function deleteGallery($data, $name)
	{
		$array = array(); $i=0;
		foreach($data as $val){
			$k = 'gallery_id'.$i;
			if (array_key_exists($k, $data)) {
				$array[$i] = $data[$k];
			}
		$i++;
		}

		foreach($array as $value){

			$pic = new Media_Model_Media();

			$where = 'talentnum = '.USERID.' AND gallery = '.$value;

			$results = $pic->generalFetch($name, $where);

			if($results != null){
                $results = Application_Model_Functions::toArray($results);
				foreach($results as $val){
					$picId = $val->id;
					$pic->generalUpdate($name, array('id'=>$picId, 'gallery'=>'1'));
				}
			}

			$this->delete($value);
		}

	}

	public function deleteGalleryDynamicProfile($data, $profileId)
	{
		$array = array(); $i=0;
		foreach($data as $val){
			$k = 'gallery_id'.$i;
			if (array_key_exists($k, $data)) {
				$array[$i] = $data[$k];
			}
		$i++;
		}

		foreach($array as $value){

			$pic = new Profiles_Model_Profilemedia();

			$results = $pic->fetchAll('profile_id = '.$profileId.' AND gallery = '.$value);

			$result = Application_Model_Functions::toArray($results);

			foreach($result as $val){
				$picId = $val->getProfileMediaId();
				$pic->create(array('profile_media_id'=>$picId, 'gallery'=>'1'));
			}

			$this->delete($value);
		}

	}

}

