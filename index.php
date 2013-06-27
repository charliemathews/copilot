<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


//Script timer.
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 



// Create a copilot instance.
require_once('/cp.php');
$cp_instance = CP\Copilot::Instance() ;



	/**
	// Method binding test.
	*/
	require_once(SERVER_DOCRT.'/class/class.foo.php');
	$cp_instance->createRoute('get', '/get3', 'test\foo::test') ;



// Enable copilot.
$cp_instance->ready() ;



//Script timer end.
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 
$totaltime = ($endtime - $starttime);
define('SCRIPT_TIME', $totaltime) ;



/**
// Views / Output. Replace this with slim views.
*/
if(DEV) require_once(SERVER_DOCRT.'/view/splash.php') ;

?>
