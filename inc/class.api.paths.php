<?php

//Copyright 2013 Technical Solutions, LLC.
//Confidential & Proprietary Information.

namespace CP\API ;

/**
* Loads, parses, and handles api route construction.
*/
class Paths {

	/**
	* CONSTRUCTOR
	*/
	public function __construct() {

		$this->bridge = new Adapter() ;

	}

	public function buildPaths(&$app) {



		$app->get('/:f1', function($f1) {

			$this->bridge->testGet1($f1) ;

			return true ;

		});

		$app->get('/get1/:vars+', function ($vars) {
			foreach($vars as $var) {
				echo $var."<br>";
			}
		});

		//$app->get('/get2/:vars+', array($bridge, 'testGet2') );
		$app->get('/get2/:vars+', function($vars) {

			$this->bridge->testGet2($vars) ;

		});


		$app->post('/', function () {
			echo "This is a POST route." ;
		});

		$app->put('/', function () {
			echo "This is a PUT route." ;
		});

		$app->delete('/', function () {
			echo "This is a DELETE route." ;
		});

	}

}

// load api paths index.
		// loop through the paths index and create api paths.
		/*
		for($x = 1; $x < count($paths); $x++) {

			if($paths[$x]['method'] = 'get') {
				//$app->get('/:id', 'getItem'); /////////array($this, 'funcName')
			} elseif($paths[$x]['method'] = 'post') {
				//$app->post('/post', 'postItem');
			} elseif($paths[$x]['method'] = 'put') {
				//$app->put('/put/:id', 'putItem');
			} elseif($paths[$x]['method'] = 'delete') {
				//$app->delete('/delete/:id', 'deleteItem');
			}
		}
		*/

?>
