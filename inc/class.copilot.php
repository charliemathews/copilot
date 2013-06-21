<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling responses and interpreting submissions.
*/
class Copilot {

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {
		
		//AWAKEN THE MONSTER
		$this->msg = new Messenger() ;
		$this->post = new Postman() ;
		$this->api = new API\Rest() ;
		$this->api->enable() ;

	}

}

?>
