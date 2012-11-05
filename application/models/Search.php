<?php

class Application_Model_Search
{
	protected static $select = null;
	
	protected static $params = array(); // params
	
	protected function buildWhere($param, $index)
	{
		if(is_array($param))
		{
			if($param[0] == 'any')
			{
				unset($param);
			}
			else
			{
			    $plist = '';
				foreach($param as $key=>$val)
				{
					static::$params[$index.$key] = $val;
					
					//$or = ($key == 0) ? '' : ' OR ';
					//$plist .= "$or$index = :$index$key"; 
					
					$or = ($key == 0) ? '' : ', ';
					$plist .= "$or:$index$key";
					
				}
				static::$select->where("$index IN ($plist)");
			}
		}
		else
		{
			if($param == 'any')
			{
				unset($param);
			}
			else
			{
			    static::$params[$index] = $param;
			    static::$select->where("$index IN(:$index)");
			}
		}
	}
	
	protected function buildMultiSelect($param, $key = null, $modifier = '=')
	{
		
	}
	
    protected function buildSelect($param, $key = null, $modifier = '=')
	{   
	
	}
	
	
	protected function buildIn($params, $key, $modifier)
	{   
		
	}
	
	protected function buildBetween(array $params, $key, $modifier)
	{
		
	}
		
	protected function buildCondition($params, $key, $modifier)
	{
		
	}
}