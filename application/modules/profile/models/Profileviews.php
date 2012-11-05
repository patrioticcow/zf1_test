<?php

class Profile_Model_Profileviews extends Application_Model_Proxy
{

    protected static $_mapper = null;

    protected $_id = null;

    protected $_viewer = null;

    protected $_viewed = null;

    protected $_view_time = null;

    protected $_name = null;

    protected $_image = null;



    /**
     * association property for dependentTable or comment out
     */
    protected $_dependent_table = null;

    public function __construct()
    {
        static::$_mapper = new Profile_Model_Mapper_Profileviews();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();

            $data = $front->getRequest()->getParams();
        }

        $this->_id = !empty($data["id"]) ? $data["id"] : null;

        $this->_viewer = !empty($data["viewer"]) ? $data["viewer"] : null;

        $this->_viewed = !empty($data["viewed"]) ? $data["viewed"] : null;

        $this->_view_time = !empty($data["view_time"]) ? $data["view_time"] : null;

        $id = static::$_mapper->save($this);

        return $id;
    }

    public function parseData($flag, $flag2 = null)
    {
        if($flag == 'viewed'){ $where = 'viewer = '.USERID; }

        if($flag == 'views'){ $where = 'viewed = '.USERID; }

        $obj = $this->fetchAll($where, 'view_time DESC');

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
                if($flag == 'viewed'){ $talentnum = $val->getViewed(); }
                if($flag == 'views' ){ $talentnum = $val->getViewer(); }

                $formatDate = Application_Model_Functions::getTimeDuration($val->getViewTime());
                $name       = Application_Model_Functions::getName($talentnum);

                $imageModel = new Profile_Model_Messages();


	            if($flag2 == 1){
		            $image  = '';
	            } else {
		            $image  = $imageModel->getPrimaryImage($talentnum);
	            }

                $val->setViewTime($formatDate);
                $val->setName($name);
                $val->setImage($image);
            }


        return $data;
    }

    public function profileViewes()
    {
        $create = '';

        $front = Zend_Controller_Front::getInstance();

        $id = $front->getRequest()->getParam('id');

        if ($id != null && is_numeric($id) && $id != '5274354' && $id != USERID) {

            $existingId = $this->fetchAll('viewed = '.$id);

            if($existingId == null){
                $create = $this->create( array(
                    'viewer'=>USERID,
                    'viewed'=>$id,
                    'view_time'=>time())
                );
            }

        }

        return $create;
    }


}

