<?php
/**
 * 
 * @param Zend_Db_Select $select
 * @param (int) $limit = 10;
 * 
 * Sets the paginator for any given module
 * You must access in your view using: echo $this->paginator;
 * 
 * The view partials are located in APPLICATION_PATH . '/partials' 
 * and added as a globally accessable script in the bootstrap.php
 *
 */
class Application_Model_Paginator
{
	// @param $count - can be a Zend_Db_Select or an (int) total count
    public static function setPagination($select, $limit = null)
	{
		if(null == $limit) 
		{ 
			print('You need to set a limit to use the paginator'); 
			exit; 
		}
		
        $paginator = Zend_Paginator::factory($select);
        
		$front = Zend_Controller_Front::getInstance();
		
    	$paginator->setCurrentPageNumber($front->getRequest()->getParam('page', 1));

    	$paginator->setDefaultItemCountPerPage((int) $limit);
    	
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            'pagination_control.phtml'
        );
        
        $view = Zend_Layout::getMvcInstance()->getView();
        
        $view->paginator = $paginator;
        
        return $paginator;
	}
	
	private static function getCount($params)
	{
        $item = '';

		if(isset($params['item_count']))
		{
            $item = static::$count = (int)$params['item_count'];
		}

        return $item;
	}
	
	public function button($page, $button) 
    {
        $req = Zend_Controller_Front::getInstance()->getRequest();
	
        $params = $req->getParams();
	
        $params['page'] = $page;

        
        $form = '<form action="/'.$req->getModuleName().'/'.$req->getControllerName().'/'.$req->getActionName().'/" method="POST">';

        foreach($params as $key=>$val)
        {
        	if(is_array($val))
        	{
        		foreach($val as $k=>$v)
        		{
        			$form .= '<input type="hidden" name="'.$key.'['.$k.']" value="'.$v.'" />';
        		}
        	}
	        elseif(empty($params[$key]))
	        {
		        unset($params[$key]);
	        }
	        else 
	       {
		        $form .= '<input type="hidden" name="'.$key.'" value="'.$val.'" />';          
	        }
        }
	
	    $form .= '<input style="padding:3px;border-radius:5px;" type="submit" value="'.$button.'" />';
	    
	    $form .= '</form>';
		
		return $form;
    }
}