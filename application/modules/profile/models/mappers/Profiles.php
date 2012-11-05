<?php

class Profile_Model_Mapper_Profiles extends Application_Model_Mapper_Abstract
{
    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

    /**
     * @param Profile_Model_Profiles $model
     *
     * @return mixed
     */
    public function save(Profile_Model_Profiles $model)
    {
        $profiles_data = array(
            'profile_id'    	 => $model->getProfileId(),
            'talentnum'   		 => $model->getTalentnum(),
            'profile_type_id'    => $model->getProfileTypeId(),
        );

        if (null == $profiles_data['profile_id'])   // insert
        {
            unset($profiles_data['profile_id']);

            $id = $lastInsertId = $this->db->insert('profiles', $profiles_data);

        	return $id;
        }
        else   // update
        {
        	$this->db->update('profiles', $profiles_data, array('talentnum = ?' => $model->getTalentnum()));
        }
    }

    /**
     * @param null $id
     */
    public function delete($id = null)
    {
        $this->db->delete('profiles', array('profile_id = ?' => $id ));
    }

    /**
     * @param int   $where
     * @param null  $order
     * @param null  $limit
     * @param array $fields
     * @param null  $params
     *
     * @return array
     */
    public function fetchAll($where = 1, $order = null, $limit = null, array $fields = null, $params = null)
    {
        $where = (null == $where) ? 1 : $where;

        $offset = $this->getOffset($limit);

        $select = $this->db->select()
                           ->from( array( 'a' => 'profiles' ) , array('a.*', 'a.talentnum as talent') )
                           ->joinLeft( array( 'p' => 'talent_media2_social' ) , 'a.talentnum = p.talentnum ' )
                           ->where($where)
                           ->order($order)
                           ->limit($limit, $offset);

	    if($params != null)
	    {
		    $select->bind($params);
	    }

        if($this->usePaginator == TRUE)
        {
            Application_Model_Paginator::setPagination($select, $limit);
        }

	    $result = $this->db->fetchAll($select);

        return $this->getResultObjects($result);
    }

    /**
     * @param      $from
     * @param      $where
     * @param null $media
     *
     * @return mixed
     */
    public function fetchGeneral($from, $where, $media = null)
    {
    	$media = (null == $media) ? '' : $media;

    	$select = $this->db->select()
    						->from($from)
					    	->where($where);

    	$result = $this->db->fetchAll($select);

    	$userid = Application_Model_Functions::userid();

    	foreach ($result as $v)
    	{
    		if (isset($v->media_path)){
    			$v->full_path = $this->formatMediaPath($userid, $v->media_path, $media);
    		}
    	}

    	return $result;
    }

    /**
     * @param $result
     *
     * @return mixed
     */
    public function fetchMusicinfo($result)
    {
    	foreach ($result as $val)
    	{
    		$val->musictype2 = isset($val->music_type2) ? $this->displayMustype($val->music_type2) : "";
    		$val->musictype3 = isset($val->music_type3) ? $this->displayMustype($val->music_type3) : "";
    		$val->musictype4 = isset($val->music_type4) ? $this->displayMustype($val->music_type4) : "";
    		$val->bandtype   = isset($val->band_type)   ? $this->displayBandype($val->band_type)   : "";
    	}
    	return $result;
    }

    /**
     * @param      $where
     * @param null $order
     * @param null $limit
     *
     * @return mixed
     */
    public function fetchProfiles($where, $order = null, $limit = null)
    {
    	$offset = $this->getOffset($limit);

        $select = $this->db->select()
        					->from('bam.profiles', array('profile_types.*'))
        					->join('bam.profile_types', 'profiles.profile_type_id & profile_types.profile_type_id', array('profile_types.*'))
                            ->order($order)
                            ->where($where)
                            ->limit($limit, $offset);
        $result = $this->db->fetchAll($select);

        return $result;
    }

    /**
     * @param $table
     * @param $data
     */
    public function generalInsert($table, $data)
    {
    	$this->db->insert($table, $data);
    }

    /**
     * @param $table
     * @param $data
     * @param $talentnum
     */
    public function generalUpdate($table, $data, $talentnum)
    {
    	$this->db->update($table, $data, array('type = ?' => $talentnum));
    }

    /**
     * @param $table
     * @param $data
     * @param $talentnum
     */
    public function generalUpdateActing($table, $data, $talentnum)
    {
    	$this->db->update($table, $data, array('talentnum = ?' => $talentnum));
    }


    /**
     * @param null $id
     *
     * @return array
     */
    public function find($id = null)
    {
        $result = $this->db->find($id);

        return $objects = $this->getResultObjects($result);
    }

