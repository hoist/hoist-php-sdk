<?php
   
function logger ($log) {
    
    file_put_contents('./log_'.date("j.n.Y").'.txt', $log.PHP_EOL, FILE_APPEND);
    
}

class HoistPoller {

    private $_api_key;
    private $_last_token;
    private $_base_url = 'https://api.hoi.io/events';
    private $_is_active = FALSE;

    public function HoistPoller($key) {

        //Load the API Key from api_key.txt
        //$key = trim(file_get_contents("./api_key.txt", true));
        
        $this->_api_key = $key;
        logger("Hoist Poller Constructed");
        logger("Key: ".$key);
    
    }
    
    public function start() {
        
        $_is_active = TRUE;
        $this->loop();
        
    }
    
    public function loop() {
    
        //do the poll
        $json = $this->poll($this->_api_key, $_last_token, NULL, NULL, 60000);
        //print the result
        print_r($json);
        //save the token
        $_last_token = $json->token;
        //run the loop
        $this->loop();   
    
    }
    
    private function poll($apiKey = NULL, $token = NULL, $filterBy = NULL, $filterValue = NULL, $timeoutMs = NULL) {
        
        $curl = curl_init();
        
        $url = $this->_base_url;    
        
        /* Build the headers */
        $headers = array(
            'Content-type: application/json',
            'Authorization: Hoist ' . $apiKey
        );
        print_r($headers);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        /* Build the query string */
        $data = array();
        if(isset($token)) {
            $data['token'] = $token;
        }
        if(isset($filterBy)) {
            $data['filterBy'] = $filterBy;
        }
        if(isset($filterValue)) {
            $data['filterValue'] = $filterValue;
        }
        if(isset($timeoutMs)) {
            $data['timeoutMs'] = $timeoutMs;
        }
        $querystring = http_build_query($data);
        if($querystring) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        
        curl_close($curl);
        
        logger($result);
        
        return json_decode($result);	 
    
    }


}


/** 

Execution of the poller class.

**/
logger("Poller Launched");
$hoistPoller = new HoistPoller($argv[1]);
$hoistPoller->start();


?>