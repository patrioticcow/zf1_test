<?php

class Application_Model_Api
{
	protected $url = 'http://secure.exploretalent.com/api/index/index';

	protected $response;

	protected $id;

	protected $apiKey = 'secret';

	//protected $login = 'api';

	//protected $pass = 'api123456';

	protected $fields = array();

	public function init($data)
	{
		//$this->fields['api_action'] = empty($data['api_action']) ? 'index' : $data['api_action'];
        $this->fields['api_key'] = $this->apiKey;
		$this->fields['id'] = !empty($data['talentnum']) ? $data['talentnum'] : null;

		$req = $this->buildRequest();

		return $response = $this->sendRequest($req);
	}

	private function buildRequest()
	{
		$string = '';
		foreach($this->fields as $key=>$value)
		{
			if(null != $value)
			    $string .= '/'.$key.'/'.$value;
		}

		$test_string = $this->url.$string; //.'/'.$string; //.'/'.$string.'<br />';
		//exit;
		return $test_string; //$string;
	}

	private function sendRequest($string)
	{
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $string);

		//curl_setopt($ch,CURLOPT_POST, count($this->fields));
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//execute post
		$response = curl_exec($ch);

		$xml = new SimpleXMLIterator($response);

		curl_close($ch);

		return $xml;
	}

}
