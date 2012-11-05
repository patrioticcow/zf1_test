<?php

class Session_Model_Mapper_Session extends Application_Model_Mapper_Abstract
{

    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb("db");
    }

    public function save(Application_Model_Interface $model)
    {
        $data = array(
            'session_id'    => $model->getSessionId(),
            'save_path'    => $model->getSavePath(),
            'name'    => $model->getName(),
            'modified'    => $model->getModified(),
            'lifetime'    => $model->getLifetime(),
            'session_data'    => $model->getSessionData(),
        );
        
        foreach($data as $key=>$val)
        {
        	if(null == $data[$key])
        	{
        		unset($data[$key]);
        	}
        }
        
        if($model->getSessionId() == null)
        {
            $this->db->insert('session', $data);
        }
        else   // update
        {
        	$this->db->update('session', $data, array(' = ?' => $data['session_id']));
        
           return $data['session_id'];
        }
    }

    public function delete($id = null)
    {
        $where = $this->db->getAdapter()->quoteInto('session_id = ?', $id);
        
        $this->db->delete('session', $where);
    }

    public function fetchAll($where = 1, $order = null, $limit = null, array $fields = null)
    {
        $where = (null == $where) ? 1 : $where;
        
        $offset = $this->getOffset($limit);
        
        $fields = (!isset($fields)) ? '*' : $fields;
        
        $select = $this->db->select()
                           ->from("session", $fields)
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
            $object = new Session_Model_Session();
        
        $object->setProperty($row);
        
        if($this->useDependents === TRUE)
        {
            //$model = new Session_Model_Session();
        
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

