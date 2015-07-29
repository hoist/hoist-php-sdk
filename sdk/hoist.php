<?php

/**
   Copyright 2015 Hoist

**/

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
		
		// $op; /* output from the command */
		// $cmd = "nohup php ./sdk/poller.php " . $this->_api_key . '> /dev/null 2>&1 & echo $!';
		
		// $commandId = exec($cmd, $op);
	
		// $this->_poller_process_id = (int)$op[0];
		// print($this->_poller_process_id);
		
	}
	
	public function stop() {
		
		//Unsupported
		logger("Warning: Currently unsupported");
			
	}
	
	public function watch($eventName = NULL, $method = NULL) {

		$this->watchMethods[$eventName] = $method;
			
	}
	
}


?>