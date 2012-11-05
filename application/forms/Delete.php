<?php
class Application_Form_Delete extends Zend_Form {
	
	protected $id;
	protected $action;
	protected $buttontext;
	
	public function __construct()
	{
		$options = func_get_arg(0);
		//var_dump($options); exit;
		$this->action = $options['action'];
	    $this->id = $options['_id'];
	    $this->buttontext = $options['buttontext'];
	    
	    return $this->init();
	}
	
	public function init()
    {	
    	$this->setAction($this->action);
    	
        $this->setMethod('POST'); 

        $this->addAttribs(array('class'    => 'delete_form',
                                'id'       => 'delete_form'));
            
        $this->addElement('hidden', '_id', array(
                          'value' => $this->id,
        ));
        
        $this->addElement('submit', 'delete', array(
            'required' => false,
            'ignore'   => true,
            'label'    => $this->buttontext,
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
        
        return $this;
    }
                
    /*public function init()
    {
    	$out = '<form class="delete_form" id="delete_form" action="'.$this->action.'" method="POST">';
    	$out .= '<input type="hidden" name="id" value="'.$this->id.'" />';
    	$out .= '<input type="submit" value="'.$this->buttontext.'" />';
    	$out .= '</form>';
    	
    	return $out;
    }	*/
}
