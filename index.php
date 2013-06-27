<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// Create a copilot instance.
require_once('/cp.php');
$cp_instance = CP\Copilot::Instance() ;

	// Method binding demos.
	require_once(SERVER_DOCRT.'/class/class.foo.php');
	//$cp_instance->createRoute('get', '/foo', 'test\foo::staticfunctiontest') ;
	$cp_instance->createRoute('get', '/foo', function(){ $testfoo = new test\foo() ; $testfoo->childfunctiontest() ; }) ;

// Enable copilot.
$cp_instance->ready() ;



/**
// Views / Output. Replace this with slim views.
*/
if(DEV) require_once(SERVER_DOCRT.'/view/splash.php') ;

?>
