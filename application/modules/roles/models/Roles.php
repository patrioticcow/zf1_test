<?php

class Roles_Model_Roles extends Application_Model_Proxy
{
    protected static $_mapper;

    protected $_role_id = null;
    protected $_status = null;
    protected $_casting_id = null;
    protected $_number_of_people = null;
    protected $_name = null;
    protected $_gender_male = null;
    protected $_gender_female = null;
    protected $_age_min = null;
    protected $_age_max = null;
    protected $_ethnicity_african = null;
    protected $_ethnicity_african_am = null;
    protected $_ethnicity_asian = null;
    protected $_ethnicity_caribbian = null;
    protected $_ethnicity_caucasian = null;
    protected $_ethnicity_hispanic = null;
    protected $_ethnicity_mediterranean = null;
    protected $_ethnicity_middle_est = null;
    protected $_ethnicity_mixed = null;
    protected $_ethnicity_native_am = null;
    protected $_ethnicity_any = null;
    protected $_height_min = null;
    protected $_height_max = null;
    protected $_hair_auburn = null;
    protected $_hair_black = null;
    protected $_hair_blonde = null;
    protected $_hair_brown = null;
    protected $_hair_chestnut = null;
    protected $_hair_dark_brown = null;
    protected $_hair_grey = null;
    protected $_hair_red = null;
    protected $_hair_white = null;
    protected $_hair_salt_paper = null;
    protected $_hair_any = null;
    protected $_waist_min = null;
    protected $_waist_max = null;
    protected $_pants_min = null;
    protected $_pants_max = null;
    protected $_hips_min = null;
    protected $_hips_max = null;
    protected $_inseam_min = null;
    protected $_inseam_max = null;
    protected $_bust_min = null;
    protected $_bust_max = null;
    protected $_chest_min = null;
    protected $_chest_max = null;
    protected $_cup_min = null;
    protected $_cup_max = null;
    protected $_sleeve_min = null;
    protected $_sleeve_max = null;
    protected $_shirt_min = null;
    protected $_shirt_max = null;
    protected $_shoe_min = null;
    protected $_shoe_max = null;
    protected $_dress_min = null;
    protected $_dress_max = null;
    protected $_hairstyle_afro = null;
    protected $_hairstyle_bald = null;
    protected $_hairstyle_buzz = null;
    protected $_hairstyle_cons = null;
    protected $_hairstyle_dread = null;
    protected $_hairstyle_long = null;
    protected $_hairstyle_medium = null;
    protected $_hairstyle_shaved = null;
    protected $_hairstyle_short = null;
    protected $_hairstyle_any = null;
    protected $_eye_blue = null;
    protected $_eye_b_g = null;
    protected $_eye_brown = null;
    protected $_eye_green = null;
    protected $_eye_grey = null;
    protected $_eye_g_b = null;
    protected $_eye_g_g = null;
    protected $_eye_hazel = null;
    protected $_eye_any = null;
    protected $_alcohol = null;
    protected $_tobacco = null;
    protected $_built_medium = null;
    protected $_built_athletic = null;
    protected $_built_bb = null;
    protected $_built_xlarge = null;
    protected $_built_large = null;
    protected $_built_petite = null;
    protected $_built_thin = null;
    protected $_built_lm = null;
    protected $_built_any = null;
    protected $_des = null;
    protected $_display_full = null;
    protected $_union_sag = null;
    protected $_union_aftra = null;
    protected $_ethnicity_x_asian = null;
    protected $_ethnicity_x_black = null;
    protected $_ethnicity_x_hispanic = null;
    protected $_ethnicity_x_white = null;

    public $_market = null;
    public $_snr_email = null;

    public $_form_name = null;
    public $_form_fmarket = null;
    public $_form_snr_email = null;

    /**
     * association property for dependentTable or comment out
     */
    protected $_dependent_table = null;

    public function __construct()
    {
        static::$_mapper = new Roles_Model_Mapper_Roles();
    }

