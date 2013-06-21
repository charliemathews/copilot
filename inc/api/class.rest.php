<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

namespace CP\API ;

/**
* Constructs the API.
*/
class Rest {

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {

		// create new Slim framework interface object
		$this->app = new \Slim\Slim() ;

		echo (DEV ? '<!-- new '.__METHOD__.' -->' . PHP_EOL : '') ;


	}

	/**
	* Function enable
	*
	* Loads all the paths and starts the framework environment.
	*/
	public function enable() {

		// load api routes
		$route = new Paths($this->app) ;

		// start api
		$this->app->run();

	}

}

?>
