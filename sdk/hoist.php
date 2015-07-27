<?php

/**
   Copyright 2015 Hoist

**/


class Hoist {
	
	private $_api_key;
	private $_ENDPOINTS;
	private $_BASE_URL = 'https://api.hoi.io';
	
	private $_recent_token;
	private $_poller_process_id;

	public function Hoist() {
		
		//Load the API Key from api_key.txt
		$key = trim(file_get_contents("./api_key.txt", true));

		$this->_api_key = $key;
		
	}
	
	public function watch($eventName = NULL, $lambda = NULL) {
	
		$op; /* output from the command */
		$cmd = "nohup php ./sdk/poller.php " . $this->_api_key . '> /dev/null 2>&1 & echo $!';
		
		$commandId = exec($cmd, $op);
	
		$this->_poller_process_id = (int)$op[0];
		print($this->_poller_process_id);
		
	}
	
	
}


?>