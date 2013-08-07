<?php

/**
-==// Copilot //==-
*/

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

// Load copilot.
require_once('inc/static.cp.php');
$__CP = CP\Copilot::Instance() ;

// Load api routes.
include('api.php');

// Enable copilot.
$__CP->ready() ;

?>