    public function create($data = null)
    {
        if($data == null)
        {
            $front = Zend_Controller_Front::getInstance();

            $data = $front->getRequest()->getParams();
        }

        $this->_role_id = !empty($data["role_id"]) ? $data["role_id"] : null;
        $this->_status = !empty($data["status"]) ? $data["status"] : null;
        $this->_casting_id = !empty($data["casting_id"]) ? $data["casting_id"] : null;
        $this->_number_of_people = !empty($data["number_of_people"]) ? $data["number_of_people"] : null;
        $this->_name = !empty($data["name"]) ? $data["name"] : null;
        $this->_gender_male = !empty($data["gender_male"]) ? $data["gender_male"] : null;
        $this->_gender_female = !empty($data["gender_female"]) ? $data["gender_female"] : null;
        $this->_age_min = !empty($data["age_min"]) ? $data["age_min"] : null;
        $this->_age_max = !empty($data["age_max"]) ? $data["age_max"] : null;
        $this->_ethnicity_african = !empty($data["ethnicity_african"]) ? $data["ethnicity_african"] : null;
        $this->_ethnicity_african_am = !empty($data["ethnicity_african_am"]) ? $data["ethnicity_african_am"] : null;
        $this->_ethnicity_asian = !empty($data["ethnicity_asian"]) ? $data["ethnicity_asian"] : null;
        $this->_ethnicity_caribbian = !empty($data["ethnicity_caribbian"]) ? $data["ethnicity_caribbian"] : null;
        $this->_ethnicity_caucasian = !empty($data["ethnicity_caucasian"]) ? $data["ethnicity_caucasian"] : null;
        $this->_ethnicity_hispanic = !empty($data["ethnicity_hispanic"]) ? $data["ethnicity_hispanic"] : null;
        $this->_ethnicity_mediterranean = !empty($data["ethnicity_mediterranean"]) ? $data["ethnicity_mediterranean"] : null;
        $this->_ethnicity_middle_est = !empty($data["ethnicity_middle_est"]) ? $data["ethnicity_middle_est"] : null;
        $this->_ethnicity_mixed = !empty($data["ethnicity_mixed"]) ? $data["ethnicity_mixed"] : null;
        $this->_ethnicity_native_am = !empty($data["ethnicity_native_am"]) ? $data["ethnicity_native_am"] : null;
        $this->_ethnicity_any = !empty($data["ethnicity_any"]) ? $data["ethnicity_any"] : null;
        $this->_height_min = !empty($data["height_min"]) ? $data["height_min"] : null;
        $this->_height_max = !empty($data["height_max"]) ? $data["height_max"] : null;
        $this->_hair_auburn = !empty($data["hair_auburn"]) ? $data["hair_auburn"] : null;
        $this->_hair_black = !empty($data["hair_black"]) ? $data["hair_black"] : null;
        $this->_hair_blonde = !empty($data["hair_blonde"]) ? $data["hair_blonde"] : null;
        $this->_hair_brown = !empty($data["hair_brown"]) ? $data["hair_brown"] : null;
        $this->_hair_chestnut = !empty($data["hair_chestnut"]) ? $data["hair_chestnut"] : null;
        $this->_hair_dark_brown = !empty($data["hair_dark_brown"]) ? $data["hair_dark_brown"] : null;
        $this->_hair_grey = !empty($data["hair_grey"]) ? $data["hair_grey"] : null;
        $this->_hair_red = !empty($data["hair_red"]) ? $data["hair_red"] : null;
        $this->_hair_white = !empty($data["hair_white"]) ? $data["hair_white"] : null;
        $this->_hair_salt_paper = !empty($data["hair_salt_paper"]) ? $data["hair_salt_paper"] : null;
        $this->_hair_any = !empty($data["hair_any"]) ? $data["hair_any"] : null;
        $this->_waist_min = !empty($data["waist_min"]) ? $data["waist_min"] : null;
        $this->_waist_max = !empty($data["waist_max"]) ? $data["waist_max"] : null;
        $this->_pants_min = !empty($data["pants_min"]) ? $data["pants_min"] : null;
        $this->_pants_max = !empty($data["pants_max"]) ? $data["pants_max"] : null;
        $this->_hips_min = !empty($data["hips_min"]) ? $data["hips_min"] : null;
        $this->_hips_max = !empty($data["hips_max"]) ? $data["hips_max"] : null;
        $this->_inseam_min = !empty($data["inseam_min"]) ? $data["inseam_min"] : null;
        $this->_inseam_max = !empty($data["inseam_max"]) ? $data["inseam_max"] : null;
        $this->_bust_min = !empty($data["bust_min"]) ? $data["bust_min"] : null;
        $this->_bust_max = !empty($data["bust_max"]) ? $data["bust_max"] : null;
        $this->_chest_min = !empty($data["chest_min"]) ? $data["chest_min"] : null;
        $this->_chest_max = !empty($data["chest_max"]) ? $data["chest_max"] : null;
        $this->_cup_min = !empty($data["cup_min"]) ? $data["cup_min"] : null;
        $this->_cup_max = !empty($data["cup_max"]) ? $data["cup_max"] : null;
        $this->_sleeve_min = !empty($data["sleeve_min"]) ? $data["sleeve_min"] : null;
        $this->_sleeve_max = !empty($data["sleeve_max"]) ? $data["sleeve_max"] : null;
        $this->_shirt_min = !empty($data["shirt_min"]) ? $data["shirt_min"] : null;
        $this->_shirt_max = !empty($data["shirt_max"]) ? $data["shirt_max"] : null;
        $this->_shoe_min = !empty($data["shoe_min"]) ? $data["shoe_min"] : null;
        $this->_shoe_max = !empty($data["shoe_max"]) ? $data["shoe_max"] : null;
        $this->_dress_min = !empty($data["dress_min"]) ? $data["dress_min"] : null;
        $this->_dress_max = !empty($data["dress_max"]) ? $data["dress_max"] : null;
        $this->_hairstyle_afro = !empty($data["hairstyle_afro"]) ? $data["hairstyle_afro"] : null;
        $this->_hairstyle_bald = !empty($data["hairstyle_bald"]) ? $data["hairstyle_bald"] : null;
        $this->_hairstyle_buzz = !empty($data["hairstyle_buzz"]) ? $data["hairstyle_buzz"] : null;
        $this->_hairstyle_cons = !empty($data["hairstyle_cons"]) ? $data["hairstyle_cons"] : null;
        $this->_hairstyle_dread = !empty($data["hairstyle_dread"]) ? $data["hairstyle_dread"] : null;
        $this->_hairstyle_long = !empty($data["hairstyle_long"]) ? $data["hairstyle_long"] : null;
        $this->_hairstyle_medium = !empty($data["hairstyle_medium"]) ? $data["hairstyle_medium"] : null;
        $this->_hairstyle_shaved = !empty($data["hairstyle_shaved"]) ? $data["hairstyle_shaved"] : null;
        $this->_hairstyle_short = !empty($data["hairstyle_short"]) ? $data["hairstyle_short"] : null;
        $this->_hairstyle_any = !empty($data["hairstyle_any"]) ? $data["hairstyle_any"] : null;
        $this->_eye_blue = !empty($data["eye_blue"]) ? $data["eye_blue"] : null;
        $this->_eye_b_g = !empty($data["eye_b_g"]) ? $data["eye_b_g"] : null;
        $this->_eye_brown = !empty($data["eye_brown"]) ? $data["eye_brown"] : null;
        $this->_eye_green = !empty($data["eye_green"]) ? $data["eye_green"] : null;
        $this->_eye_grey = !empty($data["eye_grey"]) ? $data["eye_grey"] : null;
        $this->_eye_g_b = !empty($data["eye_g_b"]) ? $data["eye_g_b"] : null;
        $this->_eye_g_g = !empty($data["eye_g_g"]) ? $data["eye_g_g"] : null;
        $this->_eye_hazel = !empty($data["eye_hazel"]) ? $data["eye_hazel"] : null;
        $this->_eye_any = !empty($data["eye_any"]) ? $data["eye_any"] : null;
        $this->_alcohol = !empty($data["alcohol"]) ? $data["alcohol"] : null;
        $this->_tobacco = !empty($data["tobacco"]) ? $data["tobacco"] : null;
        $this->_built_medium = !empty($data["built_medium"]) ? $data["built_medium"] : null;
        $this->_built_athletic = !empty($data["built_athletic"]) ? $data["built_athletic"] : null;
        $this->_built_bb = !empty($data["built_bb"]) ? $data["built_bb"] : null;
        $this->_built_xlarge = !empty($data["built_xlarge"]) ? $data["built_xlarge"] : null;
        $this->_built_large = !empty($data["built_large"]) ? $data["built_large"] : null;
        $this->_built_petite = !empty($data["built_petite"]) ? $data["built_petite"] : null;
        $this->_built_thin = !empty($data["built_thin"]) ? $data["built_thin"] : null;
        $this->_built_lm = !empty($data["built_lm"]) ? $data["built_lm"] : null;
        $this->_built_any = !empty($data["built_any"]) ? $data["built_any"] : null;
        $this->_des = !empty($data["des"]) ? $data["des"] : null;
        $this->_display_full = !empty($data["display_full"]) ? $data["display_full"] : null;
        $this->_union_sag = !empty($data["union_sag"]) ? $data["union_sag"] : null;
        $this->_union_aftra = !empty($data["union_aftra"]) ? $data["union_aftra"] : null;
        $this->_ethnicity_x_asian = !empty($data["ethnicity_x_asian"]) ? $data["ethnicity_x_asian"] : null;
        $this->_ethnicity_x_black = !empty($data["ethnicity_x_black"]) ? $data["ethnicity_x_black"] : null;
        $this->_ethnicity_x_hispanic = !empty($data["ethnicity_x_hispanic"]) ? $data["ethnicity_x_hispanic"] : null;
        $this->_ethnicity_x_white = !empty($data["ethnicity_x_white"]) ? $data["ethnicity_x_white"] : null;
        $id = static::$_mapper->save($this);

        return $id;
    }

