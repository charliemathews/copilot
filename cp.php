<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

/**
* Load all of CoPilot's classes and logic.
*/

//Script Stats
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

require_once('inc/_config.php');

require_once(SERVER_DOCRT.'/inc/class.db.php') ;
require_once(SERVER_DOCRT.'/inc/class.log.php') ;
require_once(SERVER_DOCRT.'/inc/class.data.php') ;
require_once(SERVER_DOCRT.'/inc/class.api.php');
require_once(SERVER_DOCRT.'/inc/class.api.routes.php');

//Slim Framework
require_once(SERVER_DOCRT.'/Slim/Slim.php');
\Slim\Slim::registerAutoloader();

//Copilot
/**
// At some point, remove external dependencies on $cp so that the copilot instance doesn't need to be global.
*/
require_once(SERVER_DOCRT.'/inc/class.copilot.php') ;
$cp = CP\Copilot::Instance() ;


//Script Stats
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 
$totaltime = ($endtime - $starttime);
define('SCRIPT_TIME', $totaltime) ;
//echo "This page was created in ".$totaltime." seconds";

/**
//Views / Output. Replace this with slim views.
*/
require_once(SERVER_DOCRT.'/view/splash.php');

?>
