<?php
  
  require_once 'sdk/hoist.php';
  
  $hoist = new Hoist();
  
  $new_invoice = function($event, $payload)
  {
    print_r("New Invoice Event");
    print_r($payload);
    print_r($event);
  };

  $hoist->on("new:invoice", $new_invoice);
  

?>