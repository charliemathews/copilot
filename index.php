<?php

/**
-==// Copilot //==-
*/

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

// Load copilot.
require_once('cp.php');
$__CP = CP\Copilot::Instance() ;


/* $__CP->createRoute({http request type}, {url path}, {ACTION callback function}, {REQUESTED callback function})

		{type} 		can be get, post, put, delete

		{path} 		This is what comes after "YOURURL.com/API_VERSION". for example, you could enter "/this/is/an/api/call"

		{ACTION} 	This is where you put a function callback containing whatever logic your API user is expecting to be run such as a query.

		{REQUESTED} This is where you can include an extra function callback which will run just before the rest of the call. 
					It's for including code that you're finding yourself repeating in every call, such as include() statements.
*/


$defaultPilotIncludes = function () {
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
} ;


$__CP->createRoute('get', '/users', function() use($__CP) 
{
	//require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("users", $instance->get_user_list()) ;
}, $defaultPilotIncludes);


// Needs Input.
/*
$__CP->createRoute('get', '/user/:id', function($id) use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("user", $id) ;
});
*/


$__CP->createRoute('get', '/users/technician', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("technicians", $instance->get_technician_list()) ;
});


/* Projects has session var. Also, this is changing friday the 12th to some unknown new method.

$__CP->createRoute('get', '/projects', function() use($__CP) 
	{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("projects", $instance->get_project_list()) ;
	});
*/


$__CP->createRoute('get', '/customers', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("customers", $instance->get_customer_list()) ;
});


$__CP->createRoute('get', '/definition/distance', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("distance", $instance->get_distance_list()) ;
});


$__CP->createRoute('get', '/definition/priority', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("priority", $instance->get_priority_list()) ;
});


/* Needs to be passed the current status.

$__CP->createRoute('get', '/definition/substatus', function() use($__CP) 
	{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("substatus", $instance->get_substatus_list()) ;
	});
*/


$__CP->createRoute('get', '/definition/role', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("role", $instance->get_role_list()) ;
});


$__CP->createRoute('get', '/definition/type', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("type", $instance->get_service_type_list()) ;
});


$__CP->createRoute('get', '/definition/status', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("status", $instance->get_status_list()) ;
});


$__CP->createRoute('get', '/definition/state', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("state", $instance->get_state_list()) ;
});


$__CP->createRoute('get', '/event/tabs', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("event_tabs", $instance->get_event_tabs()) ;
});


/* verify http method. add inputs for log.

$__CP->createRoute('put', '/event/log', function() use($__CP) 
	{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("event_tabs", $instance->append_to_log()) ;
	});
*/


$__CP->createRoute('get', '/definition/timezone', function() use($__CP) 
{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("timezone", $instance->get_timezone_list()) ;
});


/* Needs input.

$__CP->createRoute('get', '/definition/filetype', function() use($__CP) 
	{
	require_once(SERVER_DOCRT.'/class/class.db.php') ;
	require_once(SERVER_DOCRT.'/class/class.tss.main.php') ;
	$instance = new APP\PILOT\tss_main() ;
	$__CP->addData("filetype", $instance->get_permitted_file_extensions()) ;
	});
*/


// Enable copilot.
$__CP->ready() ;

?>
