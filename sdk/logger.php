<?php
	
	function logger ($log) {
	    
		date_default_timezone_set('Pacific/Auckland');
		
		file_put_contents('./log_'.date("j.n.Y").'.txt', $log.PHP_EOL, FILE_APPEND);
	
	}

?>
