<?php
/**
* cristi was here
*/
class Generator_Model_Mapper_Generator 
{

    /**
     *  {{hidden}} {{text}} {{textarea}} {{select}} {{password}} {{email}} {{zip}}
     * 
     *  the fields needs to have true or false  {{select|true}}
     */
    public function __construct()
    {
        $this->db =  Application_Model_ServiceLocator::getDb("db");
    }

    public function fetchAll($table)
    {

        $select = $this->db->select()
                     ->from('information_schema.COLUMNS', array('COLUMN_NAME', 'DATA_TYPE', 'COLUMN_COMMENT'))
                     ->where(" TABLE_NAME = '".$table."' AND COLUMN_COMMENT <> '' ");
 
        $result = $this->db->fetchAll($select);
        
        return $this->createFields($result);
        
    }
   
    protected function createFields($result)
    {
        $forms = array();
        
        foreach ($result as $key => $val)
        {
            $name       = $val->COLUMN_NAME;    // the column name ( talentnum, city, phone, ... )
            $type       = $val->COLUMN_NAME;    // int, varchat, text, etc
            $comment    = $val->COLUMN_COMMENT; // the table comment ( [select], [test], [hidden], ... )
            
            // extract the field name
            preg_match_all('~{{(.*?)}}~', $comment, $matches); // Array ( [0] => Array ( [0] => {{select}} ) [1] => Array ( [0] => select ) )
            $filedType  = $matches[1][0];

            $explode    = explode("|", $filedType);
            $field      = isset($explode[0]) ? $explode[0] : '';
            $isRequired = isset($explode[1]) ? $explode[1] : 'false';


            $forms[] = $this->formTemplate($field, $name, $isRequired);

        }
        
        
        return $forms;
    }
    
    protected function formTemplate($field, $name, $isRequired)
    {
        $getName = str_replace(" ", "", 'get'.ucwords(preg_replace('/_/', ' ', $name)));

        $str = '';
        
        if ($field == 'password')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Password("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "Password", '."\n".
                '));'."\n".
                '$'.$name.' ->setValidators( array(new Zend_Validate_Regex("~^[a-z0-9_-]{6,18}$~")) );'."\n".
                '$'.$name.' ->addErrorMessage("Password cannot be empty.");'."\n\n";
                
            $str .= 
                '$'.$name.'2 = new Zend_Form_Element_Password("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "Retype Password", '."\n".
                '));'."\n".
                '$'.$name.'2 ->setValidators( array(array("identical", false, array("token" => "join_password"))) );'."\n".
                '$'.$name.'2 ->addErrorMessage("Password cannot be empty.");'."\n\n";
        }
        
        if ($field == 'email')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Text("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "Email", '."\n".
                '));'."\n".
                '$'.$name.' ->setValidators( array(new Zend_Validate_EmailAddress()) );'."\n\n";
        }
        
        if ($field == 'zip')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Text("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "Zip Code", '."\n".
                '));'."\n".
                '$'.$name.' ->setValidators( new Zend_Validate_PostCode(array("format" => "~^([0-9]{5})(-{1}([0-9]{4}))?$~")) );'."\n".
                '$'.$name.' ->addErrorMessage("Zip code is not valid");'."\n\n";
        }

        if ($field == 'select')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Select("'.$name.'", array('."\n".
                '   "multiOptions" => array( "null" => "Select One" ), '."\n".
                '   "filters"    => array("StringTrim", "StripTags"), '."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "'.$name.'", '."\n".
                '));'."\n\n";
        }
        
        if ($field == 'text')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Text("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "'.$name.'", '."\n".
                '));'."\n\n";
        }
        
        if ($field == 'textarea')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Textarea("'.$name.'", array('."\n".
                '   "required" => '.$isRequired.', '."\n".
                '   "value" => isset($object) ? $object->'.$getName.'() : null, '."\n".
                '   "label" => "'.$name.'", '."\n".
                '   "attribs" => array("rows"=>"5", "cols"=>"90"), '."\n".
                '));'."\n\n";
        }
        
        if ($field == 'hidden')
        {
            $str .= 
                '$'.$name.' = new Zend_Form_Element_Hidden("'.$name.'");'."\n".
                '$'.$name.' ->setValue(isset($object) ? $object->'.$getName.'() : null);'."\n\n";
        }
        
        return $str;
    }

}

