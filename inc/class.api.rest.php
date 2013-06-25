<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP\API ;

/**
* Constructs the API.
*/
class Rest {

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$m) {

		// create new Slim framework interface object
		$this->app = new \Slim\Slim() ;

		$this->m = $m ;
		$this->m->add_method(__METHOD__) ;

	}

	/**
	* Function enable
	*
	* Loads all the paths and starts the framework environment.
	*/
	public function enable() {

		// load api routes
		$route = new Paths($this->m) ;
		$route->buildPaths($this->app) ;

		// start api
		$this->app->run();

	}

}

?>
