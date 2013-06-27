<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP\API ;

/**
* Constructs the API.
*/
class API {

	private $log ;
	private $slim ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log) {

		$this->log = $log ;
		$this->log->add_method(__METHOD__) ;

		// create new Slim framework interface object
		$this->slim = new \Slim\Slim() ;

	}

	/**
	* Function enable
	*
	* Loads all the paths and starts the framework environment.
	*/
	public function enable() {

		// load api routes
		$route = new Routes($this->log, $this->slim) ;
		$route->buildRoutes() ;

		// start api
		$this->slim->run();

	}

	/**

	*/
	public function bindMethodToRoute() {

	}

}

?>
