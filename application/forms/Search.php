<?php

class Application_Form_Search extends Zend_Form
{
    public $args;

    public function __construct()
    {
        $this->args = func_get_args();

        parent::__construct();
    }

    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/talents/index/customsearch');

        $search = new Zend_Form_Element_Text('header_search_form');

        $dropDown = new Zend_Form_Element_Select('select_category');
        $dropDown->addMultiOptions(array(
	        'auditions'=>'Auditions & Jobs', 'talents'=>'Talents', 'contestants'=>'Contestants'
        ));

        $submit = new Zend_Form_Element_Submit('search_all');
        $submit->setLabel('Search');

        $this->addElements(array($search, $dropDown, $submit));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'search_all')),
            'Form'
        ));
    }
}
