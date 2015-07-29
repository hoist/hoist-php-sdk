<?php
	
/**
   Copyright 2015 Hoist
   
   Sample Methods File
   
*/

	require_once 'sdk/hoist.php';
	
	$hoist = new Hoist();
	
	$log = function($event, $payload)
	{
		print_r("Ping Event");
		print_r($payload);
	};
	
	$new_invoice = function($event, $payload)
	{
		print_r("New Invoice Event");
		print_r($payload);
	};

	$hoist->watch("PING", $log);
	$hoist->watch("new:invoice", $new_invoice);
	
	
		
?>