<?php

class Profile_Model_Messages extends Application_Model_Proxy
{
    protected static $_mapper = null;

    protected $_id = null;
    protected $_from = null;
    protected $_too = null;
    protected $_message = null;
    protected $_sent_date = null;
    protected $_name_from = null;
    protected $_name_to = null;
    protected $_image_from = null;
    protected $_image_to = null;

    //protected $_dependent_table = null;

    public function __construct()
    {
        self::$_mapper = new Profile_Model_Mapper_Messages();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();
            $data = $front->getRequest()->getParams();
        }

        $this->_id = !empty($data["id"]) ? $data["id"] : null;
        $this->_from = !empty($data["from"]) ? $data["from"] : null;
        $this->_too = !empty($data["too"]) ? $data["too"] : null;
        $this->_message = !empty($data["message"]) ? $data["message"] : null;
        $this->_sent_date = !empty($data["sent_date"]) ? $data["sent_date"] : null;

        $id = self::$_mapper->save($this);

        return $id;
    }

    public function parseData()
    {
        $obj = $this->fetchAll('too = '.USERID, 'sent_date DESC', null);

        if($obj == null){
            return $obj;
        }

        if(!is_array($obj)){
            $data[0] = $obj;
        } else {
            $data = $obj;
        }

        foreach( $data as $val)
        {
                $cleanMessage   = Wallmessages_Model_WallAbstract::cleanStr($val->getMessage());
                $message        = Wallmessages_Model_WallAbstract::replaceStr($cleanMessage);
                $formatDate     = Application_Model_Functions::getTimeDuration($val->getSentDate());

                $nameFrom       = Application_Model_Functions::getName($val->getFrom());
                $nameTo         = 'not used'; //Application_Model_Functions::getName($val->getToo());
                $imageFrom      = $this->getPrimaryImage($val->getFrom());
                $imageTo        = 'not used'; //$this->getPrimaryImage($val->getToo());

                $val->setMessage($message);
                $val->setSentDate($formatDate);

                $val->setNameFrom($nameFrom);
                $val->setNameTo($nameTo);
                $val->setImageFrom($imageFrom);
                $val->setImageTo($imageTo);
        }

        return $data;
    }

    public function getPrimaryImage($id)
    {
	    /*  old way with using the database
        $pic = new Media_Model_Media();

        $image = '';

        $modelModelInfo = $pic->getPictures($id, null, 'talent_media2_social', 'media_social');
        $xx = Application_Model_Functions::arrayObj($modelModelInfo);

        foreach($xx as $key => $val){
            if($val != null){
                $image[] = $val->path;
            }

        }

        if(isset($image[0]) && $image[0] != ''){
            return $image[0];
        }
	    */
	    return Media_Model_MediaAbstract::getSocialPic($id);
    }
}