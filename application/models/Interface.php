<?php
interface Application_Model_Interface
{
	/**
	 * This will accept an array or will assign the request params to $data array
	 * Sets all of the properties utilizing Application_Model_Proxy to set and get prop values
	 * If $data doesnot contain a property you can set it explicitly in create or modify a prop
	 * 
	 * @throws Application_Model_Exception
	 * @param array $data
	 * @return (int) $id last insert id or created id
	 */
	public function create($data = null);
}