<?php

class Generator_Form_Factory {
	
    public static function getForms($objects = null)
    {
        foreach($objects as $object)
        {  
            $form = new Generator_Form_Generator(array(
                'name' => 'form',
                'action' => '/generator/index/generate',
                'method' => 'post'
            ));
                    
            $forms []= $form;
    	}
    	
    	$form->setDefaults($objects);
    	
    	return $forms;
    }
    
    public static function getForm()
    {
    	$form = new Generator_Form_Generator(
    	    array(
                'name' => 'form',
                'action' => '/generator/index/generate',
                'method' => 'post'
            ));
                            
        return $form;	
    }

}