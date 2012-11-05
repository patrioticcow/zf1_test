<?php

class Profile_Model_Mapper_Messages extends Application_Model_Mapper_Abstract
{

    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

    public function save(Profile_Model_Messages $model)
    {
        $data = array(
            'id'    => $model->getId(),
            'from'    => $model->getFrom(),
            'too'    => $model->getToo(),
            'message'    => $model->getMessage(),
            'sent_date'    => $model->getSentDate(),
        );

        foreach($data as $key=>$val)
        {
            if(null == $data[$key])
            {
            unset($data[$key]);
            }
        }
        try
        {
            $this->db->insert('messages', $data);
            
            if(isset($data['id'])) return $data['id'];
        }
        catch(Exception $e)   // update
        {
            $this->db->update('messages', $data, array('id = ?' => $data['id']));
        
            return $data['id'];
        }

    }

    public function delete($id = null)
    {
        $this->db->delete('messages', array(
                                    'id = ?' => $id
                                ));
    }

    public function fetchAll($where = 1, $order = null, $limit = null)
    {
        $where = (null == $where) ? 1 : $where;
        
        $offset = $this->getOffset($limit);
        
        $select = $this->db->select()
                           ->from('messages')
                           ->order($order)
                           ->where($where)
                           ->limit($limit, $offset);
        //echo $select; exit;
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
        $result = $this->db->find($id);
        
        return $objects = $this->getResultObjects($result);
    }

    protected function getResultObjects($result)
    {
        $objects = array();
        
        foreach($result as $row)
        {
            $object = new Profile_Model_Messages();

            $object->setId($row->id);
            $object->setFrom($row->from);
            $object->setToo($row->too);
            $object->setMessage($row->message);
            $object->setSentDate($row->sent_date);
        
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

