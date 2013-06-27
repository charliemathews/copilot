<?php

require_once('/cp.php');

$cp_instance = CP\Copilot::Instance() ;

function testFunc($arg1, $arg2, $arg3) {

	$cp_instance->createRoute($arg1, $arg2, $arg3) ;

}

?>
