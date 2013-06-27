<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


define("APP_NAME_PREFIX", "TS");
define("APP_NAME", "Copilot");
define("APP_VERSION", "0.4.0"); // major, minor, patch
define("APP_VERSION_TITLE", "PRE-ALPHA");
define("COPYRIGHT_YEAR", "2013");


define("SERVER_DOCRT", $_SERVER['DOCUMENT_ROOT'].'/copilot') ;
define("SERVER_NAME", $_SERVER['HTTP_HOST']) ;

$prod_server = 'copilot.tsllc.net' ;

if(SERVER_NAME == $prod_server) {


	define("DEV", FALSE) ;

	//define db here


} elseif(SERVER_NAME != $prod_server) {


	define("DEV", TRUE) ;

	error_reporting(E_ALL);

	$local_db_host = "localhost:3306" ;
	$local_db_name = "copilot" ;
	$local_db_user = "admin" ;
	$local_db_pass = "password" ;

}

define("DB_HOST_LOCAL", $local_db_host) ;
define("DB_NAME_LOCAL", $local_db_name) ;
define("DB_USER_LOCAL", $local_db_user) ;
define("DB_PASS_LOCAL", $local_db_pass) ;

define("ERROR_ACCESS_DENIED", "Access denied. This is not a public portal.");

?>
