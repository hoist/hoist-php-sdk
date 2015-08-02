# hoist-php-sdk
PHP SDK for Hoist

## API Key
Save your API Key by itself in api_key.txt in the same folder you run the php command.

## Run as a background process
```bash
nohup php ./sdk/launcher.php start ./my-hoist-methods.php > /dev/null 2>&1 & echo $!
```

Swap out `./my-hoist-methods.php` for the file you want to store your Hoist methods in. It simply does a require_once() to that argument


## Including methods for Hoist to run
```php
<?php
  
/**
  A sample Hoist Methods file
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
```