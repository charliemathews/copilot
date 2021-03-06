<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.


// sudo /opt/bitnami/ctlscript.sh restart apache

define(	"APP_DOMAIN"		, 	"TS"		) ;
define(	"APP_NAME"			, 	"Copilot"	) ;
define(	"APP_VERSION"		, 	"0.11.0"	) ; // major, minor, patch (pre-1.0 is BETA)
define(	"APP_VERSION_TITLE"	, 	"dev"		) ; // dev or prod
define(	"API_VERSION"		, 	"v1"		) ;
define(	"COPYRIGHT_YEAR"	, 	"2013"		) ;

define( 'CP_DEFAULT_KEY' 	, 	'1myUyZTm28vZKqJFYTPs7ou6MOMIHu3h');

$prod_server 	= 'copilot.tsllc.net' 		;
$test_server 	= 'copilotdev.tsllc.net' 	;
$local_server 	= 'localhost' 				;

define(	"SERVER_NAME", $_SERVER['HTTP_HOST']) ;

if(SERVER_NAME == $prod_server)
{
	define(	"SERVER_DOCRT", $_SERVER['DOCUMENT_ROOT']) ;

	define(	"DEV", 		FALSE) ;
	define(	"DEV_GUI", 	FALSE) ; // This option 
	define( "DEV_MUTE", FALSE) ; // This option mute all output from copilot.

	$local_db_host 		= "" ;
	$local_db_name 		= "" ;
	$local_db_user 		= "" ;
	$local_db_pass 		= "" ;

	$db_host 			= "" ;
	$db_name 			= "" ;
	$db_user 			= "" ;
	$db_pass 			= "" ;
}
elseif(SERVER_NAME == $test_server)
{
	define(	"SERVER_DOCRT", $_SERVER['DOCUMENT_ROOT']) ;

	define(	"DEV", 		TRUE) ;
	define(	"DEV_GUI", 	FALSE) ;
	define( "DEV_MUTE", FALSE) ;

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	$local_db_host 		= "localhost:3306" ;
	$local_db_name 		= "copilot" ;
	$local_db_user 		= "admin" ;
	$local_db_pass 		= "password" ;

	$db_host 			= "mysql-pilot-dev.crfispfaqs9z.us-east-1.rds.amazonaws.com" ;
	$db_name 			= "tsspilot" ;
	$db_user 			= "tsspilot" ;
	$db_pass 			= "p!lot2013" ;
} 
elseif(SERVER_NAME == $local_server)
{
	define(	"SERVER_DOCRT", $_SERVER['DOCUMENT_ROOT'].'/copilot') ;

	define(	"DEV", 		TRUE) ;
	define(	"DEV_GUI", 	FALSE) ;
	define( "DEV_MUTE", FALSE) ;

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	$local_db_host 		= "localhost:3306" ;
	$local_db_name 		= "copilot" ;
	$local_db_user 		= "admin" ;
	$local_db_pass 		= "password" ;

	$db_host 			= "mysql-pilot-dev.crfispfaqs9z.us-east-1.rds.amazonaws.com" ;
	$db_name 			= "tsspilot" ;
	$db_user 			= "tsspilot" ;
	$db_pass 			= "p!lot2013" ;
}

// Local/DEV DB
define(	"DB_HOST_LOCAL", 		$local_db_host) ;
define(	"DB_NAME_LOCAL", 		$local_db_name) ;
define(	"DB_USER_LOCAL", 		$local_db_user) ;
define(	"DB_PASS_LOCAL", 		$local_db_pass) ;

// Production DB
define(	"DB_SERVER", 			$db_host) ;
define(	"DB_NAME", 				$db_name) ;
define(	"DB_USER", 				$db_user) ;
define(	"DB_PW", 				$db_pass) ;
define(	"DB_TIMEZONE", 			"America/New_York");

// Error Messages
define(	"ERROR_ACCESS_DENIED", 	"Access denied. This is not a public portal.");

// Log Types
define(	"CP_ERR", 				"Error"		) ;
define(	"CP_WARN",				"Warning"	) ;
define(	"CP_STATUS", 			"Status"	) ;
define(	"CP_MSG", 				"Message"	) ;

?>
