<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


define("APP_NAME_PREFIX", "TS");
define("APP_NAME", "Copilot");
define("APP_VERSION", "0.2.0"); // major, minor, patch
define("APP_VERSION_TITLE", "ALPHA");
define("COPYRIGHT_YEAR", "2013");


define("SERVER_DOCRT", $_SERVER['DOCUMENT_ROOT'].'/copilot') ;
define("SERVER_NAME", $_SERVER['HTTP_HOST']) ;

$prod_server = 'copilot.tsllc.net' ;

if(SERVER_NAME == $prod_server) {


	define("DEV", FALSE) ;

	//define db here


} elseif(SERVER_NAME != $prod_server) {


	define("DEV", TRUE) ;

	//define db here

}

define("ERROR_ACCESS_DENIED", "Access denied. This is not a public portal.");

?>
