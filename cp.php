<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

/**
* Load all of CoPilot's classes and logic.
*/

require_once('inc/_config.php');

require_once(SERVER_DOCRT.'/inc/class.messenger.php') ;
require_once(SERVER_DOCRT.'/inc/class.postman.php') ;
require_once(SERVER_DOCRT.'/inc/api/class.rest.php');
require_once(SERVER_DOCRT.'/inc/api/class.paths.php');

//Slim Framework
require_once(SERVER_DOCRT.'/Slim/Slim.php');
\Slim\Slim::registerAutoloader();

//Copilot
require_once(SERVER_DOCRT.'/inc/class.copilot.php') ;
$cp = new CP\Copilot() ;

//Views / Output
require_once(SERVER_DOCRT.'/view/head.php');
require_once(SERVER_DOCRT.'/view/splash.php');
require_once(SERVER_DOCRT.'/view/foot.php');

?>
