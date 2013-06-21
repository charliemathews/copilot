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
	public function __construct(&$app) {

		$app->get('/:name', function ($name) {
			echo "Hello $name" ;
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
