<?php

/**
-==// Copilot //==-
*/

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// Load copilot.
require_once('/cp.php');
$__CP = CP\Copilot::Instance() ;

// Method binding.
/*
$__CP->createRoute('get', '/foo/:url+', function($url) use($__CP) 
					{
					require(SERVER_DOCRT.'/class/class.foo.php') ;
					$testfoo = new app\test\foo() ;
					$testfoo->childfunctiontest() ;


					echo $_SERVER['QUERY_STRING'];

					$res = array_filter($url) ;

					$__CP->addData("foo", array($testfoo->returnLog(), $res)) ;
					}) ;
*/

$__CP->createRoute('get', '/users', function() use($__CP) 
					{
					require_once(SERVER_DOCRT.'/class/class.db.php') ;
					require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
					$instance = new APP\PILOT\tss_main() ;

					$__CP->addData("users", $instance->get_user_list()) ;
					}) ;

$__CP->createRoute('get', '/user/:id', function($id) use($__CP) 
					{
					require_once(SERVER_DOCRT.'/class/class.db.php') ;
					require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
					$instance = new APP\PILOT\tss_main() ;

					$__CP->addData("user", $id) ;
					}) ;

$__CP->createRoute('get', '/query', function() use ($__CP) {
					$__CP->addData("query", $__CP->interpretQuery($_SERVER['QUERY_STRING'])) ;
					}) ;

// Enable copilot.
$__CP->ready() ;


?>
