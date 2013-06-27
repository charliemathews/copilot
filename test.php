<?php

require_once('/cp.php');

function testFunc($arg1, $arg2, $arg3) {
	
	$cp_instance = CP\Copilot::Instance() ;

	$cp_instance->createRoute($arg1, $arg2, $arg3) ;

}

?>
