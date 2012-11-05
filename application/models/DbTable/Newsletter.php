<?php

class Application_Model_DbTable_Newsletter extends Zend_Db_Table_Abstract
{
    protected $_schema = 'exploretalent';
    
    protected $_name = 'newsletter';
    
    protected $_primary = 'news_letter_id';
}

