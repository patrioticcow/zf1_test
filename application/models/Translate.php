<?php

class Application_Model_Translate{

	private $lang_file_path = NULL;
	private static $lang_instance = array();

	public static function instance(){

	}

	public static function t( $str , $path = 'common'  )
    {
        $lang = '';
		$translate = new Application_Model_Translate();

		if( ! $lang_file_source = $translate->getLangFileSource( $path ) ){
			return $str;
		}

		if( is_file( $lang_file_source ) ){

			if(  isset( self::$lang_instance[$path] ) ){
				$lang = self::$lang_instance[$path];
			}else{
				require_once( $lang_file_source );
				self::$lang_instance[$path] = $lang;
			}

			$key = trim( strtolower( $str ) );

			$translated_text = isset( $lang[$key] ) ? $lang[$key] : $str;

			return $translated_text;
		}

		return $str;

	}

	private function getLanguage(){
		// use english only for now
		return 'en';
	}

	private function getLangFileSource( $path ){

		if( ! $path ){
			return false;
		}

		$lang	=	$this->getLanguage();
		$path_segments = str_replace('.' , '/' ,  $path ).'.php';
		$this->lang_file_path = APPLICATION_PATH.'/../lang/'.$lang.'/'.$path_segments;
		$this->lang_file_path = str_replace( '\\' , '/' , $this->lang_file_path );

		return $this->lang_file_path;

	}

}