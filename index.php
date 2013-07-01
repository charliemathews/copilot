<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// Load copilot.
require_once('/cp.php');
$__CP = CP\Copilot::Instance() ;

// Method binding.
$__CP->createRoute('get', '/foo/:vars+', function($vars) use($__CP) 
					{ 
					require(SERVER_DOCRT.'/class/class.foo.php'); 	// include the code you want to run for this method
					$testfoo = new app\test\foo() ; 				// in this case, we create a class which was in the included code
					$testfoo->childfunctiontest() ; 				// run the desired function
					$__CP->addData("foo", $testfoo->returnLog()) ;	// add the function's output to the returning data stream


					//e.g.
					$__CP->addData("demo_thing", array(1, 2, 3, "test", $vars)) ;

					// for debugging
					$__CP->log->add(print_r($vars, true), CP_INPUT) ;
					}) ;

// Enable copilot.
$__CP->ready() ;

?>
