<?php

class Profile_Form_Profile {

    public $model;

    public function __construct() {
        $this->model = new Profile_Model_Profiles;
	    $this->model->useDependents(false);
    }

    public function display( $args ) {
        $user_login = isset( $args['user_login'] ) ? $args['user_login'] : '';
        $html = '';
        if ( $user_login ) {
            $html = $this->display_talent_info( array( 'user_login' => $user_login ) );
        }
        return $html;
    }

   /**
   * Help render data to display profile data.
   */
   public function display_talent_info( $args ) {
        $user_login   = isset( $args['user_login'] ) ? $args['user_login'] : '';
        $user_profile = 'redirect';

        if ( $user_login ) {
	    $validator = new Zend_Validate_Regex('/^[aA-zZ]{1,8}$/');
	    $is_valid  = $validator->isValid( $user_login );
	    if ( $is_valid ) {
                $user_profile = $this->get_user_relations( array( 'user_login' => $user_login ) );
	    }
        }

        return $user_profile;
    }

    public function get_user_relations( $args ) {
        $user_login = isset( $args['user_login'] ) ? $args['user_login'] : '';
        $model      = $this->model;
        $data       = $model->get_talent_info( array( 'user_login' => $user_login ) );
        return $data;
    }
}
