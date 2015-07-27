<?php
	
/**
   Copyright 2015 Hoist
   
   This is the sample file to how to include the Hoist SDK in your PHP application.
   
*/

	require_once 'sdk/hoist.php';
	$hoist = new Hoist();
	
	$log = function($event, $payload)
	{
	    printf("Hoist Event Run %s\r\n", $event, $payload);
	};

	$hoist->watch("PING", $log);
	
		
?>