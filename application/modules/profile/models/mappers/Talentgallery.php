<?php

class Profile_Model_Mapper_Talentgallery extends Application_Model_Mapper_Abstract
{

    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

    public function save(Profile_Model_Talentgallery $model)
    {
        $data = array(
            'gallery_id'    => $model->getGalleryId(),
            'gallery_name'	=> $model->getGalleryName(),
            'talentnum'    	=> $model->getTalentnum(),
        );

        $data = $this->cleanArray($data);

        if($model->getId() == null)
        {
            $this->db->insert('talent_gallery', $data);
            if(isset($data['gallery_id'])) return $data['gallery_id'];
        }
        else   // update
        {
            $this->db->update('talent_gallery', $data, array('gallery_id = ?' => $data['gallery_id']));

            return $data['gallery_id'];
        }

    }

    public function delete($id = null)
    {
    	$this->db->delete('talent_gallery', array('gallery_id = ?' => $id));
    }

    public function fetchAll($where = 1, $order = null, $limit = null, array $fields = null, array $group = null, $params = null)
    {
        $where = (null == $where) ? 1 : $where;

        $offset = $this->getOffset($limit);

        $select = $this->db->select()
                           ->from('talent_gallery')
                           ->order($order)
                           ->where($where)
                           ->limit($limit, $offset);

        if ($group != null){
            $select->group($group);
        }
	    if($params != null){
		    $select->bind($params);
	    }

        $result = $this->db->fetchAll($select);

        if($this->usePaginator == TRUE)
        {
            Application_Model_Paginator::setPagination($select, $limit);
        }

        return $this->getResultObjects($result);
    }

    public function find($id = null)
    {
        $result = $this->db->find($id);

        return $objects = $this->getResultObjects($result);
    }

    protected function getResultObjects($result)
    {
        $objects = array();

        foreach($result as $row)
        {
            $object = new Profile_Model_Talentgallery();

            $object->setGalleryId($row->gallery_id);
            $object->setGalleryName($row->gallery_name);
            $object->setTalentnum($row->talentnum);

        $objects []= $object;
        }

        if(isset($objects[1]))
        {
            return $objects;
        }
        elseif(isset($objects[0]))
        {
            return $objects[0];
        }
    }

}

