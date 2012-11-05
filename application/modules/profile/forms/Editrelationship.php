<?php

class Profile_Form_Editrelationship extends Zend_Form
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

        $modelA = new Profiles_Model_Attributesrelationshiptypes();
        $data = $modelA->fetchAll();
        $relationships = array();
        foreach($data as $val){
            $relationships[$val->getRelationshipId()] = $val->getRelationshipType();
        }

        $model = new Profiles_Model_Attributesrelationship();
        $model->useDependents(false);
        $prop = $model->fetchAll('talentnum = '.USERID);

        $id = new Zend_Form_Element_Hidden('ids');
        $id->setValue($prop != null ? $prop->getId() : null);

        $relationship_type = new Zend_Form_Element_Select('relationship_id', array(
             'multiOptions' => $relationships,
             'value' => $prop != null ? $prop->getRelationshipId() : null
        ));
        $relationship_type->setLabel('Relationship Status');

        $submit = new Zend_Form_Element_Submit('edit_talent_attr_relationship');
        $submit->setLabel('Submit Relationship Status');
        $submit->setAttrib('class', 'but_blue');

        $this->addElements(array($id, $relationship_type, $submit));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'upload_form')),
            'Form'
        ));

    }

}