    /**
     * @param $result
     *
     * @return array
     */
    protected function getResultObjects($result)
    {
        $objects = array();

        foreach($result as $row)
        {
            $object = new Profile_Model_Profiles();

            $object->setProfileId($row->profile_id);
            $object->setTalentnum($row->talentnum);
            $object->setProfileTypeId($row->profile_type_id);

        if($this->useDependents === TRUE)
        {
            $talentci = new Talents_Model_Talentci();
            $object->setTalentci($talentci->fetchAll('talentnum ='.$row->talentnum));
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

    /**
     * @param      $talentnum
     * @param      $dobdd
     * @param      $dobmm
     * @param      $dobyyyy
     * @param null $media
     *
     * @return object
     */
    public function getFeaturedIcon($talentnum, $dobdd, $dobmm, $dobyyyy, $media = null)
    {
    	$type = 3; //featured

    	$select = $this->db->select()
		    	->from('talent_media2_social')
		    	->where('talentnum = '.$talentnum);
    	$result = $this->db->fetchAll($select);

    	$results = array('images'=>$result);
    	$imgPath = array();
    	foreach ($results['images'] as $k=>$val){
    		$val->full_path = $this->formatMediaPath($val->talentnum, $val->media_path, $media = null);
    	}
    	//yeah, it's alive!!
    	if(isset($result[0])){
    		$img = $result[0]->media_path;

    		return ( (object) array_merge(
    				array('images'=>$result),
    				array('age'=>$this->getAge($dobdd, $dobmm, $dobyyyy))
    				)
    			);
    	} else {
    		return $result;
    	}
    }

    /**
     * @param      $talentnum
     * @param      $img
     * @param null $media
     *
     * @return string
     */
    public function formatMediaPath($talentnum, $img, $media = null)
    {
    	$media = (null == $media) ? '' : $media;

    	$number = floor($talentnum/10000);
    	$number = str_pad($number, 3, "0", STR_PAD_LEFT);

    	$mediapath = 'http://download.exploretalent.com/';
    	//$mediapath = CDN_IMAGES;
        $mediapath .= "/".$media;
    	$mediapath .= "/media".$number;
    	$mediapath .= '/'.str_pad($talentnum, 10, '0', STR_PAD_LEFT);
    	$mediapath .= '/'.$img;

    	$jpg = @get_headers($mediapath);

    	if(!isset($jpg)){
    		$mediapath = '/graphics/filler.jpg';
    	}
    	return $mediapath;
    }

    /**
     * @param $bMonth
     * @param $bDay
     * @param $bYear
     *
     * @return mixed
     */
    public function getAge($bMonth,$bDay,$bYear) {
    	list($cYear, $cMonth, $cDay) = explode("-", date("Y-m-d"));
    	return ( ($cMonth >= $bMonth && $cDay >= $bDay) || ($cMonth > $bMonth) ) ? $cYear - $bYear : $cYear - $bYear - 1;
    }

    /**
     * @param $status
     *
     * @return string
     */
    public function displayMustype($status)
    {
    	$to_return = '';

    	if($status == 'xx') {$to_return =  "0";}
    	elseif($status == '0'){ $to_return =  "0"; }
    	elseif($status == '1'){ $to_return =  "DJ"; }
    	elseif($status == '2'){ $to_return =  "Singer"; }
    	elseif($status == '3'){ $to_return =  "Song Writer"; }
    	elseif($status == '4'){ $to_return =  "Teacher"; }
    	elseif($status == '5'){ $to_return =  "Player"; }
    	elseif($status == '6'){ $to_return =  "Lyricist"; }
    	elseif($status == '7'){ $to_return =  "Sound Man"; }
    	elseif($status == '8'){ $to_return =  "Composer"; }
    	elseif($status == '9'){ $to_return =  "Conductor"; }

    	return $to_return;
    }

    /**
     * @param $status
     *
     * @return string
     */
    public function displayBandype($status)
    {
    	$to_return = '';

    	if($status == 'xx'){ $to_return =  "0"; }
    	elseif($status == '0'){ $to_return = "Band"; }
    	elseif($status == '1'){ $to_return = "Orchestra"; }

    	return $to_return;
    }

	/*to delete - used for data migration*/
	public function migrateFeatureTalent($where = 1, $order = null, $limit = null)
    {
        $where = (null == $where) ? 1 : $where;

        $offset = $this->getOffset($limit);

        $select = $this->db->select()
                           ->from('talentrecurring_ft')
                           ->where($where)
                           ->order($order)
                           ->limit($limit, $offset);

		$result = $this->db->fetchAll($select);

        return $result;
    }

}

