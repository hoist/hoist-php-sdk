<?php

  require_once './sdk/hoist.php';

  $hoist = new Hoist();

  $url =  $hoist->getBouncerURL("xero1");

  print_r($url);

?>