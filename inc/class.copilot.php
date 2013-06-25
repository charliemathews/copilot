<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling responses and interpreting submissions.
*/
class Copilot {

	public $log ;
	private $data ;
	private $db_local ;
	private $api ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {
		
		//Initiate APP
		$this->log = new Log() ;
		$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
		$this->data = new Data($this->log) ;

		//Initiate API
		$this->api = new API\Rest($this->log) ;
		$this->api->enable() ;

	}

}

?>
