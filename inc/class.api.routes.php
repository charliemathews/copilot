<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

Namespace CP\API ;

/**
* Loads, parses, and handles api route construction.
*/
class Routes {

	private $log ;
	private $slim ;
	private $routeIndex ;

	/**
	* CONSTRUCTOR
	*/
	public function __construct(&$log, &$slim) {

		$this->log = $log ;
		$this->log->add_method(__METHOD__) ;

		$this->slim = $slim ;

		$this->routeIndex = array() ;

	}

	/**

	*/
	public function addRoute($httpMethod, $requestRoute, $callbackMethod) {

		$this->routeIndex[] = array('httpmethod'=>$httpMethod, 'requestRoute'=>$requestRoute, 'callbackMethod'=>$callbackMethod) ;

	}

	/**

	*/
	public function buildRoutes() {

		$this->buildStaticRoutes() ;
		$this->buildDynamicRoutes() ;

	}

	/**

	*/
	private function buildStaticRoutes() {

		$this->slim->get('/:f1', function($f1) {

			$this->testGet1($f1) ;

		});

		$this->slim->get('/get1/:vars+', function ($vars) {
			foreach($vars as $var) {
				echo $var."<br>";
			}
		});

		//$slim->get('/get2/:vars+', array($bridge, 'testGet2') );
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

	*/
	private function buildDynamicRoutes() {

		//use $this->slim->

	}


	/**
	// Static route functions are listed below.
	*/

	public function testGet1($f1) {
		echo "hello! " . $f1 ;
	}

	public function testGet2($vars) {
		foreach($vars as $var) {
				echo $var."<br>";
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
