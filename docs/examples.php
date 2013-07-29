<?php


require_once('cp.php') ;
$__CP = CP\Copilot::Instance() ;
include('your_api.php');
$__CP->ready() ;


include('quickload.php') ;


$__CP->createRoute(HTTP_REQUEST_TYPE, HTTP_REQUEST_ROUTE, CALLBACK_ACTION, CALLBACK_HEADER) ;


function myFunction() {

	echo $_SERVER['name'] . $_SESSION['variable'] ;

}


function myFunction($serverName, $serverFunction) {

	echo $serverName . $serverFunction ;

}


$__CP->createRoute('get', '/users/technician', function() use($__CP) 
{

	echo "this is an API callback function!" ;

}, $defaultIncludes);


?>