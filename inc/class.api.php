<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP ;

/**
* Constructs the API.
*/
class API {

	private $log ;
	private $slim ;
	private $routeIndex ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log) {

		$this->log = $log ;

		// Initiate the slim framework.
		\Slim\Slim::registerAutoloader();
		$this->slim = new \Slim\Slim() ;

		$this->routeIndex = array() ;

	}

	/**
	* Function enableSlim
	*
	* Enables the slim instance.
	*/
	public function enableSlim() {

		$this->slim->run();

	}

	/**
	* Function addRoute
	*
	* Adds any desired route to the routeIndex which is dynamically added to the API.
	*
	* @param string $httpMethod contains the http method - i.e. get, post, put, delete.
	* @param string $requestRoute contains the url parameter which calls this route.
	* @param string $callbackMethod contains the call_user_method() compatible function name.
	*/
	public function addRoute($httpMethod, $requestRoute, $callbackMethod) {

		$this->routeIndex[] = array('httpMethod'=>$httpMethod, 'requestRoute'=>$requestRoute, 'callbackMethod'=>$callbackMethod) ;

	}

	/**
	* Function buildRoutes
	*
	* Runs the methods for building statically and dynamically created routes.
	*/
	public function buildRoutes() {

		$this->buildStaticRoutes() ;
		$this->buildDynamicRoutes() ;

	}

	/**
	* Function buildStaticRoutes
	*
	* Submits staticly programmed routes into slim.
	*/
	private function buildStaticRoutes() {

		/* EXAMPLES
		$this->slim->get('/:f1', function($f1) {

			$this->testGet1($f1) ;

		});

		$this->slim->get('/get1/:vars+', function ($vars) {
			foreach($vars as $var) {
				echo $var."<br>";
			}
		});
		*/

		$this->slim->get('/get2/:vars+', function($vars) {

			$this->testGet2($vars) ;
			$this->log->add('"/get2/:vars+" was run.', 'LOG') ;

		});


		$this->slim->post('/', function () {
			echo "This is a POST route." ;
		});

		$this->slim->put('/', function () {
			echo "This is a PUT route." ;
		});

		$this->slim->delete('/', function () {
			echo "This is a DELETE route." ;
		});

	}

	/**
	* Function buildDynamicRoutes
	*
	* Submits dynamically programmed routes into slim.
	*/
	private function buildDynamicRoutes() {

		foreach($this->routeIndex as $singleRoute) {
			if($singleRoute['httpMethod'] == 'get') {
				$this->slim->get($singleRoute['requestRoute'], $singleRoute['callbackMethod']) ;
			}
		}

	}


	/**
	* Static route functions are listed below.
	*/

	public function testGet1($f1) {
		echo "hello! " . $f1 ;
	}

	public function testGet2($vars) {
		foreach($vars as $var) {
				echo $var.", ";
			}
	}

	public function doPost($input) {

	}

	public function doPut($input) {

	}

	public function doDelete($input) {

	}

}

?>
