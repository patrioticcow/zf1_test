<?php
class Application_Model_TwitterOauth
{
	public function getCount()
	{
		//return 5000000;
		$toopen="http://twitter.com/users/show.xml?screen_name=xxx";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $toopen );
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec ($ch);
		curl_close($ch);

		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->loadXML($content);

		$count = 1512869;
		if($dom->getElementsByTagName("followers_count")->item(0) != null)
		{
			$count=$dom->getElementsByTagName("followers_count")->item(0)->nodeValue;
		}
		return $count;
	}
}