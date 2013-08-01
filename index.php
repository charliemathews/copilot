<?php

/**
-==// Copilot //==-
*/

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

// Load copilot.
require_once('/inc/static.cp.php');
$__CP = CP\Copilot::Instance() ;

/* $__CP->createRoute({http request type}, {url path}, {ACTION callback function}, {REQUESTED callback function})

		{type} 		can be get, post, put, delete

		{path} 		This is what comes after "YOURURL.com/API_VERSION". for example, you could enter "/this/is/an/api/call"

		{ACTION} 	This is where you put a function callback containing whatever logic your API user is expecting to be run such as a query.

		{REQUESTED} This is where you can include an extra function callback which will run just before the rest of the call. 
					It's for including code that you're finding yourself repeating in every call, such as include() statements.
*/

include('/api.php');

// Enable copilot.
$__CP->ready() ;

?>
