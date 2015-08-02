<?php
	
/**
  
   Copyright 2015 Hoist
   
   Sample Methods File
   
*/

	require_once 'sdk/hoist.php';
	
	$hoist = new Hoist();
	
	/** 
		Watching an event and passing it a method 
	*/
	$new_invoice = function($event, $payload)
	{
		print_r("New Invoice Event");
		print_r($payload);
	};

	$hoist->on("xero:invoice:new", $new_invoice);
	
	/**
		Raising an event with an object payload
	*/
	$pl = array('name' => 'Nick',
    'surname' => 'Doe',
    'age' => 20);

	$event_details = $hoist->raise("internal:event", $pl);
	
		
?>