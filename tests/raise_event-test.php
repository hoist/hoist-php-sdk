<?php

  require_once './sdk/hoist.php';

  $hoist = new Hoist();

  $pl = array('name' => 'Nick',
    'surname' => 'Doe',
    'age' => 20);


  $internal = function($event, $payload)
  {
    print_r("New Internal Event");
    print_r($payload);
  };

  $hoist->on("internal:event", $internal);

  $eventDetails = $hoist->raise("internal:event", $pl);

  print_r($eventDetails);

?>