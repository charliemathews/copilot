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
	private $api ;

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
		
		// Core classes.
		$this->log = new Log() ;
		//$this->db_local = new DB($this->log, DB_HOST_LOCAL, DB_NAME_LOCAL, DB_USER_LOCAL, DB_PASS_LOCAL) ;
		$this->data = new Data($this->log) ;

		// API class.
		$this->api = new API($this->log) ;

	}

	public function ready() {

		$this->api->buildRoutes() ;
		$this->api->enableSlim() ;

	}

	/**
	* Function createRoute
	*
	* Public function which allows external methods to be bound to the API using api\addRoute().
	*
	* @param string $httpMethod contains the http method - i.e. get, post, put, delete.
	* @param string $requestRoute contains the url parameter which calls this route.
	* @param string $callbackMethod contains the call_user_method() compatible function name.
	*/
	public function createRoute($httpMethod, $requestRoute, $callbackMethod) {
		$this->api->addRoute($httpMethod, $requestRoute, $callbackMethod) ;
	}

	public function __clone() {
		trigger_error('Cloning instances of this class is forbidden.', E_USER_ERROR);
	}

	public function __wakeup() {
		trigger_error('Unserializing instances of this class is forbidden.', E_USER_ERROR);
	}

}

?>
