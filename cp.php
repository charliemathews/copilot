<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

/**
* Load all of CoPilot's classes and logic.
*/

require_once('inc/_config.php');

//APP
require_once(SERVER_DOCRT.'/inc/class.db.php') ;
require_once(SERVER_DOCRT.'/inc/class.log.php') ;
require_once(SERVER_DOCRT.'/inc/class.data.php') ;

//API
require_once(SERVER_DOCRT.'/inc/class.api.rest.php');
require_once(SERVER_DOCRT.'/inc/class.api.paths.php');
require_once(SERVER_DOCRT.'/inc/class.api.paths.adapter.php');

//Slim Framework
require_once(SERVER_DOCRT.'/Slim/Slim.php');
\Slim\Slim::registerAutoloader();

//Copilot
require_once(SERVER_DOCRT.'/inc/class.copilot.php') ;
$cp = new CP\Copilot() ;

//Views / Output
require_once(SERVER_DOCRT.'/view/splash.php');

?>
