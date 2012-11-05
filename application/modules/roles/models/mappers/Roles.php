<?php

class Roles_Model_Mapper_Roles extends Application_Model_Mapper_Abstract
{

    public function __construct()
    {
        //$this->setDbTable('Roles_Model_DbTable_Roles');
        $this->db = Application_Model_ServiceLocator::getDb("db");
    }

    public function save(Roles_Model_Roles $model)
    {
        $roles_data = array(
            'role_id'    => $model->getRoleId(),
            'status'    => $model->getStatus(),
            'casting_id'    => $model->getCastingId(),
            'number_of_people'    => $model->getNumberOfPeople(),
            'name'    => $model->getName(),
            'gender_male'    => $model->getGenderMale(),
            'gender_female'    => $model->getGenderFemale(),
            'age_min'    => $model->getAgeMin(),
            'age_max'    => $model->getAgeMax(),
            'ethnicity_african'    => $model->getEthnicityAfrican(),
            'ethnicity_african_am'    => $model->getEthnicityAfricanAm(),
            'ethnicity_asian'    => $model->getEthnicityAsian(),
            'ethnicity_caribbian'    => $model->getEthnicityCaribbian(),
            'ethnicity_caucasian'    => $model->getEthnicityCaucasian(),
            'ethnicity_hispanic'    => $model->getEthnicityHispanic(),
            'ethnicity_mediterranean'    => $model->getEthnicityMediterranean(),
            'ethnicity_middle_est'    => $model->getEthnicityMiddleEst(),
            'ethnicity_mixed'    => $model->getEthnicityMixed(),
            'ethnicity_native_am'    => $model->getEthnicityNativeAm(),
            'ethnicity_any'    => $model->getEthnicityAny(),
            'height_min'    => $model->getHeightMin(),
            'height_max'    => $model->getHeightMax(),
            'hair_auburn'    => $model->getHairAuburn(),
            'hair_black'    => $model->getHairBlack(),
            'hair_blonde'    => $model->getHairBlonde(),
            'hair_brown'    => $model->getHairBrown(),
            'hair_chestnut'    => $model->getHairChestnut(),
            'hair_dark_brown'    => $model->getHairDarkBrown(),
            'hair_grey'    => $model->getHairGrey(),
            'hair_red'    => $model->getHairRed(),
            'hair_white'    => $model->getHairWhite(),
            'hair_salt_paper'    => $model->getHairSaltPaper(),
            'hair_any'    => $model->getHairAny(),
            'waist_min'    => $model->getWaistMin(),
            'waist_max'    => $model->getWaistMax(),
            'pants_min'    => $model->getPantsMin(),
            'pants_max'    => $model->getPantsMax(),
            'hips_min'    => $model->getHipsMin(),
            'hips_max'    => $model->getHipsMax(),
            'inseam_min'    => $model->getInseamMin(),
            'inseam_max'    => $model->getInseamMax(),
            'bust_min'    => $model->getBustMin(),
            'bust_max'    => $model->getBustMax(),
            'chest_min'    => $model->getChestMin(),
            'chest_max'    => $model->getChestMax(),
            'cup_min'    => $model->getCupMin(),
            'cup_max'    => $model->getCupMax(),
            'sleeve_min'    => $model->getSleeveMin(),
            'sleeve_max'    => $model->getSleeveMax(),
            'shirt_min'    => $model->getShirtMin(),
            'shirt_max'    => $model->getShirtMax(),
            'shoe_min'    => $model->getShoeMin(),
            'shoe_max'    => $model->getShoeMax(),
            'dress_min'    => $model->getDressMin(),
            'dress_max'    => $model->getDressMax(),
            'hairstyle_afro'    => $model->getHairstyleAfro(),
            'hairstyle_bald'    => $model->getHairstyleBald(),
            'hairstyle_buzz'    => $model->getHairstyleBuzz(),
            'hairstyle_cons'    => $model->getHairstyleCons(),
            'hairstyle_dread'    => $model->getHairstyleDread(),
            'hairstyle_long'    => $model->getHairstyleLong(),
            'hairstyle_medium'    => $model->getHairstyleMedium(),
            'hairstyle_shaved'    => $model->getHairstyleShaved(),
            'hairstyle_short'    => $model->getHairstyleShort(),
            'hairstyle_any'    => $model->getHairstyleAny(),
            'eye_blue'    => $model->getEyeBlue(),
            'eye_b_g'    => $model->getEyeBG(),
            'eye_brown'    => $model->getEyeBrown(),
            'eye_green'    => $model->getEyeGreen(),
            'eye_grey'    => $model->getEyeGrey(),
            'eye_g_b'    => $model->getEyeGB(),
            'eye_g_g'    => $model->getEyeGG(),
            'eye_hazel'    => $model->getEyeHazel(),
            'eye_any'    => $model->getEyeAny(),
            'alcohol'    => $model->getAlcohol(),
            'tobacco'    => $model->getTobacco(),
            'built_medium'    => $model->getBuiltMedium(),
            'built_athletic'    => $model->getBuiltAthletic(),
            'built_bb'    => $model->getBuiltBb(),
            'built_xlarge'    => $model->getBuiltXlarge(),
            'built_large'    => $model->getBuiltLarge(),
            'built_petite'    => $model->getBuiltPetite(),
            'built_thin'    => $model->getBuiltThin(),
            'built_lm'    => $model->getBuiltLm(),
            'built_any'    => $model->getBuiltAny(),
            'des'    => $model->getDes(),
            'display_full'    => $model->getDisplayFull(),
            'union_sag'    => $model->getUnionSag(),
            'union_aftra'    => $model->getUnionAftra(),
            'ethnicity_x_asian'    => $model->getEthnicityXAsian(),
            'ethnicity_x_black'    => $model->getEthnicityXBlack(),
            'ethnicity_x_hispanic'    => $model->getEthnicityXHispanic(),
            'ethnicity_x_white'    => $model->getEthnicityXWhite(),
        );

        if (null == $roles_data['role_id'])   // insert
        {
            unset($roles_data['role_id']);

            // insert the main entity data and get the last insert id
            $id = $lastInsertId = $this->db->insert($roles_data);

            // return lastInsertId (id) for controller use
        	return $id;
        }
        else   // update
        {
        	// update $this entity data
        	$this->db->update($roles_data, array('role_id = ?' => $model->getRoleId()));
        }
    }

