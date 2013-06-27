<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

/**
* Load all of CoPilot's classes and logic.
*/

require_once('inc/_config.php');

require_once(SERVER_DOCRT.'/inc/class.db.php') ;
require_once(SERVER_DOCRT.'/inc/class.log.php') ;
require_once(SERVER_DOCRT.'/inc/class.data.php') ;
require_once(SERVER_DOCRT.'/inc/class.api.php');

//Slim Framework
require_once(SERVER_DOCRT.'/Slim/Slim.php');

//Copilot
require_once(SERVER_DOCRT.'/inc/class.copilot.php') ;

?>
