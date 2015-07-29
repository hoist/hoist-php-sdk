<?php
 
require_once 'logger.php';

class HoistPoller {

    private $_api_key;
    private $_last_token;
    private $_base_url = 'https://api.hoi.io/events';
    private $_watch_method_array;

    public function HoistPoller($key) {

        $this->_api_key = $key;
        logger("Hoist Poller Constructed");
        logger("Key: ".$key);
    
    }
    
    public function start($_watch_method_array) {
        
        $this->_watch_method_array = $_watch_method_array;
        $this->loop();
        
    } 
    
    public function loop() {
    
        //do the poll
        $json = $this->poll($this->_api_key, $this->_last_token, NULL, NULL, 60000);
        //print the result
        //print_r($json);
        //save the token
        $this->_last_token = $json->token;
        //process methods
        $this->process_events($json->events);
        //run the loop
        $this->loop();   
    
    }
    
    private function process_events($events) {
     
        //loop through events
        foreach ($events as $event) {
                        
            if(isset($this->_watch_method_array[$event->eventName])) {
            
                $lambda = $this->_watch_method_array[$event->eventName];
                if(isset($event->payload)) {
                    $lambda($event, $event->payload);                    
                } else {
                    $lambda($event, new stdClass());
                }
                
            }
                        
        }
        
    }
    
    private function poll($apiKey = NULL, $token = NULL, $filterBy = NULL, $filterValue = NULL, $timeoutMs = NULL) {
        
        $curl = curl_init();
        
        $url = $this->_base_url;    
        
        /* Build the headers */
        $headers = array(
            'Content-type: application/json',
            'Authorization: Hoist ' . $apiKey
        );
        
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
        
        logger($url);
        
        $result = curl_exec($curl);
        
        curl_close($curl);
        
        logger($result);
        
        return json_decode($result);	 
    
    }


}


?>