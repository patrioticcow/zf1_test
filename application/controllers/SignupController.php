<?php
include_once(__DIR__ . '/../modules/signup/forms/LoginForm.php');

class SignupController extends Zend_Controller_Action {

    public $form_obj;

    public function init() { 
        $this->form_obj = new LoginForm;
    }

    public function indexAction() {
        $form_obj = $this->form_obj;
        $post     = $this->getRequest()->getPost();

        if ( $post ) {
            $has_error = $form_obj->validate_post( $post );
            if ( sizeof( $has_error ) > 0 ) { 
              // save info and redirect.
            }
        }

        $form = $this->get_form();
        $this->view->form_html = $form;
    }

    public function get_form() { 
        $form_obj = $this->form_obj;

        $opts = array();
        $opts['talent_gender']     = $form_obj->set_dropdown( array( 'name' => 'talent_gender' ) );
        $opts['talent_feet']       = $form_obj->set_height( array( 'type' => 'talent_feet' ) );
        $opts['talent_inches']     = $form_obj->set_height( array( 'type' => 'talent_inches' ) );
        $opts['talent_ethnicity']  = $form_obj->set_dropdown( array( 'name' => 'talent_ethnicity' ) ); 
        $opts['talent_hair_color'] = $form_obj->set_dropdown( array( 'name' => 'talent_hair_color' ) ); 
        $opts['talent_eye_color']  = $form_obj->set_dropdown( array( 'name' => 'talent_eye_color' ) ); 
        $opts['talent_dob']        = $form_obj->set_talent_text( array( 'name' => 'talent_dob' ) ); 
        $opts['talent_public_age'] = $form_obj->set_dropdown( array( 'name' => 'talent_public_age' ) ); 
        $opts['talent_body_type']  = $form_obj->set_dropdown( array( 'name' => 'talent_body_type' ) ); 
        $opts['talent_email']      = $form_obj->set_email();
        $opts['talent_fname']      = $form_obj->set_talent_text( array( 'name' => 'talent_fname' ) ); 
        $opts['talent_lname']      = $form_obj->set_talent_text( array( 'name' => 'talent_lname' ) ); 
        $opts['talent_phone']      = $form_obj->set_talent_text( array( 'name' => 'talent_phone' ) ); 
        $opts['submit']            = $form_obj->submit();

        return $form_obj->render_form( $opts );
    }

}
