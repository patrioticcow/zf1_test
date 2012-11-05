<?php

class Profile_Model_Mapper_Profileviews extends Application_Model_Mapper_Abstract
{

    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

    public function save(Application_Model_Interface $model)
    {
        $data = array(
            'id'    => $model->getId(),
            'viewer'    => $model->getViewer(),
            'viewed'    => $model->getViewed(),
            'view_time'    => $model->getViewTime(),
        );
        
        foreach($data as $key=>$val)
        {
        	if(null == $data[$key])
        	{
        		unset($data[$key]);
        	}
        }
        
        if($model->getId() == null)
        {
            $this->db->insert('profile_views', $data);
        }
        else   // update
        {
        	$this->db->update('profile_views', $data, array('id = ?' => $data['id']));
        
           return $data['id'];
        }
    }

    public function delete($id = null)
    {
        $this->db->delete('profile_views', array( 'id = ?' => $id ));
    }

    public function fetchAll($where = 1, $order = null, $limit = null, array $fields = null)
    {
        $where = (null == $where) ? 1 : $where;
        
        $offset = $this->getOffset($limit);
        
        $fields = (!isset($fields)) ? '*' : $fields;
        
        $select = $this->db->select()
                           ->from("profile_views", $fields)
                           ->where($where)
                           ->order($order)
                           ->limit($limit, $offset);
        
        if($this->usePaginator == FALSE)
        {
            try {
                $result = $this->db->fetchAll($select);
            } catch(Exception $e) {
                print($e->getMessage()." in ".__METHOD__); exit;
            }
        }
        else
        {
            $result = Application_Model_Paginator::setPagination($select, $limit);
        }
        
        return $this->getResultObjects($result);
    }

    public function find($id = null)
    {
    }

    protected function getResultObjects($result)
    {
        $objects = array();
        
        foreach($result as $row)
        {
            $object = new Profile_Model_Profileviews();
        
        $object->setProperty($row);
        
        if($this->useDependents === TRUE)
        {
            //$model = new Profile_Model_Profileviews();
        
        	 //$object->setDependentTable($model->fetchAll('id = '.$row->id));
        }
        
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

