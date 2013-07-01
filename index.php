<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// Create a copilot instance.
require_once('/cp.php');
$__CP = &CP\Copilot::Instance() ;

// Method binding demos.
//$cp_instance->createRoute('get', '/foo', 'test\foo::staticfunctiontest') ;
$__CP->createRoute('get', '/foo/:vars+', function($vars) use(&$__CP){ 
																require_once(SERVER_DOCRT.'/class/class.foo.php');
																$testfoo = new app\test\foo() ; 
																$testfoo->childfunctiontest() ; 
																$__CP->log->add("You called the GET method. '/foo'", 'API') ;
																foreach($vars as $var) {
																	echo $var ;
																}
																}) ;

// Enable copilot.
$__CP->ready() ;


/**
// Views / Output. Replace this with slim views.
*/
if(DEV) require_once(SERVER_DOCRT.'/view/splash.php') ;

?>
