<?php
//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

require_once('quickload.php');
$routes = $__CP->returnRoutes() ;

header('Content-Type: application/json');
echo json_encode($routes) ;
?>
