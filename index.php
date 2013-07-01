<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// Load copilot.
require_once('/cp.php');
$__CP = &CP\Copilot::Instance() ;

// Method binding.
$__CP->createRoute('get', '/foo/:vars+', function($vars) use(&$__CP) 
					{ 
					require(SERVER_DOCRT.'/class/class.foo.php'); 	// include the code you want to run for this method
					$testfoo = new app\test\foo() ; 				// in this case, we create a class which was in the included code
					$testfoo->childfunctiontest() ; 				// run the desired function

					$__CP->addData(array("ID"=>"(methodname)", "DATA"=>array(1, 2, 3, "test", $vars))) ;
					$__CP->addData(array("ID"=>"METHOD", "DATA"=>$testfoo->returnLog())) ;

					$__CP->log->add("You called the GET method. '/foo/:vars+", 'API') ;
					$__CP->log->add(print_r($vars, true), 'API') ;
					$__CP->log->add($__CP->getData(), 'API') ;
					}) ;

// Enable copilot.
$__CP->ready() ;


// Output
if(DEV) require_once(SERVER_DOCRT.'/view/splash.php') ;

?>