    public function delete($id = null)
    {
        $where = $this->db->getAdapter()->quoteInto('role_id = ?', $id);

        $this->db->delete($where);
    }

    public function fetchAll($where = 1, $order = null, $limit = null)
    {
    	$where = (null == $where) ? 1 : $where;

        $offset = $this->getOffset($limit);

        $select = $this->db->select()
                           ->from('bam.roles')
                           ->order($order)
                           ->where($where)
                           ->limit($limit, $offset);

        if($this->usePaginator == TRUE)
        {
            Application_Model_Paginator::setPagination($select, $limit);
        }

		$result = $this->db->fetchAll($select);

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
            $object = new Roles_Model_Roles();

            $object->setRoleId($row->role_id);
            $object->setStatus($row->status);
            $object->setCastingId($row->casting_id);
            $object->setNumberOfPeople($row->number_of_people);
            $object->setName($row->name);
            $object->setGenderMale($row->gender_male);
            $object->setGenderFemale($row->gender_female);
            $object->setAgeMin($row->age_min);
            $object->setAgeMax($row->age_max);
            $object->setEthnicityAfrican($row->ethnicity_african);
            $object->setEthnicityAfricanAm($row->ethnicity_african_am);
            $object->setEthnicityAsian($row->ethnicity_asian);
            $object->setEthnicityCaribbian($row->ethnicity_caribbian);
            $object->setEthnicityCaucasian($row->ethnicity_caucasian);
            $object->setEthnicityHispanic($row->ethnicity_hispanic);
            $object->setEthnicityMediterranean($row->ethnicity_mediterranean);
            $object->setEthnicityMiddleEst($row->ethnicity_middle_est);
            $object->setEthnicityMixed($row->ethnicity_mixed);
            $object->setEthnicityNativeAm($row->ethnicity_native_am);
            $object->setEthnicityAny($row->ethnicity_any);
            $object->setHeightMin($row->height_min);
            $object->setHeightMax($row->height_max);
            $object->setHairAuburn($row->hair_auburn);
            $object->setHairBlack($row->hair_black);
            $object->setHairBlonde($row->hair_blonde);
            $object->setHairBrown($row->hair_brown);
            $object->setHairChestnut($row->hair_chestnut);
            $object->setHairDarkBrown($row->hair_dark_brown);
            $object->setHairGrey($row->hair_grey);
            $object->setHairRed($row->hair_red);
            $object->setHairWhite($row->hair_white);
            $object->setHairSaltPaper($row->hair_salt_paper);
            $object->setHairAny($row->hair_any);
            $object->setWaistMin($row->waist_min);
            $object->setWaistMax($row->waist_max);
            $object->setPantsMin($row->pants_min);
            $object->setPantsMax($row->pants_max);
            $object->setHipsMin($row->hips_min);
            $object->setHipsMax($row->hips_max);
            $object->setInseamMin($row->inseam_min);
            $object->setInseamMax($row->inseam_max);
            $object->setBustMin($row->bust_min);
            $object->setBustMax($row->bust_max);
            $object->setChestMin($row->chest_min);
            $object->setChestMax($row->chest_max);
            $object->setCupMin($row->cup_min);
            $object->setCupMax($row->cup_max);
            $object->setSleeveMin($row->sleeve_min);
            $object->setSleeveMax($row->sleeve_max);
            $object->setShirtMin($row->shirt_min);
            $object->setShirtMax($row->shirt_max);
            $object->setShoeMin($row->shoe_min);
            $object->setShoeMax($row->shoe_max);
            $object->setDressMin($row->dress_min);
            $object->setDressMax($row->dress_max);
            $object->setHairstyleAfro($row->hairstyle_afro);
            $object->setHairstyleBald($row->hairstyle_bald);
            $object->setHairstyleBuzz($row->hairstyle_buzz);
            $object->setHairstyleCons($row->hairstyle_cons);
            $object->setHairstyleDread($row->hairstyle_dread);
            $object->setHairstyleLong($row->hairstyle_long);
            $object->setHairstyleMedium($row->hairstyle_medium);
            $object->setHairstyleShaved($row->hairstyle_shaved);
            $object->setHairstyleShort($row->hairstyle_short);
            $object->setHairstyleAny($row->hairstyle_any);
            $object->setEyeBlue($row->eye_blue);
            $object->setEyeBG($row->eye_b_g);
            $object->setEyeBrown($row->eye_brown);
            $object->setEyeGreen($row->eye_green);
            $object->setEyeGrey($row->eye_grey);
            $object->setEyeGB($row->eye_g_b);
            $object->setEyeGG($row->eye_g_g);
            $object->setEyeHazel($row->eye_hazel);
            $object->setEyeAny($row->eye_any);
            $object->setAlcohol($row->alcohol);
            $object->setTobacco($row->tobacco);
            $object->setBuiltMedium($row->built_medium);
            $object->setBuiltAthletic($row->built_athletic);
            $object->setBuiltBb($row->built_bb);
            $object->setBuiltXlarge($row->built_xlarge);
            $object->setBuiltLarge($row->built_large);
            $object->setBuiltPetite($row->built_petite);
            $object->setBuiltThin($row->built_thin);
            $object->setBuiltLm($row->built_lm);
            $object->setBuiltAny($row->built_any);
            $object->setDes($row->des);
            $object->setDisplayFull($row->display_full);
            $object->setUnionSag($row->union_sag);
            $object->setUnionAftra($row->union_aftra);
            $object->setEthnicityXAsian($row->ethnicity_x_asian);
            $object->setEthnicityXBlack($row->ethnicity_x_black);
            $object->setEthnicityXHispanic($row->ethnicity_x_hispanic);
            $object->setEthnicityXWhite($row->ethnicity_x_white);

            if($this->useDependents === TRUE)
            {
                //$dependentTableModel = new Roles_Model_DependentModelName(); // dependent table goes here
                //$object->setDependentTable($dependentTableModel->fetchAll('user_id ='.$row->user_id));
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

