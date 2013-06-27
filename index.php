<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

// Create a copilot instance.
require_once('/cp.php');
$cp_instance = CP\Copilot::Instance() ;

/**
// Method binding test.
*/
require_once(SERVER_DOCRT.'/class/class.foo.php');
$cp_instance->api->bindMethodToRoute('get', '/get3', '\\foo()') ;


/**
// Views / Output. Replace this with slim views.
*/
if(DEV) require_once(SERVER_DOCRT.'/view/splash.php') ;

?>
