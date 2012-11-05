<?php
/**
 * Minify Head Javascript script files.
 * @package default
 */
class Zend_View_Helper_MinifyJs extends Zend_View_Helper_HeadScript
{
	public function minifyJs()
	{
		$scripts = array();
		foreach ($this as $item)
		{
			if ($item->type == 'text/javascript' &&
				!empty($item->attributes) &&
				!empty($item->attributes['src']))
			{
				$scripts[] = $item->attributes['src'];
			}
		}

		$item = new stdClass();
		$item->type = 'text/javascript';
		$item->attributes = array();
		$item->attributes['src'] = $this->getMinUrl() . '?f=' . implode(',', $scripts);

		return $this->itemToString($item, null, null, null);
	}

	private function getMinUrl()
	{
		return $this->getBaseUrl() . '/min/';
	}

	private function getBaseUrl()
	{
		return $this->view->baseUrl();
	}


}