    public static function AgeList(){

    	$age_array[ '0' ] = 'Any';
    	for( $age = 1 ; $age < 81 ; $age++ ){
    		$age_array[ $age ] = $age ;
    	}

    	return $age_array;
    }

    public static function heightList(){

    	$height_array[ '0' ] = 'Any';
    	for( $inches = 36 ; $inches < 90 ; $inches++ ){

    		$ft 	=  floor( $inches / 12 );
    		$in		=   $inches % 12;
    		$height_array[ $inches ] = $ft.'\' '.$in.' \'\''  ;
    	}

    	return $height_array;
    }

    public static function bindParams( $role , $request )
    {
    	$request->setParam( 'role_id' , $role->getRoleId());
    	$request->setParam( 'casting_id' , $role->getCastingId());
    	$request->setParam( 'gender_male' , $role->getGenderMale());
    	$request->setParam( 'gender_male' , $role->getGenderMale());
    	$request->setParam( 'gender_female' , $role->getGenderFemale());
    	$request->setParam( 'height_min' , $role->getHeightMin());
    	$request->setParam( 'height_max' , $role->getHeightMax());
    	$request->setParam( 'age_min' , $role->getAgeMin());
    	$request->setParam( 'age_max' , $role->getAgeMax());

    	return $request;
    }
}

