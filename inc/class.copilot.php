<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Responsible for compiling responses and interpreting submissions.
*
* This class is a singleton.
*/
class Copilot {

	public $log ;
	
	private $db_local ;
	private $data ;
	public $api ;

	static private $_instance = null;

	/**
	* Copilot may only be a singleton.
	*/
	public static function & Instance() {

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {
		
		//Initiate Copilot's Core
		$this->log = new Log() ;
		$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
		$this->data = new Data($this->log) ;

		//Initiate API
		$this->api = new API\API($this->log) ;
		$this->api->buildRoutes() ;
		$this->api->enable() ;

	}

	public function __clone() {
		trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);
	}

	public function __wakeup() {
		trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
	}

}

?>
