<?php

class Application_Model_Users
{
    
	public static function getNameByUserId( $userid , $user_type = 'cd' , $options = array() )
	{
		
		switch( $user_type ){
			case 'producer':
				
				$producer = new Producers_Model_Producers();
				$producer = $producer->fetchAll( " producer_id = $userid " );
				
				if( isset( $options['first_name_only']) ){
					return $producer->getFirstName();	
				}
				
				if( isset( $options['last_name_only']) ){
					return $producer->getLastName();	
				}
				
				return $producer->getFirstName().' '.$producer->getLastName();
				//print_r( $producer );
				
			break;	
			case 'cd':
				$cd = new Cduser_Model_Cduser();

				$cd = $cd->fetchAll( 'user_id = '.$userid );
				
				$return = '';
				
				if($cd != null){
					$return = $cd->getFname().' '.$cd->getLname().' ( Casting Director ) '; 
				}
				
				return $return;
							
			break;	
		}
        return '';
	}
}