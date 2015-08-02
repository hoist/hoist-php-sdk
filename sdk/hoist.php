<?php

/**
   Copyright 2015 Hoist

**/

require_once 'logger.php';

class WatchMethod {

	public $_eventName;
	public $_eventMethod;
	
	public function WatchMethod($eventName, $eventMethod) {
	
		print_r(gettype($eventName).PHP_EOL);
		print_r(gettype($eventMethod).PHP_EOL);
		$this->_eventName = $eventName;
		$this->_eventMethod = $eventMethod;
		
	}
	
}


class Hoist {
	
	public $_api_key;
	private $_ENDPOINTS;
	private $_BASE_URL = 'https://api.hoi.io';
	
	public $watchMethods = [];

	public function Hoist() {
		
		//Load the API Key from api_key.txt
		$key = trim(file_get_contents("./api_key.txt", true));

		$this->_api_key = $key;
		
	}
	
	public function start() {
				
	}

	public function getBouncerURL($connectorKey, $bucketKey = NULL, $returnURL = NULL) {

		$curl = curl_init();
        
    $url = "https://bouncer.hoist.io/initiate/" . $this->_api_key . "/" . $connectorKey;    
    
    /* Build the query string */
    $data = array();
    if(isset($bucketKey)) {
        $data['bucketKey'] = $bucketKey;
    }
    if(isset($returnURL)) {
        $data['returnUrl'] = $returnURL;
    }
    $querystring = http_build_query($data);
    if($querystring) {
        $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    logger($url);
    
    $result = curl_exec($curl);
    $information = curl_getinfo($curl);

    curl_close($curl);
    
    if($information["http_code"] == 302) {
    	return $information["redirect_url"];
    } else {
	    trigger_error("Connector not found", E_USER_ERROR);
	    return FALSE;
    }

	}
	
	public function on($eventName = NULL, $method = NULL) {

		$this->watchMethods[$eventName] = $method;
			
	}
	
	public function raise($eventName = NULL, $payload) {

		// convert the payload to JSON 
		$data = json_encode($payload);

		$curl = curl_init();
        
    $url = $this->_BASE_URL . "/event/" . $eventName;    
    
    curl_setopt($curl, CURLOPT_URL, $url);

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data),
			'Authorization: Hoist ' . $this->_api_key
		));
    
    logger($url);
    
    $result = curl_exec($curl);
    $information = curl_getinfo($curl);

    curl_close($curl);
    
		logger($result);

    if($information["http_code"] == 500) {
    	return trigger_error("There was an error processing your event", E_USER_ERROR);
    } else {
      return json_decode($result);	 
    }

			
	}
	
}


?>