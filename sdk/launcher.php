<?php

require_once 'hoist.php';
require_once 'poller.php';
require_once 'logger.php';

/** 

Launcher for the Hoist poller.

**/

$hoist = new Hoist();
$hoistPoller = new HoistPoller($hoist->_api_key);

if(isset($argv[1]) && $argv[1] == "start") {
    $hoist->start();
}

if(isset($argv[2])) {
    
    //Require in the methods that the user has supplied
    require_once($argv[2]);
    $hoistPoller->start($hoist->watchMethods);
    
}



?>