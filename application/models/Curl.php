<?php
/*
 * this a curl method
 */
abstract class Application_Model_Curl
{

	public static function cURL($url, $header=NULL, $cookie=NULL, $p=NULL)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_NOBODY, $header);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		if (isset($_SERVER['HTTP_USER_AGENT'])){
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000); //amount of time that any cURL function is allowed to take to execute
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100); //maximum amount of time to wait for the connection to complete
		if ($p) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $p);
		}
		$result = curl_exec($ch);

		if ($result) {
            curl_close($ch);
			return $result;
		} else {
			//return curl_error($ch);
			curl_close($ch);
		}

        return '';

	}

}